import { html } from '../../shared/javascripts/vendor/lit-html.js';
import { component, useState, useEffect } from '../../shared/javascripts/vendor/haunted.js';

function Modal({ modalId }) {
    const [modalTitle, setModalTitle] = useState(html`
        Placeholder Title
    `);
    const [modalBody, setModalBody] = useState(html`
        <p>Placeholder Content</p>
    `);
    const [modalFooter, setModalFooter] = useState(html`
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Confirm</button>
    `);

    const onModalChange = (evt) => {
        const { detail } = evt;
        setModalTitle(detail.title);
        setModalBody(detail.body);
        setModalFooter(detail.footer);
    };

    useEffect(() => {

        const modalElem = document.getElementById(modalId);

        modalElem.addEventListener('modal-change', onModalChange);

        const modal = new bootstrap.Modal(modalElem);

        this.dispatchEvent(new CustomEvent("modal-update", {
            bubbles: true, // this lets the event bubble up through the DOM
            composed: true, // this lets the event cross the Shadow DOM boundary
            detail: {
                modal,
            } // all data you wish to pass must be in `detail`
        }));
    }, []);

    return html`
        <div class="modal fade" .id=${modalId} tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${modalTitle}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ${modalBody}
                    </div>
                    <div class="modal-footer">
                        ${modalFooter}
                    </div>
                </div>
            </div>
        </div>
    `;
}

Modal.observedAttributes = ['modal-id'];

customElements.define('s8f-modal', component(Modal, { useShadowDOM: false }));