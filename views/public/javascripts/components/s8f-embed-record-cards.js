import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";

import { getAttributeFromElementStr, isEmptyString } from "../../../shared/javascripts/misc.js";
import { Person } from "../../../admin/javascripts/utils/s8f-records.js";

function EmbedRecordCards(element) {
    const embedTemplate = embedRecord => html`
        <div class="card d-inline-block mb-1" style="width: 25rem;">
            <div class="card-body">
                <div class="embed-responsive embed-responsive-16by9 mb-2">
                    <iframe class="embed-responsive-item" src="${getAttributeFromElementStr(embedRecord.embed.embed, "src")}" allowfullscreen></iframe>
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
            ${!element.embeds || !Array.isArray(element.embeds) || element.embeds.length === 0 ? html`
                <p>There are none available</p>
            ` : repeat(element.embeds, (embedRecord) => embedTemplate(embedRecord))}
        </div>
    `;
}

customElements.define("s8f-embed-record-cards", component(EmbedRecordCards, { useShadowDOM: false }));
