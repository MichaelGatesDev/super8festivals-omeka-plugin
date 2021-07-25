import { Person } from "../../../admin/javascripts/utils/s8f-records.js";


import {  getVideoThumbnailFor, isEmptyString } from "../../../shared/javascripts/misc.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";

const S8FCard = element => {

    const { record } = element;

    let title = "";
    let description = "";
    let contributor = undefined;

    if (record.file) {
        title = record.file.title;
        description = record.file.description;
        contributor = record.file.contributor;
    } else if (record.video) {
        title = record.video.title;
        description = record.video.description;
        contributor = record.video.contributor;
    }

    const [thumbnail, setThumbnail] = useState();

    useEffect(() => {
        if (record.video) {
            getVideoThumbnailFor(record.video.url).then((thumb) => {
                setThumbnail(thumb);
            });
        }
    }, []);

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
        <div class="card d-inline-block mb-1" style="width: 250px;" id=${element.id}>
            ${record.file ? (html`
                <a href=${record.file.file_path} data-fancybox=${element.fancyboxId ? `fb-${element.fancyboxId}` : "gallery"} data-caption="${isEmptyString(record.file.description) ? "No description available." : record.file.description}">
                    <img src=${record.file.thumbnail_file_path} class="card-img-top" loading="lazy" alt="" style="height: 200px;">
                </a>
            `) : record.video ? html`
                <a href="${record.video.url}" data-fancybox>
                    <img src="${thumbnail}" class="card-img-top ratio ratio-16x9" loading="lazy" alt="" style="height: 200px;">
                </a>
            ` : nothing}
            <div class="card-body">
                ${record.person ? html`
                    <h5 class="card-title text-center" title=${title}>
                        ${Person.getFullName(record.person)}
                    </h5>
                ` : html`
                    <h5 class="card-title chomp-single" title=${title}>
                        ${isEmptyString(title) ? "Untitled" : title}
                    </h5>
                    <p class="card-text chomp-multi-3" title=${description} style="max-height: 75px;">
                        ${isEmptyString(description) ? "No description available." : description}
                    </p>
                `}
            </div>
            ${!record.person ? html`
                <div class="card-footer">
                    <p class="chomp-single" title=${contributor ? Person.getDisplayName(contributor.person) : "N/A"}>
                        Contributor: ${contributor ? Person.getDisplayName(contributor.person) : "N/A"}
                    </p>
                </div>
            ` : nothing}
        </div>
    `;
};

customElements.define("s8f-card", component(S8FCard, { useShadowDOM: false }));
