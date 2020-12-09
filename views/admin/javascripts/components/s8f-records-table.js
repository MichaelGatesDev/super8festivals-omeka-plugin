import { html } from "../../../shared/javascripts/vendor/lit-html.js";
import { unsafeHTML } from "../../../shared/javascripts/vendor/lit-html/directives/unsafe-html.js"
import { component } from "../../../shared/javascripts/vendor/haunted.js";
import _ from "../../../shared/javascripts/vendor/lodash.js";

function RecordsTable(
    element,
) {
    const {
        tableRows,
        tableColumns,
        rowViewFunc,
        rowEditFunc,
        rowDeleteFunc,
    } = element;

    const headers = [...tableColumns, { title: "Actions", accessor: "actions" }];
    const headerTitles = [...tableColumns, { title: "Actions", accessor: "actions" }].map((tc) => tc.title);

    const getCellHtml = (obj, accessor) => {
        if (accessor === "file") {
            if(!obj.file) {
                return html`<span>N/A</span>`;
            }
            let fileAnchorContent = obj.file.file_name;
            if (obj.file.thumbnail_file_name && obj.file.thumbnail_file_name !== "") {
                fileAnchorContent = html`<img src="${obj.file.thumbnail_file_path}" class="img-fluid img-thumbnail" width="64" height="64">        `;
            }
            return html`<a href=${obj.file.file_path} target="_blank" rel="noopener">${fileAnchorContent}</a>`;
        }
        if (accessor === "embed") {
            if(!obj.embed) {
                return html`<span>N/A</span>`;
            }
            return html`<div>${unsafeHTML(obj.embed.embed)}</div>`;
        }
        if (accessor === "actions") {
            return html`
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm" @click=${() => { rowViewFunc(obj); }}>View</button>
                    <button type="button" class="btn btn-primary btn-sm" @click=${() => { rowEditFunc(obj); }}>Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" @click=${() => { rowDeleteFunc(obj); }}>Delete</button>
                </div>
            `;
        }

        return _.get(obj, accessor);
    };

    const rows = tableRows.map((row) => headers.map((header) => getCellHtml(row, header.accessor)));

    return html`
        <style>
            table td div iframe {
                width: 240px;
                height: 144px;
            }
        </style>
        <s8f-table
            id=${element.id}
            .headers=${headerTitles}
            .rows=${rows}
        ></s8f-table>
    `;
}

customElements.define("s8f-records-table", component(RecordsTable, { useShadowDOM: false }));
