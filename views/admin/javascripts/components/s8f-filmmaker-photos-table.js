import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";
import { FormAction, openLink, scrollTo } from "../../../shared/javascripts/misc.js";


function FilmmakerPhotosTable(element) {
    const [photos, setPhotos] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchPhotos = async () => {
        try {
            const photos = await API.getAllFilmmakerPhotos(element.filmmakerId);
            setPhotos(photos);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Photos`, err);
            console.error(`Error - Failed to Fetch Photos: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchPhotos();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.addFilmmakerPhoto(element.filmmakerId, formData);
                break;
            case FormAction.Update:
                promise = API.updateFilmmakerPhoto(element.filmmakerId, formData);
                break;
            case FormAction.Delete:
                promise = API.deleteFilmmakerPhoto(element.filmmakerId, formData.get("id"));
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} photo.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchPhotos();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("photos-form-modal");
    };

    const submitForm = (formData, action) => {
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("photos-form-modal");
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
                { label: "Title", type: "text", name: "title", placeholder: "", value: film ? film.file.title : "" },
                { label: "Description", type: "text", name: "description", placeholder: "", value: film ? film.file.description : "" },
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
                form-id="photo-form"
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
        setModalTitle("Add Photo");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("photos-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (film) => {
        setModalTitle("Edit Photo");
        setModalBody(getForm(FormAction.Update, film));
        Modals.show_custom("photos-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (film) => {
        setModalTitle("Delete Photo");
        setModalBody(getForm(FormAction.Delete, film));
        Modals.show_custom("photos-form-modal");
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
            modal-id="photos-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Photos
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Photo
            </button>
        </h2>
        <s8f-records-table
            id="film-table"
            .tableColumns=${tableColumns}
            .tableRows=${photos}
            .rowViewFunc=${(record) => { openLink(`/admin/super-eight-festivals/filmmakers/${element.filmmakerId}/photos/${record.id}/`); }}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

FilmmakerPhotosTable.observedAttributes = ["filmmaker-id"];

customElements.define("s8f-filmmaker-photos-table", component(FilmmakerPhotosTable, { useShadowDOM: false }));
