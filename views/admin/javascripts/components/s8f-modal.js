import { html } from '../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useState, useEffect } from '../../../shared/javascripts/vendor/haunted.js';

function Modal(element) {
    useEffect(() => {
        const modalElem = document.getElementById(element.modalId);
        const modal = new bootstrap.Modal(modalElem);

        modalElem.addEventListener('modal-show', () => {
            modal.show();
        });
        modalElem.addEventListener('modal-hide', () => {
            modal.hide();
        });
    }, []);

    return html`
        <div class="modal fade" .id=${element.modalId} tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${element['modal-title']}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ${element['modal-body']}
                    </div>
                    <div class="modal-footer">
                        ${element['modal-footer']}
                    </div>
                </div>
            </div>
        </div>
    `;
}

Modal.observedAttributes = ['modal-id'];

customElements.define('s8f-modal', component(Modal, { useShadowDOM: false }));