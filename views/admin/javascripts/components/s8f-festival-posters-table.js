import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";
import { FormAction, isEmptyString, scrollTo } from "../../../shared/javascripts/misc.js";


function FestivalPostersTable(element) {
    const [posters, setPosters] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchPosters = async () => {
        try {
            const posters = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "festivals",
                element.festivalId,
                "posters",
            ]), HTTPRequestMethod.GET);
            setPosters(posters);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Festival Posters`, err);
            console.error(`Error - Failed to Fetch Festival Posters: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchPosters();
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
                    "posters",
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
                    "posters",
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
                    "posters",
                    formData.get("id"),
                ]), HTTPRequestMethod.DELETE);
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} poster.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchPosters();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("posters-form-modal");
    };

    const submitForm = (formData, action) => {
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("posters-form-modal");
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
    const getFormElements = (action, poster = null) => {

        const getPersonName = (person) => {
            let name = "";
            if (!isEmptyString(person.first_name)) {
                name += person.first_name + " ";
                if (!isEmptyString(person.last_name)) {
                    name += person.last_name;
                }
                return name;
            } else if (!isEmptyString(person.organization_name)) {
                return person.organization_name;
            } else {
                return "Unknown";
            }
        };

        let results = [];
        if (poster) {
            results = [...results, recordIdElementObj(poster)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "Title", type: "text", name: "title", placeholder: "", value: poster ? poster.file.title : "" },
                { label: "Description", type: "text", name: "description", placeholder: "", value: poster ? poster.file.description : "" },
                { label: "File", type: "file", name: "file" },
                // {
                //     label: "Poster", name: "postermaker_poster_id", type: "select", options: allPosters.map((postermakerPoster) => {
                //         return {
                //             value: postermakerPoster.id,
                //             label: `(${getPersonName(postermakerPoster.postermaker.person)}) ${isEmptyString(postermakerPoster.embed.title) ? "Untitled" : postermakerPoster.embed.title}`,
                //             selected: poster ? poster.postermaker_poster_id === postermakerPoster.id : false,
                //         };
                //     }),
                // },
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
                form-id="poster-form"
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
        setModalTitle("Add Poster");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("posters-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (poster) => {
        setModalTitle("Edit Poster");
        setModalBody(getForm(FormAction.Update, poster));
        Modals.show_custom("posters-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (poster) => {
        setModalTitle("Delete Poster");
        setModalBody(getForm(FormAction.Delete, poster));
        Modals.show_custom("posters-form-modal");
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
            modal-id="posters-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Posters
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Poster
            </button>
        </h2>
        <s8f-records-table
            id="poster-table"
            .tableColumns=${tableColumns}
            .tableRows=${posters}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

FestivalPostersTable.observedAttributes = [
    "country-id",
    "city-id",
    "festival-id",
];

customElements.define("s8f-festival-posters-table", component(FestivalPostersTable, { useShadowDOM: false }));
