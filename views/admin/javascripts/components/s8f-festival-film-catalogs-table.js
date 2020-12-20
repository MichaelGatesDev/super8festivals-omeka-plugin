import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";
import { FormAction, scrollTo } from "../../../shared/javascripts/misc.js";
import { Person } from "../utils/s8f-records.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";


function FestivalFilmCatalogsTable(element) {
    const [allContributors, setAllContributors] = useState();
    const [filmCatalogs, setFilmCatalogs] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchFilmCatalogs = async () => {
        try {
            const filmCatalog = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "festivals",
                element.festivalId,
                "film-catalogs",
            ]), HTTPRequestMethod.GET);
            setFilmCatalogs(filmCatalog);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Festival Film Catalogs`, err);
            console.error(`Error - Failed to Fetch Festival Film Catalogs: ${err.message}`);
        }
    };

    const fetchAllContributors = async () => {
        try {
            const contributors = await API.performRequest(API.constructURL([
                "contributors",
            ]), HTTPRequestMethod.GET);
            setAllContributors(_.orderBy(contributors, ["person.first_name", "person.last_name", "person.organization_name"]));
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Contributors`, err);
            console.error(`Error - Failed to Fetch Contributors: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFilmCatalogs();
        fetchAllContributors();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "festivals",
                    element.festivalId,
                    "film-catalogs",
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Update:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "festivals",
                    element.festivalId,
                    "film-catalogs",
                    formData.get("id"),
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Delete:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "festivals",
                    element.festivalId,
                    "film-catalogs",
                    formData.get("id"),
                ]), HTTPRequestMethod.DELETE);
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "linked" : "unlinked";
        let successMessage = `Successfully ${actionVerb} film catalog.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchFilmCatalogs();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("film-catalogs-form-modal");
    };

    const submitForm = (formData, action) => {
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("film-catalogs-form-modal");
        });
    };

    const validateForm = (formData) => {
        // const first_name = formData.get("first_name");
        // if (first_name.replace(/\s/g, "") === "") {
        //     return { input_name: "name", message: "First Name can not be blank!" };
        // }
        return null;
    };

    const recordIdElementObj = (record) => ({ type: "text", name: "id", value: record ? record.id : null, visible: false });
    const getFormElements = (action, filmCatalog = null) => {
        let results = [];
        if (filmCatalog) {
            results = [...results, recordIdElementObj(filmCatalog)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "Title", type: "text", name: "title", placeholder: "", value: filmCatalog ? filmCatalog.file.title : "" },
                { label: "Description", type: "text", name: "description", placeholder: "", value: filmCatalog ? filmCatalog.file.description : "" },
                {
                    label: "Contributor", name: "contributor_id", type: "select", options: ([{ id: 0 }, ...allContributors]).map((contributor) => {
                        return {
                            value: contributor.id,
                            label: contributor.id === 0 ? `None` : `${Person.getDisplayName(contributor.person)}`,
                            selected: filmCatalog ? filmCatalog.file.contributor_id === contributor.id : false,
                        };
                    }),
                },
                { label: "File", type: "file", name: "file" },
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
                form-id="film-catalogs-form"
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
        setModalTitle("Add Film Catalogs");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("film-catalogs-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (filmCatalog) => {
        setModalTitle("Edit Film Catalogs");
        setModalBody(getForm(FormAction.Update, filmCatalog));
        Modals.show_custom("film-catalogs-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (filmCatalog) => {
        setModalTitle("Delete Film Catalogs");
        setModalBody(getForm(FormAction.Delete, filmCatalog));
        Modals.show_custom("film-catalogs-form-modal");
        Alerts.clear("form-alerts");
    };


    const tableColumns = [
        { title: "ID", accessor: "id" },
        { title: "Preview", accessor: "file" },
        { title: "Title", accessor: "file.title" },
        { title: "Description", accessor: "file.description" },
    ];

    return html`
        <s8f-modal
            modal-id="film-catalogs-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Film Catalogs
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Film Catalog
            </button>
        </h2>
        <s8f-records-table
            id="film-catalogs-table"
            .tableColumns=${tableColumns}
            .tableRows=${filmCatalogs}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

FestivalFilmCatalogsTable.observedAttributes = [
    "country-id",
    "city-id",
    "festival-id",
];

customElements.define("s8f-festival-film-catalogs-table", component(FestivalFilmCatalogsTable, { useShadowDOM: false }));
