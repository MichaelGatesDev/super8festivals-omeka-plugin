import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";

import { FormAction, isValidFloat, scrollTo } from "../../../shared/javascripts/misc.js";

function CountriesTable() {
    const [countries, setCountries] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchCountries = async () => {
        try {
            const countries = await API.getCountries();
            setCountries(countries);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Countries`, err);
            console.error(`Error - Failed to Fetch Countries: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchCountries();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.addCountry(formData);
                break;
            case FormAction.Update:
                promise = API.updateCountry(formData);
                break;
            case FormAction.Delete:
                promise = API.deleteCountry(formData.get("id"));
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} country.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchCountries();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            Modals.hide_custom("form-modal");
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("form-modal");
    };

    const submitForm = (formData, action) => {
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("form-modal");
        });
    };

    const validateForm = (formData) => {
        const name = formData.get("name");
        if (name.replace(/\s/g, "") === "") {
            return { input_name: "name", message: "Name can not be blank!" };
        }
        const latitude = formData.get("latitude");
        if (!isValidFloat(latitude)) {
            return { input_name: "name", message: "Latitude is not a valid floating point number!" };
        }
        const longitude = formData.get("longitude");
        if (!isValidFloat(longitude)) {
            return { input_name: "name", message: "Longitude is not a valid floating point number!" };
        }
        return null;
    };

    const recordIdElementObj = (record) => ({ type: "text", name: "id", value: record ? record.id : null, visible: false });
    const getFormElements = (action, country = null) => {
        let results = [];
        if (country) {
            results = [...results, recordIdElementObj(country)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "Name", type: "text", name: "name", placeholder: "", value: country ? country.location.name : "" },
                { label: "Latitude", type: "number", name: "latitude", placeholder: "-1.234", value: country ? country.location.latitude : "" },
                { label: "Longitude", type: "number", name: "longitude", placeholder: "-1.234", value: country ? country.location.longitude : "" },
            ];
        } else if (action === FormAction.Delete) {
            results = [...results,
                { type: "description", value: "Are you sure you want to delete this?" },
                { type: "description", styleClasses: ["text-danger"], value: "Warning: this can not be undone." },
            ];
        }
        return results;
    };

    const getForm = (action, record = null) => {
        return html`
            <s8f-form
                form-id="country-form"
                .elements=${getFormElements(action, record)}
                .validateFunc=${action !== FormAction.Delete ? validateForm : undefined}
                .resetOnSubmit=${action === FormAction.Add}
                @cancel=${cancelForm}
                @submit=${(e) => { submitForm(e.detail, action); }}
            >
            </s8f-form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Country");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("form-modal");
    };

    const btnEditClick = (country) => {
        setModalTitle("Edit Country");
        setModalBody(getForm(FormAction.Update, country));
        Modals.show_custom("form-modal");
    };

    const btnDeleteClick = (country) => {
        setModalTitle("Delete Country");
        setModalBody(getForm(FormAction.Delete, country));
        Modals.show_custom("form-modal");
    };

    const getTableHeaders = () => ["ID", "Name", "Latitude", "Longitude", "Actions"];
    const getTableRows = () => countries.map((country) => [
        country.id,
        country.location.name,
        country.location.latitude,
        country.location.longitude,
        html`
            <a href="/admin/super-eight-festivals/countries/${country.location.name}/" class="btn btn-info btn-sm">View</a>
            <button type="button" class="btn btn-primary btn-sm" @click=${() => { btnEditClick(country); }}>Edit</button>
            <button type="button" class="btn btn-danger btn-sm" @click=${() => { btnDeleteClick(country); }}>Delete</button>
        `,
    ]);

    return html`
        <s8f-modal
            modal-id="form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
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

customElements.define("s8f-countries-table", component(CountriesTable, { useShadowDOM: false }));
