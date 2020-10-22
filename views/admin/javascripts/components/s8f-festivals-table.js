import { html, nothing } from '../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useEffect, useState } from '../../../shared/javascripts/vendor/haunted.js';

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";
import { isNumeric } from "../../../shared/javascripts/vendor/bootstrap/js/popper-utils";


const FormAction = {
    Add: "add",
    Update: "update",
}


function FestivalsTable(element) {
    const [country, setCountry] = useState();
    const [city, setCity] = useState();
    const [festivals, setFestivals] = useState([]);
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
            Modals.hide_custom("festival-modal");
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
            Modals.hide_custom("festival-modal");
            scrollToAlerts();
        }
    };

    const deleteFestival = async (festivalID) => {
        try {
            const festival = await API.deleteFestival(festivalID);
            Alerts.success("alerts", html`<strong>Success</strong> - Deleted Festival`, `Successfully deleted festival "${festival.year}" from the database.`);
            console.debug(`Deleted festival: ${JSON.stringify(festival)}`);
            await fetchFestivals();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Festival`, err);
            console.error(`Error - Failed to Delete Festival: ${err.message}`);
        } finally {
            Modals.hide_custom("festival-modal");
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
            year: formData.get('year'),
        };

        if (action === FormAction.Add) {
            addFestival(obj);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updateFestival(obj);
        }
        Modals.hide_custom("festival-modal");
    };


    const validateForm = () => {
        const formData = new FormData(document.getElementById("form"))
        // const id = formData.get('id');
        const year = formData.get('year');
        if (year != 0 && `${year}`.length != 4) {
            return { valid: false, problematic_input: "year", message: "Invalid year!" };
        }
        return { valid: true };
    };

    const getForm = (festival = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${festival ? html`<input type="text" class="d-none" name="id" value=${festival.id} />` : nothing}
            <div class="mb-3">
                <label for="form-year" class="form-label">Festival Year</label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="form-year" 
                    name="year" 
                    aria-describedby="formFestivalHelp"
                    placeholder=""
                    .value=${festival ? festival.year : 0}
                >
            </div>
        </form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Festival");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("festival-modal");
    };

    const btnEditClick = (festival) => {
        setModalTitle("Edit Festival");
        setModalBody(getForm(festival));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("festival-modal");
    };

    const btnDeleteClick = (festival) => {
        setModalTitle("Delete Festival");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deleteFestival(festival.id); }}>Confirm</button>
        `);
        Modals.show_custom("festival-modal");
    };

    const getTableHeaders = () => ["ID", "Year", "Actions"];
    const getTableRows = () => festivals.map((festival) => [
        festival.id,
        festival.year === 0 ? "N/A" : festival.year,
        html`
            <a href="/admin/super-eight-festivals/countries/${country.name}/cities/${city.name}/festivals/${festival.id}" class="btn btn-info btn-sm">View</a>
            <button type="button" class="btn btn-primary btn-sm" @click=${() => { btnEditClick(festival); }}>Edit</button>
            <button type="button" class="btn btn-danger btn-sm" @click=${() => { btnDeleteClick(festival); }}>Delete</button>
        `
    ]);


    if (!country || !city) return html`Loading...`;

    return html`
    <s8f-modal 
        modal-id="festival-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
    >
    </s8f-modal>
    <h3 class="mb-2">
        Festivals
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { btnAddClick(); }}
        >
            Add Festival
        </button>
    </h3>
    <s8f-table 
        id="festivals-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

FestivalsTable.observedAttributes = ['country-id', 'city-id'];

customElements.define('s8f-festivals-table', component(FestivalsTable, { useShadowDOM: false }));
