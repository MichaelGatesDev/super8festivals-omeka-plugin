import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";

import Alerts from "../utils/alerts.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Modals from "../utils/modals.js";
import { FormAction, scrollTo } from "../../../shared/javascripts/misc.js";
import { Video, Person } from "../utils/s8f-records.js";
import { eventBus, S8FEvent } from "../../../shared/javascripts/event-bus.js";


function FestivalFilmsTable(element) {
    const [films, setFilms] = useState();
    const [allFilms, setAllFilms] = useState();
    const [modalTitle, setModalTitle] = useState();
    const [modalBody, setModalBody] = useState();

    const fetchFilms = async () => {
        try {
            const films = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "festivals",
                element.festivalId,
                "films",
            ]), HTTPRequestMethod.GET);
            setFilms(films);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Festival Films`, err);
            console.error(`Error - Failed to Fetch Festival Films: ${err.message}`);
        }
    };

    const fetchAllFilms = async () => {
        try {
            const films = await API.performRequest(API.constructURL([
                "films",
            ]), HTTPRequestMethod.GET);
            setAllFilms(_.orderBy(films, ["filmmaker.person.first_name", "video.title"]));
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Filmmaker Films`, err);
            console.error(`Error - Failed to Fetch Filmmaker Films: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFilms();
        fetchAllFilms();
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
                    "festivals",
                    element.festivalId,
                    "films",
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Update:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "festivals",
                    element.festivalId,
                    "films",
                    formData.get("id"),
                ]), HTTPRequestMethod.POST, formData);
                break;
            case FormAction.Delete:
                promise = API.performRequest(API.constructURL([
                    "countries",
                    element.countryId,
                    "cities",
                    element.cityId,
                    "festivals",
                    element.festivalId,
                    "films",
                    formData.get("id"),
                ]), HTTPRequestMethod.DELETE);
                break;
        }

        let actionVerb = action === FormAction.Add ? "added" : action === FormAction.Update ? "linked" : "unlinked";
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
                {
                    label: "Film", name: "filmmaker_film_id", type: "select", options: ([{ id: 0 }, ...allFilms]).map((filmmakerFilm) => {
                        return {
                            value: filmmakerFilm.id,
                            label: filmmakerFilm.id === 0 ? `None` : `${Person.getDisplayName(filmmakerFilm.filmmaker.person)} - ${Video.getTitle(filmmakerFilm.video)}`,
                            selected: film && film.filmmaker_film_id === filmmakerFilm.id,
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
        { title: "Filmmaker Film ID", accessor: "filmmaker_film.id" },
        { title: "Preview", accessor: "filmmaker_film.video" },
        { title: "Title", accessor: "filmmaker_film.video.title" },
        { title: "Description", accessor: "filmmaker_film.video.description" },
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
            .rowEditFunc=${(record) => { btnEditClick(record); }}
            .rowDeleteFunc=${(record) => { btnDeleteClick(record); }}
        >
        </s8f-records-table>
    `;
}

FestivalFilmsTable.observedAttributes = [
    "country-id",
    "city-id",
    "festival-id",
];

customElements.define("s8f-festival-films-table", component(FestivalFilmsTable, { useShadowDOM: false }));
