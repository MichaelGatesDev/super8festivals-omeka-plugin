import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";

import { isEmptyString } from "../../../shared/javascripts/misc.js";

function S8FFilmmakerRecords(element) {
    const elemRecords = Array.isArray(element.records) ? element.records : [];
    const [records, setRecords] = useState(elemRecords);
    const [search, setSearch] = useState("");

    const filterRecords = records => {
        if (isEmptyString(search)) return records;

        const festivalYearMatch = (record, query) => {
            return record.festival && !Number.isNaN(record.festival.year) && record.festival.year.toString().includes(query);
        };

        const fileMatch = (record, query) => {
            query = query.toLowerCase();
            return record.file && (
                record.file.title.toLowerCase().includes(query)
                || record.file.description.toLowerCase().includes(query)
            );
        };

        const embedMatch = (record, query) => {
            query = query.toLowerCase();
            return record.embed && (
                record.embed.title.toLowerCase().includes(query)
                || record.embed.description.toLowerCase().includes(query)
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
            festivalYearMatch(r, search)
            || fileMatch(r, search)
            || embedMatch(r, search)
            || personMatch(r, search),
        );
    };

    const sortRecords = records => {
        if (records.length === 0) return records;
        return _.sortBy(records, ["festival.year", "file.title", "embed.title", "person.first_name", "person.organization_name"]);
    };

    useEffect(() => {
        setRecords(filterRecords(elemRecords));
    }, [search]);

    const sortedRecords = sortRecords(records);
    const years = _.uniq(_.map(records, "festival.year"));
    years.sort();

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
                        ${repeat(
                            year === "all" ? sortedRecords : sortedRecords.filter((record) => record.festival && record.festival.year === year),
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
            ${repeat(years, year => navTabItemTemplate(year, year === 0 ? "uncategorized" : year, element.sectionId))}
        </ul>
        <div class="tab-content">
            ${navPaneTemplate("all", "all", element.sectionId, true)}
            ${repeat(years, year => navPaneTemplate(year, year, element.sectionId))}
        </div>
    `;
}

customElements.define("s8f-filmmaker-records", component(S8FFilmmakerRecords, { useShadowDOM: false }));
