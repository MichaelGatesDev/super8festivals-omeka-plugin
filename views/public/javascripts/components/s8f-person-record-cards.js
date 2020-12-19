import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";

import { Person } from "../../../admin/javascripts/utils/s8f-records.js";

function PersonRecordCards(element) {
    const personTemplate = personRecord => html`
        <div class="card d-inline-block text-white bg-primary mb-3 p-4" style="max-width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">
                    ${Person.getFullName(personRecord.person)}
                </h5>
                ${personRecord.url ? html`
                    <a href="${personRecord.url}" class="stretched-link"></a>
                ` : nothing}
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
            ${!element.persons || !Array.isArray(element.persons) || element.persons.length === 0 ? html`
                <p>There aren't any here yet.</p>
            ` : repeat(element.persons, (personRecord) => personTemplate(personRecord))}
        </div>
    `;
}

customElements.define("s8f-person-record-cards", component(PersonRecordCards, { useShadowDOM: false }));
