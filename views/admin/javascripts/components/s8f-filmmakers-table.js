import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";

import { FormAction, isEmptyString, openLink, scrollTo } from "../../../shared/javascripts/misc.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";


function FilmmakersTable() {
    const [filmmakers, setFilmmakers] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchFilmmakers = async () => {
        try {
            const filmmakers = await API.performRequest(API.constructURL(["filmmakers"]), HTTPRequestMethod.GET);
            setFilmmakers(_.orderBy(filmmakers, ["person.first_name", "person.last_name"]));
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Filmmakers`, err);
            console.error(`Error - Failed to Fetch Filmmakers: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFilmmakers();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.performRequest(API.constructURL(["filmmakers"]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Update:
                promise = API.performRequest(API.constructURL(["filmmakers", formData.get("id")]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Delete:
                promise = API.performRequest(API.constructURL(["filmmakers", formData.get("id")]), HTTPRequestMethod.DELETE);
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} filmmaker.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchFilmmakers();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
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
        const first_name = formData.get("first_name");
        const last_name = formData.get("last_name");
        const organization_name = formData.get("organization_name");
        const email = formData.get("email");
        if (isEmptyString(first_name) && isEmptyString(last_name) && isEmptyString(organization_name) && isEmptyString(email)) {
            return { input_name: "name", message: "Either a name or email is required!" };
        }
        return null;
    };

    const recordIdElementObj = (record) => ({ type: "text", name: "id", value: record ? record.id : null, visible: false });
    const getFormElements = (action, filmmaker = null) => {
        let results = [];
        if (filmmaker) {
            results = [...results, recordIdElementObj(filmmaker)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "First Name", type: "text", name: "first_name", placeholder: "", value: filmmaker ? filmmaker.person.first_name : "" },
                { label: "Last Name", type: "text", name: "last_name", placeholder: "", value: filmmaker ? filmmaker.person.last_name : "" },
                { label: "Organization Name", type: "text", name: "organization_name", placeholder: "", value: filmmaker ? filmmaker.person.organization_name : "" },
                { label: "Email", type: "text", name: "email", placeholder: "", value: filmmaker ? filmmaker.person.email : "" },
                // { label: "Photo", type: "file", name: "file" },
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
                form-id="filmmaker-form"
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
        setModalTitle("Add Filmmaker");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (filmmaker) => {
        setModalTitle("Edit Filmmaker");
        setModalBody(getForm(FormAction.Update, filmmaker));
        Modals.show_custom("form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (filmmaker) => {
        setModalTitle("Delete Filmmaker");
        setModalBody(getForm(FormAction.Delete, filmmaker));
        Modals.show_custom("form-modal");
        Alerts.clear("form-alerts");
    };


    const tableColumns = [
        { title: "ID", accessor: "id" },
        // { title: "Preview", accessor: "file" },
        { title: "First Name", accessor: "person.first_name" },
        { title: "Last Name", accessor: "person.last_name" },
        { title: "Organization Name", accessor: "person.organization_name" },
        { title: "Email", accessor: "person.email" },
    ];

    return html`
        <s8f-modal
            modal-id="form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Filmmakers
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Filmmaker
            </button>
        </h2>
        <s8f-records-table
            id="filmmaker-table"
            .tableColumns=${tableColumns}
            .tableRows=${filmmakers}
            .rowViewFunc=${(record) => { openLink(`/admin/super-eight-festivals/filmmakers/${record.id}/`); }}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

customElements.define("s8f-filmmakers-table", component(FilmmakersTable, { useShadowDOM: false }));
