import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";
import { FormAction, scrollTo, SUPPORTED_IMAGE_MIMES } from "../../../shared/javascripts/misc.js";
import { eventBus, S8FEvent } from "../../../shared/javascripts/event-bus.js";
import { unsafeHTML } from "../../../shared/javascripts/vendor/lit-html/directives/unsafe-html.js";


function S8FCityTimeline(element) {
    const [timeline, setTimeline] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchTimeline = async () => {
        try {
            const timeline = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "timeline",
            ]), HTTPRequestMethod.GET);
            setTimeline(timeline);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch City Timeline`, err);
            console.error(`Error - Failed to Fetch City Timeline: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchTimeline();
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
                    "timeline",
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Update:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "timeline",
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Delete:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "timeline",
                ]), HTTPRequestMethod.DELETE);
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "updated" : "deleted";
        let successMessage = `Successfully ${actionVerb} timeline.`;

        try {
            const result = await promise;
            Alerts.success(
                "alerts",
                html`<strong>Success</strong>`,
                successMessage,
                false,
                3000,
            );
            await fetchTimeline();
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong>`, err);
        } finally {
            scrollTo("alerts");
        }
    };

    const cancelForm = () => {
        Modals.hide_custom("city-timeline-form-modal");
    };

    const submitForm = (formData, action) => {
        eventBus.dispatch(S8FEvent.RequestFormSubmit);
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("city-timeline-form-modal");
        }).finally(() => {
            eventBus.dispatch(S8FEvent.CompleteFormSubmit);
        });
    };

    const recordIdElementObj = (record) => ({ type: "text", name: "id", value: record ? record.id : null, visible: false });
    const getFormElements = (action, timeline = null) => {
        let results = [];
        if (timeline) {
            results = [...results, recordIdElementObj(timeline)];
        }
        if (action === FormAction.Add || action === FormAction.Update) {
            results = [...results,
                { label: "Embed", type: "textarea", name: "embed", placeholder: "", value: timeline ? timeline.timeline.embed.embed : "" },
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
                form-id="timeline-form"
                .elements=${getFormElements(action, record)}
                .resetOnSubmit=${action === FormAction.Add}
                @cancel=${cancelForm}
                @submit=${(e) => { submitForm(e.detail, action); }}
            >
            </s8f-form>
        `;
    };

    const btnAddClick = () => {
        setModalTitle("Add Timeline");
        setModalBody(getForm(FormAction.Add, null));
        Modals.show_custom("city-timeline-form-modal");
        Alerts.clear("form-alerts");
    };

    const btnDeleteClick = () => {
        setModalTitle("Delete Timeline");
        setModalBody(getForm(FormAction.Delete, timeline));
        Modals.show_custom("city-timeline-form-modal");
        Alerts.clear("form-alerts");
    };

    return html`
        <s8f-modal
            modal-id="city-timeline-form-modal"
            .modal-title=${modalTitle}
            .modal-body=${modalBody}
        >
        </s8f-modal>
        <h2 class="mb-4">
            City Timeline
        </h2>
        ${timeline ? html`
            <div class="mb-4">
                <div style="width: 100%; height: 500px; overflow: auto;">
                    ${unsafeHTML(timeline.timeline.embed.embed)}
                </div>
            </div>
            <button
                type="button"
                class="btn btn-danger btn-sm"
                @click=${() => { btnDeleteClick(); }}
            >
                Delete Timeline
            </button>
        ` : html`
            <p>There is no timeline available for this city.</p>
            <button
                type="button"
                class="btn btn-success btn-sm"
                @click=${() => { btnAddClick(); }}
            >
                Add Timeline
            </button>
        `}
    `;
}

S8FCityTimeline.observedAttributes = [
    "country-id",
    "city-id",
];

customElements.define("s8f-city-timeline", component(S8FCityTimeline, { useShadowDOM: false }));
