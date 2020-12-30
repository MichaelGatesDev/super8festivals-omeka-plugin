import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component } from "../../../shared/javascripts/vendor/haunted.js";


import { getAttributeFromElementStr, isEmptyString } from "../../../shared/javascripts/misc.js";

function S8FCard(element) {

    const { record } = element;

    let title = "";
    let description = "";
    let contributor = "";

    if (record.file) {
        title = record.file.title;
        description = record.file.description;
        contributor = record.file.contributor ? Person.getDisplayName(record.file.contributor) : "";
    } else if (record.embed) {
        title = record.embed.title;
        description = record.embed.description;
        contributor = record.embed.contributor ? Person.getDisplayName(record.embed.contributor) : "";
    }
    if (isEmptyString(title)) {
        title = "Untitled";
    }
    if (isEmptyString(description)) {
        description = "No description available.";
    }
    if (isEmptyString(contributor)) {
        contributor = "N/A";
    }

    const toggleDetails = (state) => {
        const elem = element.querySelector(".card-details");
        if (!elem) return;
        elem.classList.remove(state ? "hidden" : "visible");
        elem.classList.add(state ? "visible" : "hidden");
    };

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
        <div
            id="${element.id}"
            class="card d-inline-block mb-1"
            style="width: 250px;"
            @mouseenter=${() => { toggleDetails(true); }}
            @mouseleave=${() => { toggleDetails(false); }}
        >
            ${record.file ? (html`
                <a
                    href=${record.file.file_path}
                    data-fancybox=${element.fancyboxId ? `fb-${element.fancyboxId}` : "gallery"}
                    data-caption="${description}"
                >
                    <img src=${record.file.thumbnail_file_path} class="card-img-top" loading="lazy" alt="" style="height: 200px;">
                </a>
            `) : record.embed ? html`
                <div class="ratio ratio-16x9 mb-2">
                    <iframe class="ratio-item" src="${getAttributeFromElementStr(record.embed.embed, "src")}" allowfullscreen></iframe>
                </div>
            ` : nothing}
            ${record.file ? html`
                <div class="card-details text-center hidden">
                    <p class="m-0 p-2">${title}</p>
                </div>
            ` : record.embed ? html`
                <div class="card-body">
                    <h5 class="card-title">${title}</h5>
                    <p class="card-text">${description}</p>
                    <p class="card-text"><small class="text-muted">Contributor: ${contributor}</small></p>
                </div>
            ` : nothing}
        </div>
    `;
}

customElements.define("s8f-card", component(S8FCard, { useShadowDOM: false }));
