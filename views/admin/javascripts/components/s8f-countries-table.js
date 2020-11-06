import { html, nothing } from '../../../shared/javascripts/vendor/lit-html.js';
import { component, useEffect, useState } from '../../../shared/javascripts/vendor/haunted.js';

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";


const FormAction = {
    Add: "add",
    Update: "update",
}

function CountriesTable() {
    const [countries, setCountries] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();
    const [modalFooter, setModalFooter] = useState();

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
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Added Country
                `,
                `Successfully added country "${country.name}" to the database.`
            );
            console.debug(`Added country: ${JSON.stringify(country)}`);
            await fetchCountries();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Country`, err);
            console.error(`Error - Failed to Add Country: ${err.message}`);
        } finally {
            Modals.hide_custom("country-modal");
            scrollToAlerts();
        }
    };

    const updateCountry = async (countryToUpdateObj) => {
        try {
            const country = await API.updateCountry(countryToUpdateObj);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Edited Country
                `,
                `Successfully edited country "${country.name}" in the database.`
            );
            console.debug(`Edited country: ${JSON.stringify(country)}`);
            await fetchCountries();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Country`, err);
            console.error(`Error - Failed to Edit Country: ${err.message}`);
        } finally {
            Modals.hide_custom("country-modal");
            scrollToAlerts();
        }
    };

    const deleteCountry = async (countryID) => {
        try {
            const country = await API.deleteCountry(countryID);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Deleted Country
                `,
                `Successfully deleted country "${countryID}" from the database.`
            );
            console.debug(`Deleted country: ${JSON.stringify(country)}`);
            await fetchCountries();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Country`, err);
            console.error(`Error - Failed to Delete Country: ${err.message}`);
        } finally {
            Modals.hide_custom("country-modal");
            scrollToAlerts();
        }
    };

    const submitForm = (action) => {
        const formData = new FormData(document.getElementById("form"))
        const formResult = validateForm();
        if (!formResult.valid) {
            console.error(`${formResult.problematic_input}: ${formResult.message}`);
            // TODO show validation results on form
            return;
        }

        const obj = {
            id: formData.get('id'),
            name: formData.get('name'),
            latitude: formData.get('latitude'),
            longitude: formData.get('longitude'),
        };

        if (action === FormAction.Add) {
            addCountry(obj);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updateCountry(obj);
        }
        Modals.hide_custom("country-modal");
    };


    const validateForm = () => {
        const formData = new FormData(document.getElementById("form"))
        // const id = formData.get('id');
        const name = formData.get('name');
        if (name.replace(/\s/g, "") === "") {
            return { valid: false, problematic_input: "name", message: "Can not be blank!" };
        }
        return { valid: true };
    };

    const getForm = (country = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${country ? html`<input type="text" class="d-none" name="id" value=${country.id} />` : nothing}
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    name="name"
                    placeholder=""
                    .value=${country ? country.name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="form-latitude" class="form-label">City Latitude</label>
                <input 
                    type="number"
                    step="0.0001"
                    class="form-control" 
                    id="form-latitude"
                    name="latitude" 
                    aria-describedby="formCityHelp" 
                    placeholder="-4.567"
                    .value=${country ? country.latitude : 0.00}
                 >
            </div>
            <div class="mb-3">
                <label for="form-longitude" class="form-label">City Longitude</label>
                <input 
                    type="number"
                    step="0.0001"
                    class="form-control" 
                    id="form-longitude"
                    name="longitude" 
                    aria-describedby="formCityHelp" 
                    placeholder="-4.567"
                    .value=${country ? country.longitude : 0.00}
                 >
            </div>
        </form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Country");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("country-modal");
    };

    const btnEditClick = (country) => {
        setModalTitle("Edit Country");
        setModalBody(getForm(country));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("country-modal");
    };

    const btnDeleteClick = (country) => {
        setModalTitle("Delete Country");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deleteCountry(country.id); }}>Confirm</button>
        `);
        Modals.show_custom("country-modal");
    };

    const getTableHeaders = () => ["ID", "Name", "Latitude", "Longitude", "Actions"];
    const getTableRows = () => countries.map((country) => [
        country.id,
        country.name,
        country.latitude,
        country.longitude,
        html`
            <a href="/admin/super-eight-festivals/countries/${country.name}/" class="btn btn-info btn-sm">View</a>
            <button type="button" class="btn btn-primary btn-sm" @click=${() => { btnEditClick(country); }}>Edit</button>
            <button type="button" class="btn btn-danger btn-sm" @click=${() => { btnDeleteClick(country); }}>Delete</button>
        `
    ]);

    return html`
    <s8f-modal 
        modal-id="country-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
    >
    </s8f-modal>
    <h2 class="mb-4">
        Countries 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { btnAddClick(); }}
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
