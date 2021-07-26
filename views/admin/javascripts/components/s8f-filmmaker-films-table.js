import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import { eventBus, S8FEvent } from "../../../shared/javascripts/event-bus.js";
import { FormAction, isEmptyString, openLink, scrollTo } from "../../../shared/javascripts/misc.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";

import Alerts from "../utils/alerts.js";
import Modals from "../utils/modals.js";
import { Person } from "../utils/s8f-records.js";


function FilmmakerFilmsTable(element) {
    const [allContributors, setAllContributors] = useState();
    const [films, setFilms] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchFilms = async () => {
        try {
            const films = await API.performRequest(API.constructURL(["filmmakers", element.filmmakerId, "films"]), HTTPRequestMethod.GET);
            setFilms(_.orderBy(films, ["video.title", "id"]));
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Films`, err);
            console.error(`Error - Failed to Fetch Films: ${err.message}`);
        }
    };

    const fetchAllContributors = async () => {
        try {
            const contributors = await API.performRequest(API.constructURL([
                "contributors",
            ]), HTTPRequestMethod.GET);
            setAllContributors(_.orderBy(contributors, ["person.first_name", "person.last_name", "person.organization_name"]));
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Contributors`, err);
            console.error(`Error - Failed to Fetch Contributors: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFilms();
        fetchAllContributors();
    }, []);

    const performRestAction = async (formData, action) => {
        let promise = null;
        switch (action) {
            case FormAction.Add:
                promise = API.performRequest(API.constructURL(["filmmakers", element.filmmakerId, "films"]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Update:
                promise = API.performRequest(API.constructURL(["filmmakers", element.filmmakerId, "films", formData.get("id")]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Delete:
                promise = API.performRequest(API.constructURL(["filmmakers", element.filmmakerId, "films", formData.get("id")]), HTTPRequestMethod.DELETE);
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
        eventBus.dispatch(S8FEvent.RequestFormSubmit);
        performRestAction(formData, action).then(() => {
            Modals.hide_custom("films-form-modal");
        }).finally(() => {
            eventBus.dispatch(S8FEvent.CompleteFormSubmit);
        });
    };

    const validateForm = (formData) => {
        const url = formData.get("url");
        if (isEmptyString(url)) {
            return { input_name: "url", message: "URL can not be blank!" };
        }
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
                { label: "Title", type: "text", name: "title", placeholder: "", value: film ? film.video.title : "" },
                { label: "Description", type: "text", name: "description", placeholder: "", value: film ? film.video.description : "" },
                { label: "URL", type: "text", name: "url", placeholder: "", value: film ? film.video.url : "" },
                {
                    label: "Contributor", name: "contributor_id", type: "select", options: ([{ id: 0 }, ...allContributors]).map((contributor) => {
                        return {
                            value: contributor.id,
                            label: contributor.id === 0 ? `None` : `${Person.getDisplayName(contributor.person)}`,
                            selected: film ? film.video.contributor_id === contributor.id : false,
                        };
                    }),
                },
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
        { title: "URL", accessor: "video" },
        { title: "Title", accessor: "video.title" },
        { title: "Description", accessor: "video.description" },
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
