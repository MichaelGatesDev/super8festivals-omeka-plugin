import { html, nothing } from '../../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useState, useEffect } from '../../../../shared/javascripts/vendor/haunted.js';
import { Modal } from "../../../../shared/javascripts/vendor/bootstrap/js/bootstrap.esm.js";

function FestivalModal({ modalId }) {

    const [mode, setMode] = useState("add");
    const [modal, setModal] = useState();

    const [id, setId] = useState();
    const [year, setYear] = useState();

    const reset = () => {
        setId(null);
        setYear(0);
    };

    useEffect(() => {
        const modalElem = document.getElementById(modalId);
        const modal = new Modal(modalElem);
        setModal(modal);

        modalElem.addEventListener('modal-show', (evt) => {
            const mode = evt.detail.mode;
            setMode(mode);

            const festival = evt.detail.festival;
            if (festival) {
                setId(festival.id);
                setYear(festival.year);
            } else {
                reset();
            }

            modal.show();
        });
        modalElem.addEventListener('modal-hide', () => {
            reset();
            modal.hide();
        });

    }, []);

    // used for debugging
    // useEffect(() => {
    //     console.log({ name, latitude, longitude, description });
    // }, [name, latitude, longitude, description]);

    const onSubmit = () => {
        this.dispatchEvent(new CustomEvent("modal-form-submit", {
            bubbles: true, // this lets the event bubble up through the DOM
            composed: true, // this lets the event cross the Shadow DOM boundary
            detail: {
                id,
                year,
            },
        }));
    };

    const onDelete = () => {
        this.dispatchEvent(new CustomEvent("modal-form-delete", {
            bubbles: true, // this lets the event bubble up through the DOM
            composed: true, // this lets the event cross the Shadow DOM boundary
            detail: {
                id,
            },
        }));
    }

    const body = () => {
        if (mode === "delete") {
            return html`
                <p>Are you sure you want to delete <span class="text-capitalize font-weight-bold">${year}</span>?</p>
                <p class="text-danger">Warning: This can not be undone.</p>
            `;
        }

        return html`
        <form id="form">
            <div class="mb-3">
                <label for="form-year" class="form-label">Festival Year</label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="form-year" 
                    name="year" 
                    aria-describedby="formFestivalHelp"
                    placeholder=""
                    .value=${year}
                    @change=${evt => setYear(evt.target.value)}
                >
            </div>
        </form>`;
    };

    return html`
    <div class="modal fade" id=${modalId} tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">${mode} City</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ${body()}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click=${() => { if (mode === "delete") onDelete(); else onSubmit(); }}>Confirm</button>
                </div>
            </div>
        </div>
    </div>
    `;
}

FestivalModal.observedAttributes = ['modal-id'];

customElements.define('s8f-festival-modal', component(FestivalModal, { useShadowDOM: false }));
