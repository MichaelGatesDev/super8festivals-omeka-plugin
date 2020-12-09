import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";
import { FormAction, openLink, scrollTo } from "../../../shared/javascripts/misc.js";


function FilmmakerFilmsTable(element) {
    const [films, setFilms] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchFilms = async () => {
        try {
            const films = await API.getAllFilmmakerFilms(element.filmmakerId);
            setFilms(films);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Films`, err);
            console.error(`Error - Failed to Fetch Films: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFilms();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.addFilmmakerFilm(element.filmmakerId, formData);
                break;
            case FormAction.Update:
                promise = API.updateFilmmakerFilm(element.filmmakerId, formData);
                break;
            case FormAction.Delete:
                promise = API.deleteFilmmakerFilm(element.filmmakerId, formData.get("id"));
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} film.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchFilms();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("films-form-modal");
    };

    const submitForm = (formData, action) => {
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("films-form-modal");
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
    const getFormElements = (action, film = null) => {
        let results = [];
        if (film) {
            results = [...results, recordIdElementObj(film)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "Title", type: "text", name: "title", placeholder: "", value: film ? film.embed.title : "" },
                { label: "Description", type: "text", name: "description", placeholder: "", value: film ? film.embed.description : "" },
                { label: "Embed", type: "textarea", name: "embed", placeholder: "", value: film ? film.embed.embed : "" },
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
                form-id="film-form"
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
        setModalTitle("Add Film");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("films-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (film) => {
        setModalTitle("Edit Film");
        setModalBody(getForm(FormAction.Update, film));
        Modals.show_custom("films-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (film) => {
        setModalTitle("Delete Film");
        setModalBody(getForm(FormAction.Delete, film));
        Modals.show_custom("films-form-modal");
        Alerts.clear("form-alerts");
    };


    const tableColumns = [
        { title: "ID", accessor: "id" },
        { title: "Preview", accessor: "embed" },
        { title: "Title", accessor: "embed.title" },
        { title: "Description", accessor: "embed.description" },
    ];

    return html`
        <s8f-modal
            modal-id="films-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Films
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Film
            </button>
        </h2>
        <s8f-records-table
            id="film-table"
            .tableColumns=${tableColumns}
            .tableRows=${films}
            .rowViewFunc=${(record) => { openLink(`/admin/super-eight-festivals/filmmakers/${element.filmmakerId}/films/${record.id}/`); }}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

FilmmakerFilmsTable.observedAttributes = ["filmmaker-id"];

customElements.define("s8f-filmmaker-films-table", component(FilmmakerFilmsTable, { useShadowDOM: false }));
