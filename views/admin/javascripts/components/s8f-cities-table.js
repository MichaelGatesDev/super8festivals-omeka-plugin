import { html, nothing } from '../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useEffect, useState } from '../../../shared/javascripts/vendor/haunted.js';

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";


const FormAction = {
    Add: "add",
    Update: "update",
}

function CitiesTable(element) {
    const [country, setCountry] = useState();
    const [cities, setCities] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();
    const [modalFooter, setModalFooter] = useState();

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

    useEffect(() => {
        fetchCountry().then(() => { fetchCities(); })
    }, []);

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
            Modals.hide_custom("city-modal");
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
            Modals.hide_custom("city-modal");
            scrollToAlerts();
        }
    };

    const deleteCity = async (cityToDeleteID) => {
        try {
            const city = await API.deleteCityFromCountry(country.id, cityToDeleteID);
            Alerts.success("alerts", html`<strong>Success</strong> - Deleted City`, `Successfully deleted city "${city.name}" from the database.`);
            console.debug(`Deleted city: ${JSON.stringify(city)}`);
            await fetchCities();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete City`, err);
            console.error(`Error - Failed to Delete City: ${err.message}`);
        } finally {
            Modals.hide_custom("city-modal");
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
            description: formData.get('description'),
        };

        if (action === FormAction.Add) {
            addCity(obj);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updateCity(obj);
        }
        Modals.hide_custom("city-modal");
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

    const getForm = (city = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${city ? html`<input type="text" class="d-none" name="id" value=${city.id} />` : nothing}
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    name="name"
                    placeholder=""
                    .value=${city ? city.name : ""}
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
                    .value=${city ? city.latitude : 0.00}
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
                    .value=${city ? city.longitude : 0.00}
                 >
            </div>
            <div class="mb-3">
                <label for="form-description" class="form-label">City Description</label>
                <textarea 
                    class="form-control" 
                    id="form-description"
                    name="description" 
                    aria-describedby="formCityHelp" 
                    placeholder="Enter a description or history about the city here. You can use HTML and CSS as well."
                    .value=${city ? city.description : ""}
                 >
            </div>
        </form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add City");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("city-modal");
    };

    const btnEditClick = (city) => {
        setModalTitle("Edit City");
        setModalBody(getForm(city));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("city-modal");
    };

    const btnDeleteClick = (city) => {
        setModalTitle("Delete City");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deleteCity(city.id); }}>Confirm</button>
        `);
        Modals.show_custom("city-modal");
    };

    const getTableHeaders = () => ["ID", "Name", "Latitude", "Longitude", "Description", "Actions"];
    const getTableRows = () => cities.map((city) => [
        city.id,
        city.name,
        city.latitude,
        city.longitude,
        city.description,
        html`
            <a href="/admin/super-eight-festivals/countries/${country.name}/cities/${city.name}/" class="btn btn-info btn-sm">View</a>
            <button type="button" class="btn btn-primary btn-sm" @click=${() => { btnEditClick(city); }}>Edit</button>
            <button type="button" class="btn btn-danger btn-sm" @click=${() => { btnDeleteClick(city); }}>Delete</button>
        `
    ]);


    if (country == null) return html`Loading...`;

    return html`
    <s8f-modal 
        modal-id="city-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
    >
    </s8f-modal>
    <h3 class="mb-2">
        Cities
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { btnAddClick(); }}
        >
            Add City
        </button>
    </h3>
    <s8f-table 
        id="cities-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

CitiesTable.observedAttributes = ['country-id'];

customElements.define('s8f-cities-table', component(CitiesTable, { useShadowDOM: false }));
