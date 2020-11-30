import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";


const FormAction = {
    Add: "add",
    Update: "update",
};

function FilmmakerFilmsTable(element) {
    const [films, setFilms] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();
    const [modalFooter, setModalFooter] = useState();

    const scrollToAlerts = () => {
        document.getElementById("alerts").scrollIntoView({
            behavior: "smooth", // smooth scroll
            block: "start", // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
        });
    };

    const fetchFilms = async () => {
        try {
            const films = await API.getAllFilmmakerFilms(element.filmmakerId);
            setFilms(films);
            console.debug("Fetched films");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Films`, err);
            console.error(`Error - Failed to Fetch Films: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFilms();
    }, []);

    const addFilm = async (formData) => {
        try {
            const film = await API.addFilmmakerFilm(element.filmmakerId, formData);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Added Film
                `,
                `Successfully added film.`,
            );
            console.debug(`Added film: ${JSON.stringify(film)}`);
            await fetchFilms();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Film`, err);
            console.error(`Error - Failed to Add Film: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-films-modal");
            scrollToAlerts();
        }
    };

    const updateFilm = async (formData) => {
        try {
            const film = await API.updateFilmmakerFilm(formData);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Edited Film
                `,
                `Successfully edited film.`,
            );
            console.debug(`Edited film: ${JSON.stringify(film)}`);
            await fetchFilms();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Film`, err);
            console.error(`Error - Failed to Edit Film: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-films-modal");
            scrollToAlerts();
        }
    };

    const deleteFilm = async (filmID) => {
        try {
            const film = await API.deleteFilmmakerFilm(element.filmmakerId, filmID);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Deleted Film
                `,
                `Successfully deleted film.`,
            );
            console.debug(`Deleted film: ${JSON.stringify(film)}`);
            await fetchFilms();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Film`, err);
            console.error(`Error - Failed to Delete Film: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-films-modal");
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
            addFilm(formData);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updateFilm(formData);
        }
        Modals.hide_custom("filmmaker-films-modal");
    };


    const validateForm = () => {
        const formData = new FormData(document.getElementById("form"));
        // const title = formData.get("title");
        return { valid: true };
    };

    const getForm = (film = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${film ? html`<input type="text" class="d-none" name="id" value=${film.id} />` : nothing}
            <input type="text" class="d-none" name="filmmaker-id" value=${element.filmmakerId} />
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="title" 
                    name="title"
                    .value=${film ? film.embed.title : ""}
                >
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="description" 
                    name="description"
                    .value=${film ? film.embed.description : ""}
                >
            </div>
            <div class="mb-3">
                <label for="embed" class="form-label">Embed</label>
                <textarea 
                    class="form-control" 
                    id="embed" 
                    name="embed"
                    rows="3"
                    .value=${film ? film.embed.embed : ""}
                ></textarea>
            </div>
        </form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Film");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-films-modal");
    };

    const btnEditClick = (film) => {
        setModalTitle("Edit Film");
        setModalBody(getForm(film));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-films-modal");
    };

    const btnDeleteClick = (film) => {
        setModalTitle("Delete Film");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deleteFilm(film.id); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-films-modal");
    };

    const getTableHeaders = () => ["Preview", "ID", "Title", "Description", "Actions"];
    const getTableRows = () => films.map((film) => [
        film.embed ? html`N/A` : "",
        film.id,
        film.embed.title,
        film.embed.description,
        html`
            <a href="/admin/super-eight-festivals/filmmakers/${element.filmmakerId}/films/${film.id}/" class="btn btn-info btn-sm">View</a>
            <button 
                type="button" 
                class="btn btn-primary btn-sm"
                @click=${() => { btnEditClick(film); }}
            >
                Edit
            </button>
            <button 
                type="button" 
                class="btn btn-danger btn-sm" 
                @click=${() => { btnDeleteClick(film); }}
            >
                Delete
            </button>
        `,
    ]);

    return html`
    <s8f-modal 
        modal-id="filmmaker-films-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
    >
    </s8f-modal>
    <h3 class="mb-4">
        Films 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { btnAddClick(); }}
        >
            Add
        </button>
    </h3>
    <s8f-table 
        id="filmaker-films-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

FilmmakerFilmsTable.observedAttributes = ["filmmaker-id"];

customElements.define("s8f-filmmaker-films-table", component(FilmmakerFilmsTable, { useShadowDOM: false }));
