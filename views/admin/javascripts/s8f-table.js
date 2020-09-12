import { html, nothing } from '../../shared/javascripts/vendor/lit-html.js';
import { component, useState, useEffect } from '../../shared/javascripts/vendor/haunted.js';

function Table() {
    const [tableHeaders, setTableHeaders] = useState([]);
    const [tableRows, setTableRows] = useState([]);

    const onTableChange = (evt) => {
        const { detail } = evt;

        if (detail.headers) setTableHeaders(detail.headers);
        if (detail.rows) setTableRows(detail.rows);
    }

    useEffect(() => {
        this.addEventListener('s8f-table-change', onTableChange);
    }, []);

    return html`
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                ${tableHeaders.map((header) => html`<td>${header}</td>`)}
            </tr>
        </thead>
        <tbody>
            ${tableRows.map((row) => html`
            <tr>
                ${row.map((value) => html`
                    <td>
                        ${value}
                    </td>
                `)}
            </tr>
            `)}
        </tbody>
    </table>
    `;
}

customElements.define('s8f-table', component(Table, { useShadowDOM: false }));
