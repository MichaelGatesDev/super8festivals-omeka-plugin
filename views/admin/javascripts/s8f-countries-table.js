import { html } from '../../shared/javascripts/vendor/lit-html.js';
import { component, useEffect, useState } from '../../shared/javascripts/vendor/haunted.js';

import Alerts from "./utils/alerts";
import Modals from "./utils/modals";
import API from "./utils/api";

function CountriesTable() {
    const [countries, setCountries] = useState([]);
    const [modal, setModal] = useState();

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

    const addCountryFromForm = async () => {
        const formData = new FormData(document.getElementById("country-form"));
        try {
            const country = await API.addCountry(formData);
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

    const editCountryFromForm = async (countryToEdit) => {
        const formData = new FormData(document.getElementById("country-form"));
        try {
            const country = await API.updateCountry(countryToEdit, formData);
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

    const deleteCountry = async (countryToDelete) => {
        try {
            const country = await API.deleteCountry(countryToDelete);
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

    useEffect(async () => {
        // grab data
        setTimeout(async () => {
            await fetchCountries();
        }, 0);
    }, []);

    useEffect(() => {
        const tableElem = document.getElementById("countries-table");
        tableElem.dispatchEvent(new CustomEvent("s8f-table-change", {
            bubbles: true, // this lets the event bubble up through the DOM
            composed: true, // this lets the event cross the Shadow DOM boundary
            detail: {
                headers: ["ID", "Name", "Latitude", "Longitude", "Actions"],
                rows: countries.map((country) => [
                    country.id,
                    country.name,
                    country.latitude,
                    country.longitude,
                    html`
                        <a href="${window.location.href}/${country.name}" class="btn btn-info btn-sm">View</a>
                        <button type="button" class="btn btn-primary btn-sm" @click=${() => { showEditDialog(country); }}>Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" @click=${() => { showDeleteDialog(country); }}>Delete</button>
                    `
                ]),
            },
        }));
    }, [countries]);

    const getCountryForm = (country = null) => {
        return html`
            <form id="country-form">
                <div class="mb-3">
                    <label for="form-country-name" class="form-label">Country Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="form-country-name" 
                        name="country-name" 
                        aria-describedby="formCountryHelp"
                        .value=${country ? country.name : null}
                    >
                </div>
                <div class="mb-3">
                    <label for="form-country-latitude" class="form-label">Country Latitude</label>
                    <input 
                        type="number"
                        step="0.0001"
                        class="form-control" 
                        id="form-country-latitude"
                        name="country-latitude" 
                        aria-describedby="formCountryHelp"
                     >
                </div>
                <div class="mb-3">
                    <label for="form-country-longitude" class="form-label">Country Longitude</label>
                    <input 
                        type="number"
                        step="0.0001"
                        class="form-control" 
                        id="form-country-longitude"
                        name="country-longitude" 
                        aria-describedby="formCountryHelp"
                        .value=${country ? country.longitude : 0}
                     >
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
            "Add Country",
            getCountryForm(),
            html`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" @click=${() => { addCountryFromForm(); }}>Submit</button>
            `,
        );
        showModal();
    };

    const showEditDialog = (country) => {
        Modals.update(
            modal,
            "Edit Country",
            getCountryForm(country),
            html`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" @click=${() => { editCountryFromForm(country); }}>Confirm</button>
            `,
        );
        showModal();
    };

    const showDeleteDialog = (country) => {
        Modals.update(
            modal,
            "Delete Country",
            html`
                <p>Are you sure you want to delete <strong>${country.name}</strong>?</p>
                <p class="text-danger">Warning: This can not be undone.</p>
            `,
            html`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" @click=${() => { deleteCountry(country); }}>Confirm</button>
            `,
        );
        showModal();
    };

    return html`
    <s8f-modal modal-id="modal" @modal-update=${(evt) => { setModal(evt.detail.modal); }}></s8f-modal>
    <h2 class="mb-4">
        Countries 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { showAddDialog(); }}
        >
            Add Country
        </button>
    </h2>
    <s8f-table id="countries-table"></s8f-table>
    `;
}

customElements.define('s8f-countries-table', component(CountriesTable, { useShadowDOM: false }));
