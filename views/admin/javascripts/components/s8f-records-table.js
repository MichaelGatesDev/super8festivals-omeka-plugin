import { html, nothing } from "../../../shared/javascripts/vendor/lit-html.js";
import { unsafeHTML } from "../../../shared/javascripts/vendor/lit-html/directives/unsafe-html.js";
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
        const accessed = _.get(obj, accessor);
        if (accessor.endsWith("file")) {
            if (!accessed) {
                return html`<span>N/A</span>`;
            }
            let fileAnchorContent = accessed.file_name;
            if (accessed.thumbnail_file_name && accessed.thumbnail_file_name !== "") {
                fileAnchorContent = html`<img src="${accessed.thumbnail_file_path}" class="img-fluid img-thumbnail" width="64" height="64">`;
            }
            return html`<a href=${accessed.file_path} target="_blank" rel="noopener">${fileAnchorContent}</a>`;
        }
        if (accessor.endsWith("embed")) {
            if (!accessed) {
                return html`<span>N/A</span>`;
            }
            return html`
                <div>${unsafeHTML(accessed.embed)}</div>
            `;
        }
        if (accessor.endsWith("video")) {
            if (!accessed) {
                return html`<span>N/A</span>`;
            }
            return html`
                <a href="${accessed.url}" rel="noreferrer" target="_blank">${accessed.url}</a>
            `;
        }
        if (accessor.endsWith("actions")) {
            return html`
                <div class="btn-group">
                    ${rowViewFunc ? html`
                        <button type="button" class="btn btn-info btn-sm" @click=${() => { rowViewFunc(obj); }}>View</button>
                    ` : nothing}
                    ${rowEditFunc ? html`
                        <button type="button" class="btn btn-primary btn-sm" @click=${() => { rowEditFunc(obj); }}>Edit</button>
                    ` : nothing}
                    ${rowDeleteFunc ? html`
                        <button type="button" class="btn btn-danger btn-sm" @click=${() => { rowDeleteFunc(obj); }}>Delete</button>
                    ` : nothing}
                </div>
            `;
        }
        if(accessor.includes(".is_")) {
            return html`<span>${!!accessed}</span>`;
        }

        return _.get(obj, accessor);
    };

    const rowsTemplate = () => {
        if (tableRows) {
            return tableRows.map((row) => headers.map((header) => getCellHtml(row, header.accessor)));
        }
        return [Array.from({ length: headers.length }).map(() => "Loading...")];
    };

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
            .rows=${rowsTemplate()}
        ></s8f-table>
    `;
}

customElements.define("s8f-records-table", component(RecordsTable, { useShadowDOM: false }));
