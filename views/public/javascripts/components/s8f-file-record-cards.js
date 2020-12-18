import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";


import { isEmptyString } from "../../../shared/javascripts/misc.js";
import { Person } from "../../../admin/javascripts/utils/s8f-records.js";

function FileRecordCards(element) {

    const [search, setSearch] = useState("");
    const [filtersVisible, setFiltersVisible] = useState(false);

    const filterRecords = (records) => {
        if (isEmptyString(search)) return records;
        return records.filter((r) =>
            r.file.title.toLowerCase().includes(search.toLowerCase())
            || r.file.description.toLowerCase().includes(search.toLowerCase()),
        );
    };

    const fileTemplate = fileRecord => html`
        <div class="card d-inline-block mb-1" style="width: 250px;">
            <img src=${fileRecord.file.thumbnail_file_path} class="card-img-top" loading="lazy" alt="">
            <div class="card-body">
                <h5 class="card-title chomp-single" title=${fileRecord.file.title}>
                    ${isEmptyString(fileRecord.file.title) ? "Untitled" : fileRecord.file.title}
                </h5>
                <p class="card-text chomp-multi-3" title=${fileRecord.file.description} style="max-height: 75px;">
                    ${isEmptyString(fileRecord.file.description) ? "No description available." : fileRecord.file.description}
                </p>
            </div>
            <div class="card-footer">
                <p class="chomp-single" title=${fileRecord.file.contributor ? Person.getDisplayName(fileRecord.file.contributor.person) : "N/A"}>
                    Contributor: ${fileRecord.file.contributor ? Person.getDisplayName(fileRecord.file.contributor.person) : "N/A"}
                </p>
            </div>
        </div>
    `;

    const filtered = element.files && Array.isArray(element.files) ? filterRecords(element.files) : [];
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
                    <label class="mr-2">Search</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter Search Query" .value=${search} @keyup=${(e) => { setSearch(e.target.value); }}>
                        <button class="btn btn-outline-secondary" type="button" @click=${() => { setSearch(""); }}>Clear</button>
                    </div>
                </div>
            ` : nothing}
            ${filtered.length === 0 ? html`
                <p>No results found.</p>
            ` : html`
                ${repeat(filterRecords(element.files), (fileRecord) => fileTemplate(fileRecord))}
            `}
        </div>
    `;
}

customElements.define("s8f-file-record-cards", component(FileRecordCards, { useShadowDOM: false }));
