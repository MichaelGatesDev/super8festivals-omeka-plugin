import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useState } from "../../../shared/javascripts/vendor/haunted.js";


import { isEmptyString } from "../../../shared/javascripts/misc.js";
import { Person } from "../../../admin/javascripts/utils/s8f-records.js";

function S88FBSCard(element) {

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
        <div class="card d-inline-block mb-1" style="width: 250px;">
            <a href=${fileRecord.file.file_path} data-fancybox=${element.fancyboxId ? `fb-${element.fancyboxId}` : "gallery"} data-caption="${isEmptyString(fileRecord.file.description) ? "No description available." : fileRecord.file.description}">
                <img src=${fileRecord.file.thumbnail_file_path} class="card-img-top" loading="lazy" alt="" style="height: 200px;">
            </a>
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
}

customElements.define("s8f-bs-card", component(S88FBSCard, { useShadowDOM: false }));
