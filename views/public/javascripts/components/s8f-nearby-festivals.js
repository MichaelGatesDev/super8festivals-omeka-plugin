import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";
import { repeat } from "../../../shared/javascripts/vendor/lit-html/directives/repeat.js";
import API, { HTTPRequestMethod } from "../../../shared/javascripts/api.js";
import Alerts from "../../../admin/javascripts/utils/alerts.js";

function S8FNearbyFestivals(element) {
    const [festivals, setFestivals] = useState();

    const fetchFestivals = async () => {
        try {
            const festivals = await API.performRequest(API.constructURL([
                "countries",
                element.countryId,
                "cities",
                element.cityId,
                "nearby-festivals",
            ]), HTTPRequestMethod.GET);
            setFestivals(festivals);
        } catch (err) {
            Alerts.error("alerts", html`<strong>Error</strong> - Failed to Fetch Nearby Festivals`, err);
            console.error(`Error - Failed to Fetch Nearby Festivals: ${err.message}`);
        }
    };

    useEffect(() => {
        fetchFestivals();
    }, []);

    const navTabItemTemplate = (festival) => {
        return html`
            <li class="nav-item" role="presentation">
                <a
                    id="nearby-festivals-tab-${festival.id}"
                    class="nav-link ${festivals.indexOf(festival) === 0 ? "active" : ""}"
                    data-bs-toggle="tab"
                    href="#nearby-festivals-pane-${festival.id}"
                    role="tab"
                >
                    <span class="text-capitalize">${festival.city_name} ${festival.year === 0 ? "uncategorized" : festival.year}</span>
                </a>
            </li>
        `;
    };

    function navPaneTemplate(festival) {
        return html`
            <div
                id="nearby-festivals-pane-${festival.id}"
                class="tab-pane p-2 ${festivals.indexOf(festival) === 0 ? "active" : ""}"
                role="tabpanel"
            >
                <h4 class="ms-2">Photos</h4>
                <s8f-nearby-festival-photos
                    country-id=${element.countryId}
                    city-id=${element.cityId}
                    festival-id=${festival.id}
                ></s8f-nearby-festival-photos>

                <h4 class="ms-2">Print Media</h4>
                <s8f-nearby-festival-print-media
                    country-id=${element.countryId}
                    city-id=${element.cityId}
                    festival-id=${festival.id}
                ></s8f-nearby-festival-print-media>
            </div>
        `;
    }

    if (!festivals) {
        return html`<p>Loading...</p>`;
    }
    return html`
        <ul class="nav nav-tabs" id="nearby-festival-tabs" role="tablist">
            ${repeat(festivals, $festival => $festival.id, festival => navTabItemTemplate(festival))}
        </ul>
        <div class="tab-content">
            ${repeat(festivals, $festival => $festival.id, festival => navPaneTemplate(festival))}
        </div>
    `;
}

S8FNearbyFestivals.observedAttributes = [
    "country-id",
    "city-id",
];

customElements.define("s8f-nearby-festivals", component(S8FNearbyFestivals, { useShadowDOM: false }));
