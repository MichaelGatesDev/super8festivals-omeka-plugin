import { html } from '../../shared/javascripts/vendor/lit-html.js';
import { component, useEffect, useState } from '../../shared/javascripts/vendor/haunted.js';

import Alerts from "./utils/alerts";
import Modals from "./utils/modals";
import API from "./utils/api";
import Rest from "./utils/rest";

function CitiesTable(element) {
    const [country, setCountry] = useState();
    const [cities, setCities] = useState([]);
    const [modal, setModal] = useState();

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
            const cities = await API.getCities(element.countryId);
            setCities(cities);
            console.debug("Fetched cities in country");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Cities`, err);
            console.error(`Error - Failed to Fetch Cities: ${err.message}`);
        }
    };


    const addCityFromForm = async () => {
        const formData = new FormData(document.getElementById("city-form"));
        try {
            const city = await API.addCity(country.id, formData);
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

    const editCityFromForm = async (cityToEdit) => {
        const formData = new FormData(document.getElementById("city-form"));
        try {
            const city = await API.updateCity(country.id, cityToEdit.id, formData);
            Alerts.success("alerts", html`<strong>Success</strong> - Edited City`, `Successfully edited city "${city.name}" in the database.`);
            console.debug(`Edited city: ${JSON.stringify(country)}`);
            await fetchCities();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit City`, err);
            console.error(`Error - Failed to Edit City: ${err.message}`);
        } finally {
            hideModal();
            scrollToAlerts();
        }
    };

    const deleteCity = async (cityToDelete) => {
        try {
            const city = await API.deleteCity(country.id, cityToDelete.id);
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
        const tableElem = document.getElementById("countries-table");
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
                        <a href="${window.location.href}/${city.name}" class="btn btn-info btn-sm">View</a>
                        <button type="button" class="btn btn-primary btn-sm" @click=${() => { showEditDialog(city); }}>Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" @click=${() => { showDeleteDialog(city); }}>Delete</button>
                    `
                ]),
            },
        }));
    }, [cities]);


    const getCityForm = (city = null) => {
        return html`
            <form id="city-form">
                <div class="mb-3">
                    <label for="form-city-name" class="form-label">City Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="form-city-name" 
                        name="city-name" 
                        aria-describedby="formCityHelp"
                        placeholder=""
                        .value=${city ? city.name : null}
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="form-city-latitude" class="form-label">City Latitude</label>
                    <input 
                        type="number"
                        step="0.0001"
                        class="form-control" 
                        id="form-city-latitude"
                        name="city-latitude" 
                        aria-describedby="formCityHelp" 
                        placeholder="1.234"
                        .value=${city ? city.latitude : 0.00}
                     >
                </div>
                <div class="mb-3">
                    <label for="form-city-longitude" class="form-label">City Longitude</label>
                    <input 
                        type="number"
                        step="0.0001"
                        class="form-control" 
                        id="form-city-longitude"
                        name="city-longitude" 
                        aria-describedby="formCityHelp" 
                        placeholder="-4.567"
                        .value=${city ? city.longitude : 0.00}
                     >
                </div>
                <div class="mb-3">
                    <label for="form-city-description" class="form-label">City Description</label>
                    <textarea
                        id="form-city-description"
                        name="city-description" 
                        class="form-control" 
                        aria-describedby="formCityHelp" 
                        .value=${city ? city.description : null}
                    />
                </div>
            </form>
        `;
    };

    const showModal = () => {
        modal.show();
    }

    const hideModal = () => {
        modal.hide();
    };

    const showAddDialog = () => {
        Modals.update(
            modal,
            "Add City",
            getCityForm(),
            html`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" @click=${() => { addCityFromForm(); }}>Submit</button>
            `,
        );
        showModal();
    };

    const showEditDialog = (country) => {
        Modals.update(
            modal,
            "Edit City",
            getCityForm(country),
            html`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" @click=${() => { editCityFromForm(country); }}>Confirm</button>
            `,
        );
        showModal();
    };

    const showDeleteDialog = (country) => {
        Modals.update(
            modal,
            "Delete City",
            html`
                <p>Are you sure you want to delete <strong>${country.name}</strong>?</p>
                <p class="text-danger">Warning: This can not be undone.</p>
            `,
            html`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" @click=${() => { deleteCity(country); }}>Confirm</button>
            `,
        );
        showModal();
    };

    return html`
    <s8f-modal modal-id="modal" @modal-update=${(evt) => { setModal(evt.detail.modal); }}></s8f-modal>
    <h3 class="mb-4">
        Cities 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { showAddDialog(); }}
        >
            Add City
        </button>
    </h3>
    <s8f-table id="countries-table"></s8f-table>
    `;
}

CitiesTable.observedAttributes = ['country-id'];

customElements.define('s8f-cities-table', component(CitiesTable, { useShadowDOM: false }));
