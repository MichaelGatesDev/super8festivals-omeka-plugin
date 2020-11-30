import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";


const FormAction = {
    Add: "add",
    Update: "update",
};

function StaffTable() {
    const [staff, setStaff] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();
    const [modalFooter, setModalFooter] = useState();

    const scrollToAlerts = () => {
        document.getElementById("alerts").scrollIntoView({
            behavior: "smooth", // smooth scroll
            block: "start", // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
        });
    };

    const fetchStaff = async () => {
        try {
            const staffs = await API.getAllStaff();
            setStaff(staffs);
            console.debug("Fetched staff");
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Staffs`, err);
            console.error(`Error - Failed to Fetch Staffs: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchStaff();
    }, []);

    const addStaff = async (formData) => {
        try {
            const staff = await API.addStaff(formData);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Added Staff
                `,
                `Successfully added staff "${staff.person.first_name} ${staff.person.last_name} (${staff.person.email})" to the database.`,
            );
            console.debug(`Added staff: ${JSON.stringify(staff)}`);
            await fetchStaff();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Add Staff`, err);
            console.error(`Error - Failed to Add Staff: ${err.message}`);
        } finally {
            Modals.hide_custom("staff-modal");
            scrollToAlerts();
        }
    };

    const updateStaff = async (formData) => {
        try {
            const staff = await API.updateStaff(formData);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Edited Staff
                `,
                `Successfully edited staff "${staff.person.first_name} ${staff.person.last_name} (${staff.person.email})" in the database.`,
            );
            console.debug(`Edited staff: ${JSON.stringify(staff)}`);
            await fetchStaff();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Edit Staff`, err);
            console.error(`Error - Failed to Edit Staff: ${err.message}`);
        } finally {
            Modals.hide_custom("staff-modal");
            scrollToAlerts();
        }
    };

    const deleteStaff = async (staffID) => {
        try {
            const staff = await API.deleteStaff(staffID);
            Alerts.success(
                "alerts",
                html`
                    <strong>Success</strong> 
                    - Deleted Staff
                `,
                `Successfully deleted staff "${staff.person.first_name} ${staff.person.last_name} (${staff.person.email})" from the database.`,
            );
            console.debug(`Deleted staff: ${JSON.stringify(staff)}`);
            await fetchStaff();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Delete Staff`, err);
            console.error(`Error - Failed to Delete Staff: ${err.message}`);
        } finally {
            Modals.hide_custom("staff-modal");
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
            addStaff(formData);
            document.getElementById("form").reset();
        } else if (action === FormAction.Update) {
            updateStaff(formData);
        }
        Modals.hide_custom("staff-modal");
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

    const getForm = (staff = null) => {
        return html`
        <form id="form" method="POST" action="">
            ${staff ? html`<input type="text" class="d-none" name="id" value=${staff.id} />` : nothing}
            ${staff && staff.person ? html`<input type="text" class="d-none" name="person-id" value=${staff.person.id} />` : nothing}
            <div class="mb-3">
                <label for="first-name" class="form-label">First Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="first-name" 
                    name="first-name"
                    .value=${staff ? staff.person.first_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="last-name" class="form-label">Last Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="last-name" 
                    name="last-name"
                    .value=${staff ? staff.person.last_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="organization-name" class="form-label">Organization Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="organization-name" 
                    name="organization-name"
                    .value=${staff ? staff.person.organization_name : ""}
                >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="email" 
                    name="email"
                    .value=${staff ? staff.person.email : ""}
                >
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Site Role</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="role" 
                    name="role"
                    .value=${staff ? staff.role : ""}
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
        setModalTitle("Add Staff");
        setModalBody(getForm());
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Add); }}>Confirm</button>
        `);
        Modals.show_custom("staff-modal");
    };

    const btnEditClick = (staff) => {
        setModalTitle("Edit Staff");
        setModalBody(getForm(staff));
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { submitForm(FormAction.Update); }}>Confirm</button>
        `);
        Modals.show_custom("staff-modal");
    };

    const btnDeleteClick = (staff) => {
        setModalTitle("Delete Staff");
        setModalBody(html`
            <p>Are you sure you want to delete this?</p>
            <p class="text-danger">Warning: this can not be undone.</p>
        `);
        setModalFooter(html`
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click=${() => { deleteStaff(staff.id); }}>Confirm</button>
        `);
        Modals.show_custom("staff-modal");
    };

    const getTableHeaders = () => ["Preview", "ID", "First Name", "Last Name", "Organization Name", "Email", "Role", "Actions"];
    const getTableRows = () => staff.map((staff) => [
        staff.file ? html`
            <a href="${staff.file.file_path}" target="_blank" rel="noopener">
                <img src="${staff.file.thumbnail_file_path}" class="img-fluid img-thumbnail" width="64" height="64">        
            </a>
        ` : "",
        staff.id,
        staff.person.first_name,
        staff.person.last_name,
        staff.person.organization_name,
        staff.person.email,
        staff.role,
        html`
            <a href="/admin/super-eight-festivals/staff/${staff.id}/" class="btn btn-info btn-sm">View</a>
            <button 
                type="button" 
                class="btn btn-primary btn-sm" 
                @click=${() => { btnEditClick(staff); }}
            >
                Edit
            </button>
            <button 
                type="button" 
                class="btn btn-danger btn-sm" 
                @click=${() => { btnDeleteClick(staff); }}
            >
                Delete
            </button>
        `,
    ]);

    return html`
    <s8f-modal 
        modal-id="staff-modal"
        .modal-title=${modalTitle}
        .modal-body=${modalBody}
        .modal-footer=${modalFooter}
    >
    </s8f-modal>
    <h2 class="mb-4">
        Staffs 
        <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click=${() => { btnAddClick(); }}
        >
            Add Staff
        </button>
    </h2>
    <s8f-table 
        id="staff-table"
        .headers=${getTableHeaders()}
        .rows=${getTableRows()}
    ></s8f-table>
    `;
}


customElements.define("s8f-staff-table", component(StaffTable, { useShadowDOM: false }));
