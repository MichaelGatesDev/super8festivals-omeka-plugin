import { html, nothing } from '../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useEffect, useState } from '../../../shared/javascripts/vendor/haunted.js';

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";


const FormAction = {
    Add: "add",
    Update: "update",
}

function FilmmakersTable() {
    const [filmmakers, setFilmmakers] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();
    const [modalFooter, setModalFooter] = useState();

    const scrollToAlerts = () => {
        document.getElementById("alerts").scrollIntoView({
            behavior: 'smooth', // smooth scroll
            block: 'start' // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
        });
    };

    const fetchFilmmakers = async () => {
        try {
            const filmmakers = await API.getAllFilmmakers();
            setFilmmakers(filmmakers);
            console.debug("Fetched filmmakers");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Filmmakers`, err);
            console.error(`Error - Failed to Fetch Filmmakers: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFilmmakers();
    }, []);

    const addFilmmaker = async (filmmakerToAddObj) => {
        try {
            const filmmaker = await API.addFilmmaker(filmmakerToAddObj);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Added Filmmaker
                `,
                `Successfully added filmmaker "${filmmaker.first_name} ${filmmaker.last_name} (${filmmaker.email})" to the database.`
            );
            console.debug(`Added filmmaker: ${JSON.stringify(filmmaker)}`);
            await fetchFilmmakers();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Filmmaker`, err);
            console.error(`Error - Failed to Add Filmmaker: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-modal");
            scrollToAlerts();
        }
    };

    const updateFilmmaker = async (filmmakerToUpdateObj) => {
        try {
            const filmmaker = await API.updateFilmmaker(filmmakerToUpdateObj);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Edited Filmmaker
                `,
                `Successfully edited filmmaker "${filmmaker.first_name} ${filmmaker.last_name} (${filmmaker.email})" in the database.`
            );
            console.debug(`Edited filmmaker: ${JSON.stringify(filmmaker)}`);
            await fetchFilmmakers();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Filmmaker`, err);
            console.error(`Error - Failed to Edit Filmmaker: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-modal");
            scrollToAlerts();
        }
    };

    const deleteFilmmaker = async (filmmakerID) => {
        try {
            const filmmaker = await API.deleteFilmmaker(filmmakerID);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Deleted Filmmaker
                `,
                `Successfully deleted filmmaker "${filmmaker.first_name} ${filmmaker.last_name} (${filmmaker.email})" from the database.`
            );
            console.debug(`Deleted filmmaker: ${JSON.stringify(filmmaker)}`);
            await fetchFilmmakers();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Filmmaker`, err);
            console.error(`Error - Failed to Delete Filmmaker: ${err.message}`);
        } finally {
            Modals.hide_custom("filmmaker-modal");
            scrollToAlerts();
        }
    };

    const submitForm = (action) => {
        const formData = new FormData(document.getElementById("form"))
        const formResult = validateForm();
        if (!formResult.valid) {
            console.error(`${formResult.problematic_input}: ${formResult.message}`);
            // TODO show validation results on form
            return;
        }

        const obj = {
            id: formData.get('id'),
            first_name: formData.get('first-name'),
            last_name: formData.get('last-name'),
            organization_name: formData.get('organization-name'),
            email: formData.get('email'),
        };

        if (action === FormAction.Add) {
            addFilmmaker(obj);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updateFilmmaker(obj);
        }
        Modals.hide_custom("filmmaker-modal");
    };


    const validateForm = () => {
        const formData = new FormData(document.getElementById("form"))
        // const id = formData.get('id');
        const first_name = formData.get('first-name');
        if (first_name.replace(/\s/g, "") === "") {
            return { valid: false, problematic_input: "first-name", message: "Can not be blank!" };
        }
        const last_name = formData.get('last-name');
        if (last_name.replace(/\s/g, "") === "") {
            return { valid: false, problematic_input: "last-name", message: "Can not be blank!" };
        }
        const organization_name = formData.get('organization-name');
        if (organization_name.replace(/\s/g, "") === "") {
            return { valid: false, problematic_input: "organization-name", message: "Can not be blank!" };
        }
        const email = formData.get('email');
        if (email.replace(/\s/g, "") === "") {
            return { valid: false, problematic_input: "email", message: "Can not be blank!" };
        }
        return { valid: true };
    };

    const getForm = (filmmaker = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${filmmaker ? html`<input type="text" class="d-none" name="id" value=${filmmaker.id} />` : nothing}
            <div class="mb-3">
                <label for="first-name" class="form-label">First Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="first-name" 
                    name="first-name"
                    placeholder=""
                    .value=${filmmaker ? filmmaker.first_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="first-name" class="form-label">Last Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="last-name" 
                    name="last-name"
                    .value=${filmmaker ? filmmaker.last_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="first-name" class="form-label">Organization Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="organization-name" 
                    name="organization-name"
                    .value=${filmmaker ? filmmaker.organization_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="first-name" class="form-label">Email</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="email" 
                    name="email"
                    .value=${filmmaker ? filmmaker.email : ""}
                >
            </div>
        </form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Filmmaker");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-modal");
    };

    const btnEditClick = (filmmaker) => {
        setModalTitle("Edit Filmmaker");
        setModalBody(getForm(filmmaker));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-modal");
    };

    const btnDeleteClick = (filmmaker) => {
        setModalTitle("Delete Filmmaker");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deleteFilmmaker(filmmaker.id); }}>Confirm</button>
        `);
        Modals.show_custom("filmmaker-modal");
    };

    const getTableHeaders = () => ["ID", "First Name", "Last Name", "Organization Name", "Email", "Actions"];
    const getTableRows = () => filmmakers.map((filmmaker) => [
        filmmaker.id,
        filmmaker.first_name,
        filmmaker.last_name,
        filmmaker.organization_name,
        filmmaker.email,
        html`
            <a href="/admin/super-eight-festivals/filmmakers/${filmmaker.id}/" class="btn btn-info btn-sm">View</a>
            <button 
                type="button" 
                class="btn btn-primary btn-sm" 
                @click=${() => { btnEditClick(filmmaker); }}
            >
                Edit
            </button>
            <button 
                type="button" 
                class="btn btn-danger btn-sm" 
                @click=${() => { btnDeleteClick(filmmaker); }}
            >
                Delete
            </button>
        `
    ]);

    return html`
    <s8f-modal 
        modal-id="filmmaker-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
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
    <s8f-table 
        id="filmmakers-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

customElements.define('s8f-filmmakers-table', component(FilmmakersTable, { useShadowDOM: false }));
