import { html } from '../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useEffect, useState } from '../../../shared/javascripts/vendor/haunted.js';

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";

function CountriesTable() {
    const [countries, setCountries] = useState([]);

    const scrollToAlerts = () => {
        document.getElementById("alerts").scrollIntoView({
            behavior: 'smooth', // smooth scroll
            block: 'start' // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
        });
    };

    const fetchCountries = async () => {
        try {
            const countries = await API.getAllCountries();
            setCountries(countries);
            console.debug("Fetched countries");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Countries`, err);
            console.error(`Error - Failed to Fetch Countries: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchCountries();
    }, []);

    const addCountry = async (countryToAddObj) => {
        try {
            const country = await API.addCountry(countryToAddObj);
            Alerts.success("alerts", html`<strong>Success</strong> - Added Country`, `Successfully added country "${country.name}" to the database.`);
            console.debug(`Added country: ${JSON.stringify(country)}`);
            await fetchCountries();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Country`, err);
            console.error(`Error - Failed to Add Country: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const updateCountry = async (countryToUpdateObj) => {
        try {
            const country = await API.updateCountry(countryToUpdateObj);
            Alerts.success("alerts", html`<strong>Success</strong> - Edited Country`, `Successfully edited country "${country.name}" in the database.`);
            console.debug(`Edited country: ${JSON.stringify(country)}`);
            await fetchCountries();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Country`, err);
            console.error(`Error - Failed to Edit Country: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const deleteCountry = async (countryID) => {
        try {
            const country = await API.deleteCountry(countryID);
            Alerts.success("alerts", html`<strong>Success</strong> - Deleted Country`, `Successfully deleted country "${country.name}" from the database.`);
            console.debug(`Deleted country: ${JSON.stringify(country)}`);
            await fetchCountries();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Country`, err);
            console.error(`Error - Failed to Delete Country: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const getTableHeaders = () => ["ID", "Name", "Latitude", "Longitude", "Actions"];
    const getTableRows = () => countries.map((country) => [
        country.id,
        country.name,
        country.latitude,
        country.longitude,
        html`
            <a href="/admin/super-eight-festivals/countries/${country.name}/" class="btn btn-info btn-sm">View</a>
            <button type="button" class="btn btn-primary btn-sm" @click=${() => { showModal("edit", country); }}>Edit</button>
            <button type="button" class="btn btn-danger btn-sm" @click=${() => { showModal("delete", country); }}>Delete</button>
        `
    ]);

    const showModal = (mode = "add", country = null) => {
        const modalElem = document.getElementById("country-modal");
        modalElem.dispatchEvent(new CustomEvent("modal-show", {
            detail: {
                mode,
                country,
            },
        }));
    }

    const hideModal = () => {
        const modalElem = document.getElementById("country-modal");
        modalElem.dispatchEvent(new Event("modal-hide"));
    };

    return html`
    <s8f-country-modal 
        modal-id="country-modal"
        @modal-form-submit=${async (evt) => {
        const country = evt.detail;
        if (country.id) {
            await updateCountry(country);
        } else {
            await addCountry(country);
        }
    }}
        @modal-form-delete=${async (evt) => {
        const country = evt.detail;
        if (country.id) {
            await deleteCountry(country.id);
        } else {
            await addCountry(country);
        }
    }}
    >
    </s8f-country-modal>
    <h2 class="mb-4">
        Countries 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { showModal("add"); }}
        >
            Add Country
        </button>
    </h2>
    <s8f-table 
        id="countries-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

customElements.define('s8f-countries-table', component(CountriesTable, { useShadowDOM: false }));
