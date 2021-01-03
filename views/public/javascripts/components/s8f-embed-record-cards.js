import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";

import { getAttributeFromElementStr, isEmptyString } from "../../../shared/javascripts/misc.js";
import { Person } from "../../../admin/javascripts/utils/s8f-records.js";

function EmbedRecordCards(element) {

    const [search, setSearch] = useState("");
    const [filtersVisible, setFiltersVisible] = useState(false);

    const filterRecords = (records) => {
        if (isEmptyString(search)) return records;
        return records.filter((r) =>
            r.embed.title.toLowerCase().includes(search.toLowerCase())
            || r.embed.description.toLowerCase().includes(search.toLowerCase())
            || (r.festival && r.festival.year.toString().includes(search.toLowerCase())),
        );
    };

    const embedTemplate = embedRecord => html`
        <div class="card d-inline-block mb-1" style="width: 500px;">
            <div class="card-body">
                <div class="ratio ratio-16x9 ms-2">
                    <iframe class="ratio-item" src="${getAttributeFromElementStr(embedRecord.embed.embed, "src")}" allowfullscreen></iframe>
                </div>
                <h5 class="card-title chomp-single" title=${embedRecord.embed.title}>
                    ${isEmptyString(embedRecord.embed.title) ? "Untitled" : embedRecord.embed.title}
                </h5>
                <p class="card-text chomp-multi-3" title=${embedRecord.embed.description} style="max-height: 75px;">
                    ${isEmptyString(embedRecord.embed.description) ? "No description available." : embedRecord.embed.description}
                </p>
            </div>
            <div class="card-footer">
                <p class="chomp-single" title=${embedRecord.embed.contributor ? Person.getDisplayName(embedRecord.embed.contributor.person) : "N/A"}>
                    Contributor: ${embedRecord.embed.contributor ? Person.getDisplayName(embedRecord.embed.contributor.person) : "N/A"}
                </p>
            </div>
        </div>
    `;

    const filtered = element.embeds && Array.isArray(element.embeds) ? filterRecords(element.embeds) : [];
    return html`
        <style>
            .chomp-single {
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            .chomp-multi-3 {
                height: 75px;
                display: -webkit-box;
                overflow: hidden;
                text-overflow: ellipsis;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
            }
        </style>
        <div class="card-deck">
            <button type="button" class="btn btn-link d-block" @click=${() => { setFiltersVisible(!filtersVisible); }}>
                ${filtersVisible ? "Hide" : "Show"} Filters
            </button>
            ${filtersVisible ? html`
                <div class="d-flex my-2">
                    <label class="me-2">Search</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter Search Query" .value=${search} @keyup=${(e) => { setSearch(e.target.value); }}>
                        <button class="btn btn-outline-secondary" type="button" @click=${() => { setSearch(""); }}>Clear</button>
                    </div>
                </div>
            ` : nothing}
            ${filtered.length === 0 ? html`
                <p>No results found.</p>
            ` : html`
                ${repeat(filterRecords(element.embeds), (fileRecord) => embedTemplate(fileRecord))}
            `}
        </div>
    `;
}

customElements.define("s8f-embed-record-cards", component(EmbedRecordCards, { useShadowDOM: false }));
