import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";

import { isEmptyString } from "../../../shared/javascripts/misc.js";
import { Person } from "../../../admin/javascripts/utils/s8f-records.js";

function FileRecordCards(element) {
    const fileTemplate = fileRecord => html`
        <div class="card d-inline-block mb-1" style="width: 250px;">
            <div class="card-body">
                <img src=${fileRecord.file.thumbnail_file_path} class="card-img-top" loading="lazy">
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
            ${!element.files || !Array.isArray(element.files) || element.files.length === 0 ? html`
                <p>There aren't any here yet.</p>
            ` : repeat(element.files, (fileRecord) => fileTemplate(fileRecord))}
        </div>
    `;
}

customElements.define("s8f-file-record-cards", component(FileRecordCards, { useShadowDOM: false }));
