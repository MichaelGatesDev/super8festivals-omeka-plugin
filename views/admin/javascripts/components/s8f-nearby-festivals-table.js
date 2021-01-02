import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";
import { FormAction, openLink, scrollTo } from "../../../shared/javascripts/misc.js";


function NearbyFestivalsTable(element) {
    const [festivals, setFestivals] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchFestivals = async () => {
        try {
            const festivals = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "nearby-festivals",
            ]), HTTPRequestMethod.GET);
            setFestivals(festivals);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Nearby Festivals`, err);
            console.error(`Error - Failed to Fetch Nearby Festivals: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFestivals();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.performRequest(
                    API.constructURL(
                        [
                            "countries",
                            element.countryId,
                            "cities",
                            element.cityId,
                            "nearby-festivals",
                        ],
                    ),
                    HTTPRequestMethod.POST,
                    formData,
                );
                break;
            case FormAction.Update:
                promise = API.performRequest(
                    API.constructURL(
                        [
                            "countries",
                            element.countryId,
                            "cities",
                            element.cityId,
                            "nearby-festivals",
                            formData.get("id"),
                        ],
                    ),
                    HTTPRequestMethod.POST,
                    formData,
                );
                break;
            case FormAction.Delete:
                promise = API.performRequest(
                    API.constructURL(
                        [
                            "countries",
                            element.countryId,
                            "cities",
                            element.cityId,
                            "nearby-festivals",
                            formData.get("id"),
                        ],
                    ),
                    HTTPRequestMethod.DELETE,
                );
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} festival.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchFestivals();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("nearby-festivals-form-modal");
    };

    const submitForm = (formData, action) => {
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("nearby-festivals-form-modal");
        });
    };

    const validateForm = (formData) => {
        const year = formData.get("year");
        if (isNaN(year) || ((Number.parseInt(year) !== 0 && year.length !== 4))) {
            return { input_name: "year", message: "Year is invalid! Must be a 4-digit number." };
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
                { label: "Year", type: "number", name: "year", placeholder: "", value: city ? city.year : null },
                { label: "City Name", type: "text", name: "name", placeholder: "", value: city ? city.city_name : "" },
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
                form-id="nearby-festival-form"
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
        setModalTitle("Add Nearby Festival");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("nearby-festivals-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (festival) => {
        setModalTitle("Edit Nearby Festival");
        setModalBody(getForm(FormAction.Update, festival));
        Modals.show_custom("nearby-festivals-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (festival) => {
        setModalTitle("Delete Nearby Festival");
        setModalBody(getForm(FormAction.Delete, festival));
        Modals.show_custom("nearby-festivals-form-modal");
        Alerts.clear("form-alerts");
    };

    const tableColumns = [
        { title: "ID", accessor: "id" },
        { title: "Year", accessor: "year" },
        { title: "City Name", accessor: "city_name" },
    ];
    return html`
        <s8f-modal
            modal-id="nearby-festivals-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Nearby Festivals
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Nearby Festival
            </button>
        </h2>
        <s8f-records-table
            id="nearby-festivals-table"
            .tableColumns=${tableColumns}
            .tableRows=${festivals}
            .rowViewFunc=${(record) => { openLink(`/admin/super-eight-festivals/countries/${element.countryId}/cities/${element.cityId}/nearby-festivals/${record.id}/`); }}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

NearbyFestivalsTable.observedAttributes = [
    "country-id",
    "city-id",
];

customElements.define("s8f-nearby-festivals-table", component(NearbyFestivalsTable, { useShadowDOM: false }));
