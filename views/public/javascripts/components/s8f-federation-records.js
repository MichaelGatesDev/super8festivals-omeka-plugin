import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";

import { isEmptyString } from "../../../shared/javascripts/misc.js";

function S8FFederationRecords(element) {
    const elemRecords = Array.isArray(element.records) ? element.records : [];
    const [records, setRecords] = useState(elemRecords);
    const [search, setSearch] = useState("");

    const filterRecords = records => {
        if (isEmptyString(search)) return records;

        const fileMatch = (record, query) => {
            query = query.toLowerCase();
            return record.file && (
                record.file.title.toLowerCase().includes(query)
                || record.file.description.toLowerCase().includes(query)
            );
        };

        const personMatch = (record, query) => {
            query = query.toLowerCase();
            return record.person && (
                record.person.first_name.toLowerCase().includes(query)
                || record.person.last_name.toLowerCase().includes(query)
                || record.person.organization_name.toLowerCase().includes(query)
            );
        };

        return records.filter(r =>
            fileMatch(r, search)
            || personMatch(r, search),
        );
    };

    const sortRecords = records => {
        if (records.length === 0) return records;
        return _.sortBy(records, ["file.title", "person.first_name", "person.organization_name"]);
    };

    useEffect(() => {
        setRecords(filterRecords(elemRecords));
    }, [search]);

    const sortedRecords = sortRecords(records);

    const recordTemplate = (record, fbId) => html`
        <s8f-card .record=${record} .fancyboxId=${fbId} id=${`${element.sectionId}-${record.id}`}></s8f-card>
    `;

    const navTabItemTemplate = (id, title, paneName, active = false) => {
        return html`
            <li class="nav-item" role="presentation">
                <a class="nav-link ${active ? "active" : ""}" id="${paneName}-tab-${id}" data-bs-toggle="tab" href="#${paneName}-pane-${id}" role="tab" aria-controls="${paneName}-pane-${id}" aria-selected="true">
                    <span class="text-capitalize">${title}</span>
                </a>
            </li>
        `;
    };

    function navPaneTemplate(id, year, paneName, active = false) {
        return html`
            <div class="tab-pane ${active ? "active" : ""}" id="${paneName}-pane-${id}" role="tabpanel" aria-labelledby="${paneName}-tab-${id}">
                <div class="d-flex my-2">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Search &nbsp; <i class="bi bi-search"></i></span>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Search Query"
                            .value=${search}
                            @change=${(e) => { setSearch(e.target.value); }}
                            @input=${(e) => { setSearch(e.target.value); }}
                        >
                        <button class="btn btn-outline-secondary" type="button" @click=${() => { setSearch(""); }}>Clear</button>
                    </div>
                </div>
                ${sortedRecords.length === 0 ? html`
                    <p>No results.</p>
                ` : html`
                    <div class="card-deck">
                        ${repeat(sortedRecords,
                            record => recordTemplate(record, `${element.sectionId}-${year}`),
                        )}
                    </div>
                `}
            </div>
        `;
    }

    return html`
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            ${navTabItemTemplate("all", "all", element.sectionId, true)}
        </ul>
        <div class="tab-content">
            ${navPaneTemplate("all", "all", element.sectionId, true)}
        </div>
    `;
}

customElements.define("s8f-federation-records", component(S8FFederationRecords, { useShadowDOM: false }));
