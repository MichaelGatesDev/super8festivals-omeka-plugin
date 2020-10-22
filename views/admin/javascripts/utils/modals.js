export default class Modals {
    static update(modal, title, body, footer) {
        const event = new CustomEvent('modal-change', {
            bubbles: true, // this lets the event bubble up through the DOM
            composed: true, // this lets the event cross the Shadow DOM boundary
            detail: {
                title,
                body,
                footer,
            },
        });
        modal._element.dispatchEvent(event);
    }

    static show_custom(modalID) {
        const modalElem = document.getElementById(modalID);
        modalElem.dispatchEvent(new CustomEvent("modal-show"));
    }

    static hide_custom(modalID) {
        const modalElem = document.getElementById(modalID);
        modalElem.dispatchEvent(new CustomEvent("modal-hide"));
    }
}