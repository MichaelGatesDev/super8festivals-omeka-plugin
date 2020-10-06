import { html } from '../../../shared/javascripts/vendor/lit-html.js';
import { component, useEffect, useState } from '../../../shared/javascripts/vendor/haunted.js';

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";

function CitiesTable(element) {
    const [country, setCountry] = useState();
    const [cities, setCities] = useState([]);

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
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Countries`, err);
            console.error(`Error - Failed to Fetch Countries: ${err.message}`);
        }
    };

    const fetchCities = async () => {
        try {
            const cities = await API.getCitiesInCountry(element.countryId);
            setCities(cities);
            console.debug("Fetched cities in country");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Cities`, err);
            console.error(`Error - Failed to Fetch Cities: ${err.message}`);
        }
    };


    const addCity = async (cityToAddObj) => {
        try {
            const city = await API.addCityToCountry(country.id, cityToAddObj);
            Alerts.success("alerts", html`<strong>Success</strong> - Added City`, `Successfully added city "${city.name}" to the database.`);
            console.debug(`Added city: ${JSON.stringify(city)}`);
            await fetchCities();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add City`, err);
            console.error(`Error - Failed to Add City: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const updateCity = async (cityToUpdateObj) => {
        try {
            const city = await API.updateCityInCountry(country.id, cityToUpdateObj);
            Alerts.success("alerts", html`<strong>Success</strong> - Edited City`, `Successfully edited city "${city.name}" in the database.`);
            console.debug(`Edited city: ${JSON.stringify(city)}`);
            await fetchCities();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit City`, err);
            console.error(`Error - Failed to Edit City: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const deleteCity = async (cityToDeleteObj) => {
        try {
            const city = await API.deleteCityFromCountry(country.id, cityToDeleteObj.id);
            Alerts.success("alerts", html`<strong>Success</strong> - Deleted City`, `Successfully deleted city "${city.name}" from the database.`);
            console.debug(`Deleted city: ${JSON.stringify(city)}`);
            await fetchCities();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete City`, err);
            console.error(`Error - Failed to Delete City: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    useEffect(async () => {
        // grab data
        setTimeout(async () => {
            await fetchCountry();
            await fetchCities();
        }, 0);
    }, []);

    useEffect(() => {
        const tableElem = document.getElementById("cities-table");
        if(!tableElem) return;
        tableElem.dispatchEvent(new CustomEvent("s8f-table-change", {
            bubbles: true, // this lets the event bubble up through the DOM
            composed: true, // this lets the event cross the Shadow DOM boundary
            detail: {
                headers: ["ID", "Name", "Latitude", "Longitude", "Description", "Actions"],
                rows: cities.map((city) => [
                    city.id,
                    city.name,
                    city.latitude,
                    city.longitude,
                    city.description,
                    html`
                        <a href="/admin/super-eight-festivals/countries/${country.name}/cities/${city.name}/" class="btn btn-info btn-sm">View</a>
                        <button type="button" class="btn btn-primary btn-sm" @click=${() => { showModal("edit", city); }}>Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" @click=${() => { showModal("delete", city); }}>Delete</button>
                    `
                ]),
            },
        }));
    }, [cities]);


    const showModal = (mode = "add", city = null) => {
        const modalElem = document.getElementById("city-modal");
        modalElem.dispatchEvent(new CustomEvent("modal-show", {
            detail: {
                mode,
                city,
            },
        }));
    }

    const hideModal = () => {
        const modalElem = document.getElementById("city-modal");
        modalElem.dispatchEvent(new Event("modal-hide"));
    };


    if (country == null) return html`Loading...`;

    return html`
    <s8f-city-modal 
        modal-id="city-modal"
        @modal-form-submit=${async (evt) => {
        const city = evt.detail;
        if (city.id) {
            await updateCity(city);
        } else {
            await addCity(city);
        }
    }}
        @modal-form-delete=${async (evt) => {
        const city = evt.detail;
        if (city.id) {
            await deleteCity(city);
        } else {
            await addCity(city);
        }
    }}
    >
    </s8f-city-modal>
    <h3 class="mb-2">
        Cities
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { showModal("add"); }}
        >
            Add City
        </button>
    </h3>
    <p class="text-muted">
       Here are a list of cities in <span class="text-capitalize">${country.name}</span>.
    </p>
    <s8f-table id="cities-table"></s8f-table>
    `;
}

CitiesTable.observedAttributes = ['country-id'];

customElements.define('s8f-cities-table', component(CitiesTable, { useShadowDOM: false }));
