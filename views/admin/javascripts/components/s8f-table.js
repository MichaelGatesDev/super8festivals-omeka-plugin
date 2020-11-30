import { html } from '../../../shared/javascripts/vendor/lit-html.js';
import { repeat } from '../../../shared/javascripts/vendor/lit-html/directives/repeat.js';
import { component } from '../../../shared/javascripts/vendor/haunted.js';

function Table(element) {
    const tableHeaderTemplate = (header) => {
        return html`<td>${header}</td>`;
    };

    const tableRowCellTemplate = (cell) => {
        return html`<td>${cell}</td>`;
    };

    const tableRowTemplate = (row) => {
        return html`
        <tr>
            ${repeat(Object.values(row), (cell) => tableRowCellTemplate(cell))}
        </tr>
        `;
    };

    return html`
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                ${repeat(element.headers, (header) => tableHeaderTemplate(header))}
            </tr>
        </thead>
        <tbody>
            ${repeat(element.rows, (row) => tableRowTemplate(row))}
        </tbody>
    </table>
    `;
}

customElements.define('s8f-table', component(Table, { useShadowDOM: false }));
