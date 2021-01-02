import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Alerts from "../../../admin/javascripts/utils/alerts.js";

function S8FNearbyFestivalPrintMedia(element) {
    const [records, setRecords] = useState();

    const fetchPrintMedia = async () => {
        try {
            const festivals = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "nearby-festivals",
                element.festivalId,
                "print-media",
            ]), HTTPRequestMethod.GET);
            setRecords(festivals);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Nearby Festival Print Media`, err);
            console.error(`Error - Failed to Fetch Nearby Festival Print Media: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchPrintMedia();
    }, []);


    function recordTemplate(record) {
        return html`
            <s8f-card .record=${record} .fancyboxId=${"nearby-festival-print-media"} id=${`nearby-festival-print-media-${record.id}`}></s8f-card>
        `;
    }

    if (!records || !Array.isArray(records)) {
        return html`<p>Loading...</p>`;
    }
    if (records.length === 0) {
        return html`<p>No results.</p>`;
    }
    return html`
        <div class="row">
            <div class="col mb-4">
                ${repeat(records, $festival => $festival.id, festival => recordTemplate(festival))}
            </div>
        </div>
    `;
}

S8FNearbyFestivalPrintMedia.observedAttributes = [
    "country-id",
    "city-id",
    "festival-id",
];

customElements.define("s8f-nearby-festival-print-media", component(S8FNearbyFestivalPrintMedia, { useShadowDOM: false }));
