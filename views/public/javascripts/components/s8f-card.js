import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component } from "../../../shared/javascripts/vendor/haunted.js";


import { getAttributeFromElementStr, isEmptyString } from "../../../shared/javascripts/misc.js";
import { Person } from "../../../admin/javascripts/utils/s8f-records.js";

function S8FCard(element) {
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
            ${element.record.file ? (html`
                <a href=${element.record.file.file_path} data-fancybox=${element.fancyboxId ? `fb-${element.fancyboxId}` : "gallery"} data-caption="${isEmptyString(element.record.file.description) ? "No description available." : element.record.file.description}">
                    <img src=${element.record.file.thumbnail_file_path} class="card-img-top" loading="lazy" alt="" style="height: 200px;">
                </a>
            `) : element.record.embed ? html`
                <div class="ratio ratio-16x9 mb-2">
                    <iframe class="ratio-item" src="${getAttributeFromElementStr(element.record.embed.embed, "src")}" allowfullscreen></iframe>
                </div>
            ` : nothing}
            <div class="card-body">
                <h5 class="card-title chomp-single" title=${element.record.file.title}>
                    ${isEmptyString(element.record.file.title) ? "Untitled" : element.record.file.title}
                </h5>
                <p class="card-text chomp-multi-3" title=${element.record.file.description} style="max-height: 75px;">
                    ${isEmptyString(element.record.file.description) ? "No description available." : element.record.file.description}
                </p>
            </div>
            <div class="card-footer">
                <p class="chomp-single" title=${element.record.file.contributor ? Person.getDisplayName(element.record.file.contributor.person) : "N/A"}>
                    Contributor: ${element.record.file.contributor ? Person.getDisplayName(element.record.file.contributor.person) : "N/A"}
                </p>
            </div>
        </div>
    `;
}

customElements.define("s8f-card", component(S8FCard, { useShadowDOM: false }));
