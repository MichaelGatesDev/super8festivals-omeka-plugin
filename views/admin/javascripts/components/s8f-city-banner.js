import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";
import { FormAction, scrollTo, SUPPORTED_IMAGE_MIMES } from "../../../shared/javascripts/misc.js";
import { eventBus, S8FEvent } from "../../../shared/javascripts/event-bus.js";


function S8FCityBanner(element) {
    const [banner, setBanner] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchBanner = async () => {
        try {
            const banner = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "banner",
            ]), HTTPRequestMethod.GET);
            setBanner(banner);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch City Banner`, err);
            console.error(`Error - Failed to Fetch City Banner: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchBanner();
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
                    "banner",
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Update:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "banner",
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Delete:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "banner",
                ]), HTTPRequestMethod.DELETE);
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} banner.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchBanner();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("city-banner-form-modal");
    };

    const submitForm = (formData, action) => {
        eventBus.dispatch(S8FEvent.RequestFormSubmit);
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("city-banner-form-modal");
        }).finally(() => {
            eventBus.dispatch(S8FEvent.CompleteFormSubmit);
        });
    };

    const recordIdElementObj = (record) => ({ type: "text", name: "id", value: record ? record.id : null, visible: false });
    const getFormElements = (action, banner = null) => {
        let results = [];
        if (banner) {
            results = [...results, recordIdElementObj(banner)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "File", type: "file", name: "file", accept: SUPPORTED_IMAGE_MIMES.join(", ") },
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
                form-id="banner-form"
                .elements=${getFormElements(action, record)}
                .resetOnSubmit=${action === FormAction.Add}
                @cancel=${cancelForm}
                @submit=${(e) => { submitForm(e.detail, action); }}
            >
            </s8f-form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Banner");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("city-banner-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = () => {
        setModalTitle("Delete Banner");
        setModalBody(getForm(FormAction.Delete, banner));
        Modals.show_custom("city-banner-form-modal");
        Alerts.clear("form-alerts");
    };

    return html`
        <s8f-modal
            modal-id="city-banner-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            City Banner
        </h2>
        ${banner ? html`
            <div class="ms-2">
                <a href=${banner.file.file_path} target="_blank" rel="noopener">
                    <img src="${banner.file.thumbnail_file_path}" class="img-fluid img-thumbnail" width="256" height="256">
                </a>
            </div>
            <button
                type="button"
                class="btn btn-danger btn-sm"
                @click=${() => { btnDeleteClick(); }}
            >
                Delete Banner
            </button>
        ` : html`
            <p>There is no banner available for this city.</p>
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Banner
            </button>
        `}
    `;
}

S8FCityBanner.observedAttributes = [
    "country-id",
    "city-id",
];

customElements.define("s8f-city-banner", component(S8FCityBanner, { useShadowDOM: false }));
