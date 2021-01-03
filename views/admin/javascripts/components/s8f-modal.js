import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { Modal as BSModal } from "../../../shared/javascripts/vendor/bootstrap.js";
import { component, useEffect } from "../../../shared/javascripts/vendor/haunted.js";

function Modal(element) {
    useEffect(() => {
        const modalElem = document.getElementById(element.modalId);
        const modal = new BSModal(modalElem);

        modalElem.addEventListener("modal-show", () => {
            modal.show();
        });
        modalElem.addEventListener("modal-hide", () => {
            modal.hide();
        });
    }, []);

    const footer = element["modal-footer"];
    return html`
        <div class="modal fade" .id=${element.modalId} tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${element["modal-title"]}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ${element["modal-body"]}
                    </div>
                    ${footer ? html`
                        <div class="modal-footer">
                            ${footer}
                        </div>
                    ` : nothing}
                </div>
            </div>
        </div>
    `;
}

Modal.observedAttributes = ["modal-id"];

customElements.define("s8f-modal", component(Modal, { useShadowDOM: false }));