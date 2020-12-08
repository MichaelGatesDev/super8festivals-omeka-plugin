import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API from "../utils/api.js";
import Modals from "../utils/modals.js";

import { FormAction, openLink, scrollTo } from "../../../shared/javascripts/misc.js";

function StaffTable() {
    const [staff, setStaff] = useState([]);
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchStaff = async () => {
        try {
            const staffs = await API.getAllStaff();
            setStaff(staffs);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Staffs`, err);
            console.error(`Error - Failed to Fetch Staffs: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchStaff();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.addStaff(formData);
                break;
            case FormAction.Update:
                promise = API.updateStaff(formData);
                break;
            case FormAction.Delete:
                promise = API.deleteStaff(formData.get("id"));
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} staff.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchStaff();
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
        if (first_name.replace(/\s/g, "") === "") {
            return { input_name: "name", message: "First Name can not be blank!" };
        }
        const last_name = formData.get("last_name");
        if (last_name.replace(/\s/g, "") === "") {
            return { input_name: "name", message: "Last Name can not be blank!" };
        }
        const email = formData.get("email");
        if (email.replace(/\s/g, "") === "") {
            return { input_name: "name", message: "Email can not be blank!" };
        }
        const role = formData.get("role");
        if (role.replace(/\s/g, "") === "") {
            return { input_name: "name", message: "Role can not be blank!" };
        }
        return null;
    };

    const recordIdElementObj = (record) => ({ type: "text", name: "id", value: record ? record.id : null, visible: false });
    const getFormElements = (action, staff = null) => {
        let results = [];
        if (staff) {
            results = [...results, recordIdElementObj(staff)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "First Name", type: "text", name: "first_name", placeholder: "", value: staff ? staff.person.first_name : "" },
                { label: "Last Name", type: "text", name: "last_name", placeholder: "", value: staff ? staff.person.last_name : "" },
                { label: "Organization Name", type: "text", name: "organization_name", placeholder: "", value: staff ? staff.person.organization_name : "" },
                { label: "Email", type: "text", name: "email", placeholder: "", value: staff ? staff.person.email : "" },
                { label: "Role", type: "text", name: "role", placeholder: "", value: staff ? staff.role : "" },
                { label: "Photo", type: "file", name: "file" },
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
                form-id="staff-form"
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
        setModalTitle("Add Staff");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("form-modal");
        Alerts.clear("form-alerts");
    };

    const btnEditClick = (staff) => {
        setModalTitle("Edit Staff");
        setModalBody(getForm(FormAction.Update, staff));
        Modals.show_custom("form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = (staff) => {
        setModalTitle("Delete Staff");
        setModalBody(getForm(FormAction.Delete, staff));
        Modals.show_custom("form-modal");
        Alerts.clear("form-alerts");
    };


    const tableColumns = [
        { title: "ID", accessor: "id" },
        { title: "Preview", accessor: "file" },
        { title: "First Name", accessor: "person.first_name" },
        { title: "Last Name", accessor: "person.last_name" },
        { title: "Organization Name", accessor: "person.organization_name" },
        { title: "Email", accessor: "person.email" },
        { title: "Role", accessor: "role" },
    ];

    return html`
        <s8f-modal
            modal-id="form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            Staff
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Staff
            </button>
        </h2>
        <s8f-records-table
            id="staff-table"
            .tableColumns=${tableColumns}
            .tableRows=${staff}
            .rowViewFunc=${(record) => { openLink(`/admin/super-eight-festivals/staff/${record.id}/`); }}
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}


customElements.define("s8f-staff-table", component(StaffTable, { useShadowDOM: false }));
