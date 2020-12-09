import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { component, useEffect, useState } from "../../../shared/javascripts/vendor/haunted.js";

function AlertsArea(element) {
    const [alerts, setAlerts] = useState([]);

    useEffect(() => {
        element.addEventListener("alert-set", (evt) => {
            const alertObj = evt.detail;
            setAlerts([alertObj]);
        });
        element.addEventListener("alerts-add", (evt) => {
            const alertObj = evt.detail;
            addAlert(alertObj);
        });
        element.addEventListener("alerts-remove", (evt) => {
            removeAlert(evt.detail.id);
        });
        element.addEventListener("alerts-reset", (evt) => {
            setAlerts([]);
        });
    }, []);

    useEffect(() => {
        alerts.forEach((alert, idx) => {
            if (!alert.timeout) return;
            setTimeout(() => removeAlert(idx), alert.timeout);
        });
    }, [alerts]);

    const style = () => html`
        <style>
            .alert-area {
                padding-top: 1em;
            }

            .alert-area .alert {
                margin-bottom: 0.5em;
            }
        </style>
    `;

    const removeAlert = (idxToRemove) => {
        setAlerts(oldAlerts => oldAlerts.filter((alert, idx) => idx !== idxToRemove));
    };

    const addAlert = (toAdd) => {
        setAlerts(oldAlerts => [...oldAlerts, toAdd]);
    };

    const alertsElem = () => {
        return alerts.map((alert, idx) => {
            return html`
                <div class="alert alert-${alert.level} alert-dismissible fade show" role="alert">
                    <button type="button" class="close" aria-label="Close" @click=${() => { removeAlert(idx); }}>
                        <span aria-hidden="true">&times;</span>
                    </button>
                    ${alert.header && (html`<h4 class="alert-heading">${alert.header}</h4>`)}
                    ${alert.body && html`${alert.body}`}
                </div>
            `;
        });
    };

    if (alerts.length === 0) return nothing;
    return html`
        ${style()}
        <div>
            ${alertsElem()}
        </div>
    `;
}

customElements.define("s8f-alerts-area", component(AlertsArea, { useShadowDOM: false }));
