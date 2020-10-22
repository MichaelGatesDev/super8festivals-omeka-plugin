import { html, nothing } from '../../../../shared/javascripts/vendor/lit-html/lit-html.js';
import { component, useState, useEffect } from '../../../../shared/javascripts/vendor/haunted.js';
import { Modal } from "../../../../shared/javascripts/vendor/bootstrap/js/bootstrap.esm.js";

function CountryModal({ modalId }) {

    const [mode, setMode] = useState("add");
    const [modal, setModal] = useState();

    const [id, setId] = useState();
    const [name, setName] = useState("");
    const [latitude, setLatitude] = useState(0);
    const [longitude, setLongitude] = useState(0);

    const reset = () => {
        setId(null);
        setName("");
        setLatitude(0);
        setLongitude(0);
    };

    useEffect(() => {
        const modalElem = document.getElementById(modalId);
        const modal = new Modal(modalElem);
        setModal(modal);

        modalElem.addEventListener('modal-show', (evt) => {
            const mode = evt.detail.mode;
            setMode(mode);

            const country = evt.detail.country;
            if (country) {
                setId(country.id);
                setName(country.name);
                setLatitude(country.latitude);
                setLongitude(country.longitude);
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
    //     console.log({ name, latitude, longitude });
    // }, [name, latitude, longitude]);

    const onSubmit = () => {
        this.dispatchEvent(new CustomEvent("modal-form-submit", {
            bubbles: true, // this lets the event bubble up through the DOM
            composed: true, // this lets the event cross the Shadow DOM boundary
            detail: {
                id,
                name,
                latitude,
                longitude,
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
                <p>Are you sure you want to delete <span class="text-capitalize font-weight-bold">${name}</span>?</p>
                <p class="text-danger">Warning: This can not be undone.</p>
            `;
        }

        return html`
        <form id="form">
            <div class="mb-3">
                <label for="form-name" class="form-label">City Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="form-name" 
                    name="name" 
                    aria-describedby="formCityHelp"
                    placeholder=""
                    .value=${name}
                    @change=${evt => setName(evt.target.value)}
                >
            </div>
            <div class="mb-3">
                <label for="form-latitude" class="form-label">City Latitude</label>
                <input 
                    type="number"
                    step="0.0001"
                    class="form-control" 
                    id="form-latitude"
                    name="latitude" 
                    aria-describedby="formCityHelp" 
                    placeholder="1.234"
                    .value=${latitude}
                    @change=${evt => setLatitude(evt.target.value)}
                 >
            </div>
            <div class="mb-3">
                <label for="form-longitude" class="form-label">City Longitude</label>
                <input 
                    type="number"
                    step="0.0001"
                    class="form-control" 
                    id="form-longitude"
                    name="longitude" 
                    aria-describedby="formCityHelp" 
                    placeholder="-4.567"
                    .value=${longitude}
                    @change=${evt => setLongitude(evt.target.value)}
                 >
            </div>
        </form>`;
    };

    return html`
    <div class="modal fade" id=${modalId} tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">${mode} Country</h5>
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

CountryModal.observedAttributes = ['modal-id'];

customElements.define('s8f-country-modal', component(CountryModal, { useShadowDOM: false }));
