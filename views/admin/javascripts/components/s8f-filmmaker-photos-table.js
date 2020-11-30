import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";


const FormAction = {
    Add: "add",
    Update: "update",
};

function FilmmakerPhotosTable(element) {
    const [photos, setPhotos] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();
    const [modalFooter, setModalFooter] = useState();

    const scrollToAlerts = () => {
        document.getElementById("alerts").scrollIntoView({
            behavior: "smooth", // smooth scroll
            block: "start", // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
        });
    };

    const fetchPhotos = async () => {
        try {
            const photos = await API.getAllFilmmakerPhotos(element.filmmakerId);
            setPhotos(photos);
            console.debug("Fetched photos");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Photos`, err);
            console.error(`Error - Failed to Fetch Photos: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchPhotos();
    }, []);

    const addPhoto = async (formData) => {
        try {
            const photo = await API.addFilmmakerPhoto(element.filmmakerId, formData);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Added Photo
                `,
                `Successfully added photo.`,
            );
            console.debug(`Added photo: ${JSON.stringify(photo)}`);
            await fetchPhotos();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Photo`, err);
            console.error(`Error - Failed to Add Photo: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-photos-modal");
            scrollToAlerts();
        }
    };

    const updatePhoto = async (formData) => {
        try {
            const photo = await API.updateFilmmakerPhoto(formData);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Edited Photo
                `,
                `Successfully edited photo.`,
            );
            console.debug(`Edited photo: ${JSON.stringify(photo)}`);
            await fetchPhotos();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Photo`, err);
            console.error(`Error - Failed to Edit Photo: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-photos-modal");
            scrollToAlerts();
        }
    };

    const deletePhoto = async (photoID) => {
        try {
            const photo = await API.deleteFilmmakerPhoto(element.filmmakerId, photoID);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Deleted Photo
                `,
                `Successfully deleted photo.`,
            );
            console.debug(`Deleted photo: ${JSON.stringify(photo)}`);
            await fetchPhotos();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Photo`, err);
            console.error(`Error - Failed to Delete Photo: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-photos-modal");
            scrollToAlerts();
        }
    };

    const submitForm = (action) => {
        const formData = new FormData(document.getElementById("form"));
        const formResult = validateForm();
        if (!formResult.valid) {
            console.error(`${formResult.problematic_input}: ${formResult.message}`);
            // TODO show validation results on form
            return;
        }

        if (action === FormAction.Add) {
            addPhoto(formData);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updatePhoto(formData);
        }
        Modals.hide_custom("filmmaker-photos-modal");
    };


    const validateForm = () => {
        const formData = new FormData(document.getElementById("form"));
        // const title = formData.get("title");
        return { valid: true };
    };

    const getForm = (photo = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${photo ? html`<input type="text" class="d-none" name="id" value=${photo.id} />` : nothing}
            <input type="text" class="d-none" name="filmmaker-id" value=${element.filmmakerId} />
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="title" 
                    name="title"
                    .value=${photo ? photo.file.title : ""}
                >
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="description" 
                    name="description"
                    .value=${photo ? photo.file.description : ""}
                >
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Photo</label>
                <input 
                    type="file" 
                    class="form-control" 
                    id="file" 
                    name="file"
                    accept="image/jpeg,image/png"
                >
            </div>
        </form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Photo");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-photos-modal");
    };

    const btnEditClick = (photo) => {
        setModalTitle("Edit Photo");
        setModalBody(getForm(photo));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-photos-modal");
    };

    const btnDeleteClick = (photo) => {
        setModalTitle("Delete Photo");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deletePhoto(photo.id); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-photos-modal");
    };

    const getTableHeaders = () => ["Preview", "ID", "Title", "Description", "Actions"];
    const getTableRows = () => photos.map((photo) => [
        photo.file ? html`
            <a href="${photo.file.file_path}" target="_blank" rel="noopener">
                <img src="${photo.file.thumbnail_file_path}" class="img-fluid img-thumbnail" width="64" height="64">        
            </a>
        ` : "",
        photo.id,
        photo.file.title,
        photo.file.description,
        html`
            <a href="/admin/super-eight-festivals/filmmakers/${element.filmmakerId}/photos/${photo.id}/" class="btn btn-info btn-sm">View</a>
            <button 
                type="button" 
                class="btn btn-primary btn-sm"
                @click=${() => { btnEditClick(photo); }}
            >
                Edit
            </button>
            <button 
                type="button" 
                class="btn btn-danger btn-sm" 
                @click=${() => { btnDeleteClick(photo); }}
            >
                Delete
            </button>
        `,
    ]);

    return html`
    <s8f-modal 
        modal-id="filmmaker-photos-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
    >
    </s8f-modal>
    <h3 class="mb-4">
        Photos 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { btnAddClick(); }}
        >
            Add
        </button>
    </h3>
    <s8f-table 
        id="filmaker-photos-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

FilmmakerPhotosTable.observedAttributes = ['filmmaker-id'];

customElements.define("s8f-filmmaker-photos-table", component(FilmmakerPhotosTable, { useShadowDOM: false }));
