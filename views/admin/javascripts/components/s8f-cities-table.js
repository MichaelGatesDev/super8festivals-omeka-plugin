import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";

import { FormAction, isValidFloat, openLink, scrollTo } from "../../../shared/javascripts/misc.js";
import { eventBus, S8FEvent } from "../../../shared/javascripts/event-bus.js";


function CitiesTable(element) {
    const [country, setCountry] = useState();
    const [cities, setCities] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchCountry = async () => {
        try {
            const country = await API.performRequest(API.constructURL(["countries", element.countryId]), HTTPRequestMethod.GET);
            setCountry(country);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Country`, err);
            console.error(`Error - Failed to Fetch Country: ${err.message}`);
        }
    };
    const fetchCities = async () => {
        try {
            const cities = await API.performRequest(API.constructURL(["countries", element.countryId, "cities"]), HTTPRequestMethod.GET);
            setCities(_.orderBy(cities, ["location.name", "id"]));
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Cities`, err);
            console.error(`Error - Failed to Fetch Cities: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchCountry().then(() => { fetchCities(); });
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.performRequest(API.constructURL(["countries", element.countryId, "cities"]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Update:
                promise = API.performRequest(API.constructURL(["countries", element.countryId, "cities", formData.get("id")]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Delete:
                promise = API.performRequest(API.constructURL(["countries", element.countryId, "cities", formData.get("id")]), HTTPRequestMethod.DELETE);
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} city.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchCities();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("cities-form-modal");
    };

    const submitForm = (formData, action) => {
        eventBus.dispatch(S8FEvent.RequestFormSubmit);
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("cities-form-modal");
        }).finally(() => {
            eventBus.dispatch(S8FEvent.CompleteFormSubmit);
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
    const getFormElements = (action, city = null) => {
        let results = [];
        if (city) {
            results = [...results, recordIdElementObj(city)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "Name", type: "text", name: "name", placeholder: "", value: city ? city.location.name : "" },
                { label: "Latitude", type: "number", name: "latitude", placeholder: "-1.234", value: city ? city.location.latitude : 0 },
                { label: "Longitude", type: "number", name: "longitude", placeholder: "-1.234", value: city ? city.location.longitude : 0 },
                { label: "Description", type: "textarea", name: "description", placeholder: "Enter info about the city here", value: city ? city.location.description : "" },
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
                form-id="city-form"
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
        setModalTitle("Add City");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("cities-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (city) => {
        setModalTitle("Edit City");
        setModalBody(getForm(FormAction.Update, city));
        Modals.show_custom("cities-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (city) => {
        setModalTitle("Delete City");
        setModalBody(getForm(FormAction.Delete, city));
        Modals.show_custom("cities-form-modal");
        Alerts.clear("form-alerts");
    };

    const tableColumns = [
        { title: "ID", accessor: "id" },
        { title: "Name", accessor: "location.name" },
        { title: "Latitude", accessor: "location.latitude" },
        { title: "Longitude", accessor: "location.longitude" },
    ];
    return html`
        <s8f-modal
            modal-id="cities-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Cities
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add City
            </button>
        </h2>
        <s8f-records-table
            id="cities-table"
            .tableColumns=${tableColumns}
            .tableRows=${cities}
            .rowViewFunc=${(record) => { openLink(`/admin/super-eight-festivals/countries/${element.countryId}/cities/${record.location.name}/`); }}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

CitiesTable.observedAttributes = ["country-id"];

customElements.define("s8f-cities-table", component(CitiesTable, { useShadowDOM: false }));
