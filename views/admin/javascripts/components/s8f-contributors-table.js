import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";


const FormAction = {
    Add: "add",
    Update: "update",
};

function ContributorsTable() {
    const [contributors, setContributors] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();
    const [modalFooter, setModalFooter] = useState();

    const scrollToAlerts = () => {
        document.getElementById("alerts").scrollIntoView({
            behavior: "smooth", // smooth scroll
            block: "start", // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
        });
    };

    const fetchContributors = async () => {
        try {
            const contributors = await API.getAllContributors();
            setContributors(contributors);
            console.debug("Fetched contributors");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Contributors`, err);
            console.error(`Error - Failed to Fetch Contributors: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchContributors();
    }, []);

    const addContributor = async (contributorToAddObj) => {
        try {
            const contributor = await API.addContributor(contributorToAddObj);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Added Contributor
                `,
                `Successfully added contributor "${contributor.person.first_name} ${contributor.person.last_name} (${contributor.person.email})" to the database.`,
            );
            console.debug(`Added contributor: ${JSON.stringify(contributor)}`);
            await fetchContributors();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Contributor`, err);
            console.error(`Error - Failed to Add Contributor: ${err.message}`);
        } finally {
            Modals.hide_custom("contributor-modal");
            scrollToAlerts();
        }
    };

    const updateContributor = async (contributorToUpdateObj) => {
        try {
            const contributor = await API.updateContributor(contributorToUpdateObj);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Edited Contributor
                `,
                `Successfully edited contributor "${contributor.person.first_name} ${contributor.person.last_name} (${contributor.person.email})" in the database.`,
            );
            console.debug(`Edited contributor: ${JSON.stringify(contributor)}`);
            await fetchContributors();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Contributor`, err);
            console.error(`Error - Failed to Edit Contributor: ${err.message}`);
        } finally {
            Modals.hide_custom("contributor-modal");
            scrollToAlerts();
        }
    };

    const deleteContributor = async (contributorID) => {
        try {
            const contributor = await API.deleteContributor(contributorID);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Deleted Contributor
                `,
                `Successfully deleted contributor "${contributor.person.first_name} ${contributor.person.last_name} (${contributor.person.email})" from the database.`,
            );
            console.debug(`Deleted contributor: ${JSON.stringify(contributor)}`);
            await fetchContributors();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Contributor`, err);
            console.error(`Error - Failed to Delete Contributor: ${err.message}`);
        } finally {
            Modals.hide_custom("contributor-modal");
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

        const obj = {
            id: formData.get("id"),
            first_name: formData.get("first-name"),
            last_name: formData.get("last-name"),
            organization_name: formData.get("organization-name"),
            email: formData.get("email"),
        };

        if (action === FormAction.Add) {
            addContributor(obj);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updateContributor(obj);
        }
        Modals.hide_custom("contributor-modal");
    };


    const validateForm = () => {
        const formData = new FormData(document.getElementById("form"));
        // const id = formData.get('id');
        const first_name = formData.get("first-name");
        const last_name = formData.get("last-name");
        const organization_name = formData.get("organization-name");
        const email = formData.get("email");
        if (
            first_name.replace(/\s/g, "") === "" &&
            last_name.replace(/\s/g, "") === "" &&
            organization_name.replace(/\s/g, "") === "" &&
            email.replace(/\s/g, "") === ""
        ) {
            return { valid: false, problematic_input: "", message: "Form can not be blank" };
        }
        // if (organization_name.replace(/\s/g, "") === "") {
        //     return { valid: false, problematic_input: "organization-name", message: "Can not be blank!" };
        // }
        // if (email.replace(/\s/g, "") === "") {
        //     return { valid: false, problematic_input: "email", message: "Can not be blank!" };
        // }
        return { valid: true };
    };

    const getForm = (contributor = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${contributor ? html`<input type="text" class="d-none" name="id" value=${contributor.id} />` : nothing}
            <div class="mb-3">
                <label for="first-name" class="form-label">First Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="first-name" 
                    name="first-name"
                    .value=${contributor ? contributor.person.first_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="last-name" class="form-label">Last Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="last-name" 
                    name="last-name"
                    .value=${contributor ? contributor.person.last_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="organization-name" class="form-label">Organization Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="organization-name" 
                    name="organization-name"
                    .value=${contributor ? contributor.person.organization_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="email" 
                    name="email"
                    .value=${contributor ? contributor.person.email : ""}
                >
            </div>
        </form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Contributor");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("contributor-modal");
    };

    const btnEditClick = (contributor) => {
        setModalTitle("Edit Contributor");
        setModalBody(getForm(contributor));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("contributor-modal");
    };

    const btnDeleteClick = (contributor) => {
        setModalTitle("Delete Contributor");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deleteContributor(contributor.id); }}>Confirm</button>
        `);
        Modals.show_custom("contributor-modal");
    };

    const getTableHeaders = () => ["ID", "First Name", "Last Name", "Organization Name", "Email", "Actions"];
    const getTableRows = () => contributors.map((contributor) => [
        contributor.id,
        contributor.person.first_name,
        contributor.person.last_name,
        contributor.person.organization_name,
        contributor.person.email,
        html`
            <a href="/admin/super-eight-festivals/contributors/${contributor.id}/" class="btn btn-info btn-sm">View</a>
            <button 
                type="button" 
                class="btn btn-primary btn-sm" 
                @click=${() => { btnEditClick(contributor); }}
            >
                Edit
            </button>
            <button 
                type="button" 
                class="btn btn-danger btn-sm" 
                @click=${() => { btnDeleteClick(contributor); }}
            >
                Delete
            </button>
        `,
    ]);

    return html`
    <s8f-modal 
        modal-id="contributor-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
    >
    </s8f-modal>
    <h2 class="mb-4">
        Contributors 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { btnAddClick(); }}
        >
            Add Contributor
        </button>
    </h2>
    <s8f-table 
        id="contributors-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}

customElements.define("s8f-contributors-table", component(ContributorsTable, { useShadowDOM: false }));
