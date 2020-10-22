import { html } from '../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useEffect, useState } from '../../../shared/javascripts/vendor/haunted.js';

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";

function CitiesTable(element) {
    const [country, setCountry] = useState();
    const [city, setCity] = useState();
    const [festivals, setFestivals] = useState([]);

    const scrollToAlerts = () => {
        document.getElementById("alerts").scrollIntoView({
            behavior: 'smooth', // smooth scroll
            block: 'start' // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
        });
    };

    const fetchCountry = async () => {
        try {
            const country = await API.getCountry(element.countryId);
            setCountry(country);
            console.debug("Fetched country");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Country`, err);
            console.error(`Error - Failed to Fetch Countries: ${err.message}`);
        }
    };

    const fetchCity = async () => {
        try {
            const city = await API.getCityInCountry(element.countryId, element.cityId);
            setCity(city);
            console.debug("Fetched city");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch City`, err);
            console.error(`Error - Failed to Fetch City: ${err.message}`);
        }
    };

    const fetchFestivals = async () => {
        try {
            const festivals = await API.getAllFestivalsInCity(element.cityId);
            setFestivals(festivals);
            console.debug("Fetched festivals in city");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Festivals`, err);
            console.error(`Error - Failed to Fetch Festivals: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchCountry().then(() => {
            return fetchCity();
        }).then(() => {
            return fetchFestivals();
        });
    }, []);

    const addFestival = async (festivalToAddObj) => {
        try {
            const festival = await API.addFestival(city.id, festivalToAddObj);
            Alerts.success("alerts", html`<strong>Success</strong> - Added Festival`, `Successfully added festival "${festival.year}" to the database.`);
            console.debug(`Added festival: ${JSON.stringify(festival)}`);
            await fetchFestivals();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Festival`, err);
            console.error(`Error - Failed to Add Festival: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const updateFestival = async (festivalToUpdateObj) => {
        try {
            const festival = await API.updateFestival(festivalToUpdateObj);
            Alerts.success("alerts", html`<strong>Success</strong> - Edited Festival`, `Successfully edited festival "${festival.year}" in the database.`);
            console.debug(`Edited festival: ${JSON.stringify(festival)}`);
            await fetchFestivals();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Festival`, err);
            console.error(`Error - Failed to Edit Festival: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const deleteFestival = async (festivalToDeleteObj) => {
        try {
            const festival = await API.deleteFestival(festivalToDeleteObj.id);
            Alerts.success("alerts", html`<strong>Success</strong> - Deleted Festival`, `Successfully deleted festival "${festival.year}" from the database.`);
            console.debug(`Deleted festival: ${JSON.stringify(festival)}`);
            await fetchFestivals();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Festival`, err);
            console.error(`Error - Failed to Delete Festival: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const getTableHeaders = () => ["ID", "Year", "Actions"];
    const getTableRows = () => festivals.map((festival) => [
        festival.id,
        festival.year === 0 ? "N/A" : festival.year,
        html`
            <a href="/admin/super-eight-festivals/countries/${country.name}/cities/${city.name}/festivals/${festival.id}" class="btn btn-info btn-sm">View</a>
            <button type="button" class="btn btn-primary btn-sm" @click=${() => { showModal("edit", festival); }}>Edit</button>
            <button type="button" class="btn btn-danger btn-sm" @click=${() => { showModal("delete", festival); }}>Delete</button>
        `
    ]);

    const showModal = (mode = "add", festival = null) => {
        const modalElem = document.getElementById("festival-modal");
        modalElem.dispatchEvent(new CustomEvent("modal-show", {
            detail: {
                mode,
                festival,
            },
        }));
    }

    const hideModal = () => {
        const modalElem = document.getElementById("festival-modal");
        modalElem.dispatchEvent(new Event("modal-hide"));
    };


    if (!country || !city) return html`Loading...`;

    return html`
    <s8f-festival-modal 
        modal-id="festival-modal"
        @modal-form-submit=${async (evt) => {
        const festival = evt.detail;
        if (festival.id) {
            await updateFestival(festival);
        } else {
            await addFestival(festival);
        }
    }}
        @modal-form-delete=${async (evt) => {
        const festival = evt.detail;
        if (festival.id) {
            await deleteFestival(festival);
        } else {
            await addFestival(festival);
        }
    }}
    >
    </s8f-festival-modal>
    <h3 class="mb-2">
        Festivals
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { showModal("add"); }}
        >
            Add Festival
        </button>
    </h3>
    <p class="text-muted">
       Here are a list of festivals in <span class="text-capitalize">${city.name}, ${country.name}</span>.
    </p>
    <s8f-table 
        id="festivals-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

CitiesTable.observedAttributes = ['country-id', 'city-id'];

customElements.define('s8f-festivals-table', component(CitiesTable, { useShadowDOM: false }));
