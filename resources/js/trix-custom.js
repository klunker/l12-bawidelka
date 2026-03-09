// ────────────────────────────────────────────────────────────────────────────
// Trix config – must run BEFORE any editor initializes
// ────────────────────────────────────────────────────────────────────────────
let trixConfigured = false;

function configureTrix() {
    if (trixConfigured || !window.Trix) {
        return;
    }

    trixConfigured = true;

    Trix.config.dompurify.ADD_TAGS = ['div', 'h3', 'ul', 'ol', 'li'];
    Trix.config.dompurify.ADD_ATTR = [
        'data-tlist',
        'data-trix-attachment',
        'data-trix-content-type',
    ];
}

document.addEventListener('trix-before-initialize', function () {
    configureTrix();
});

// ────────────────────────────────────────────────────────────────────────────
// Modal
// ────────────────────────────────────────────────────────────────────────────

/**
 * Build the HTML string for a tlist block.
 *
 * @param {{ title: string, items: string[] }} data
 * @returns {string}
 */
function buildTlistHtml(data) {
    const itemsHtml = data.items
        .filter((item) => item.trim() !== '')
        .map((item) => `<li>${item}</li>`)
        .join('');

    return `<div class="custom-tlist" data-tlist="true"><h3>${data.title}</h3><ul>${itemsHtml}</ul></div>`;
}

/**
 * Parse existing tlist HTML back into editable data.
 *
 * @param {string} html
 * @returns {{ title: string, items: string[] }}
 */
function parseTlistHtml(html) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const div = doc.querySelector('[data-tlist]');

    if (!div) {
        return { title: '', items: [''] };
    }

    const title = div.querySelector('h3')?.textContent ?? '';
    const items = Array.from(div.querySelectorAll('li')).map(
        (li) => li.textContent,
    );

    return { title, items: items.length ? items : [''] };
}

/**
 * Open the modal. Resolves with the filled data, or null if cancelled.
 *
 * @param {{ title: string, items: string[] }} [initialData]
 * @returns {Promise<{ title: string, items: string[] } | null>}
 */
function openTlistModal(initialData) {
    return new Promise((resolve) => {
        const data = initialData ?? { title: '', items: [''] };

        // Overlay
        const overlay = document.createElement('div');
        overlay.className = 'tlist-modal-overlay';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');

        // Dialog box
        const dialog = document.createElement('div');
        dialog.className = 'tlist-modal-dialog';
        dialog.innerHTML = `
            <div class="tlist-modal-header">
                <h2 class="tlist-modal-title">List – edit</h2>
                <button type="button" class="tlist-modal-close" aria-label="Close">&times;</button>
            </div>
            <div class="tlist-modal-body">
                <label class="tlist-modal-label">
                    Heading
                    <input type="text" class="tlist-modal-input" id="tlist-title" placeholder="Enter heading..." value="${data.title}">
                </label>
                <div class="tlist-modal-label">
                    List items
                    <ul class="tlist-items-list" id="tlist-items"></ul>
                    <button type="button" class="tlist-add-item">+ Add item</button>
                </div>
            </div>
            <div class="tlist-modal-footer">
                <button type="button" class="tlist-btn tlist-btn-cancel">Cancel</button>
                <button type="button" class="tlist-btn tlist-btn-submit">Insert</button>
            </div>
        `;

        overlay.appendChild(dialog);
        document.body.appendChild(overlay);

        const itemsList = dialog.querySelector('#tlist-items');
        const titleInput = dialog.querySelector('#tlist-title');

        function addItem(value = '') {
            const li = document.createElement('li');
            li.className = 'tlist-item-row';
            li.innerHTML = `
                <input type="text" class="tlist-modal-input" placeholder="List item..." value="${value}">
                <button type="button" class="tlist-remove-item" aria-label="Remove">&times;</button>
            `;
            li.querySelector('.tlist-remove-item').addEventListener(
                'click',
                () => {
                    if (itemsList.children.length > 1) {
                        li.remove();
                    }
                },
            );
            itemsList.appendChild(li);
            li.querySelector('input').focus();
        }

        // Populate initial items
        data.items.forEach((item) => addItem(item));

        dialog
            .querySelector('.tlist-add-item')
            .addEventListener('click', () => addItem());

        function close(result) {
            overlay.remove();
            resolve(result);
        }

        dialog
            .querySelector('.tlist-modal-close')
            .addEventListener('click', () => close(null));
        dialog
            .querySelector('.tlist-btn-cancel')
            .addEventListener('click', () => close(null));
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                close(null);
            }
        });

        dialog
            .querySelector('.tlist-btn-submit')
            .addEventListener('click', () => {
                const title = titleInput.value.trim();
                const items = Array.from(
                    itemsList.querySelectorAll('input'),
                ).map((i) => i.value.trim());
                close({ title, items });
            });

        // Keyboard
        overlay.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                close(null);
            }
        });

        // Autofocus title
        requestAnimationFrame(() => titleInput.focus());
    });
}

// ────────────────────────────────────────────────────────────────────────────
// Button injection
// ────────────────────────────────────────────────────────────────────────────
function injectButton(toolbar) {
    if (toolbar.dataset.tlistInjected) {
        return;
    }

    toolbar.dataset.tlistInjected = '1';

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'trix-button text-white dark:text-black';
    button.setAttribute('data-trix-action', 'x-tlist');
    button.title = 'Add list';
    button.setAttribute('tabindex', '-1');
    button.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <!-- Bold T letter on the left -->
            <line x1="2" y1="5" x2="10" y2="5"></line>
            <line x1="6" y1="5" x2="6" y2="19"></line>
            <!-- List lines on the right -->
            <line x1="13" y1="8" x2="22" y2="8"></line>
            <line x1="13" y1="13" x2="22" y2="13"></line>
            <line x1="13" y1="18" x2="22" y2="18"></line>
            <!-- Small dots for list bullets -->
            <circle cx="11.5" cy="8"  r="0.8" fill="currentColor" stroke="none"></circle>
            <circle cx="11.5" cy="13" r="0.8" fill="currentColor" stroke="none"></circle>
            <circle cx="11.5" cy="18" r="0.8" fill="currentColor" stroke="none"></circle>
        </svg>
    `;

    // Target only main toolbar groups, not groups inside dialogs
    const groups = Array.from(
        toolbar.querySelectorAll('[data-trix-button-group]'),
    ).filter((el) => !el.closest('.trix-dialog'));
    const target = groups.length ? groups[groups.length - 1] : toolbar;
    target.appendChild(button);
}

function scanForToolbars() {
    document.querySelectorAll('trix-toolbar').forEach(injectButton);
}

const toolbarObserver = new MutationObserver(function (mutations) {
    for (const mutation of mutations) {
        for (const node of mutation.addedNodes) {
            if (!(node instanceof Element)) {
                continue;
            }

            if (node.tagName === 'TRIX-TOOLBAR') {
                injectButton(node);
            }

            node.querySelectorAll('trix-toolbar').forEach(injectButton);
        }
    }
});

toolbarObserver.observe(document.body, { childList: true, subtree: true });

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', scanForToolbars);
} else {
    scanForToolbars();
}

// ────────────────────────────────────────────────────────────────────────────
// Insert new tlist via toolbar button
// ────────────────────────────────────────────────────────────────────────────
document.addEventListener('trix-action-invoke', async function (event) {
    if (event.actionName !== 'x-tlist') {
        return;
    }

    const editor = event.target.editor;
    const data = await openTlistModal();

    if (!data) {
        return;
    }

    const html = buildTlistHtml(data);
    editor.recordUndoEntry('Insert list');
    editor.insertAttachment(
        new Trix.Attachment({
            content: html,
            contentType: 'application/vnd.tlist',
        }),
    );
});

// ────────────────────────────────────────────────────────────────────────────
// Edit existing tlist by clicking on it inside the editor
// ────────────────────────────────────────────────────────────────────────────
document.addEventListener('click', async function (event) {
    const tlistEl = event.target.closest('[data-tlist]');

    if (!tlistEl) {
        return;
    }

    // Find the trix-editor that contains this element
    const editorEl = tlistEl.closest('trix-editor');

    if (!editorEl) {
        return;
    }

    event.preventDefault();
    event.stopPropagation();

    // Extract the outer HTML of the tlist block to prefill the modal
    const currentHtml = tlistEl.closest('figure')?.dataset?.trixAttachment
        ? JSON.parse(tlistEl.closest('figure').dataset.trixAttachment).content
        : tlistEl.outerHTML;

    const initialData = parseTlistHtml(currentHtml);
    const data = await openTlistModal(initialData);

    if (!data) {
        return;
    }

    const editor = editorEl.editor;
    const newHtml = buildTlistHtml(data);

    // Find and replace the attachment in the document
    const document_ = editor.getDocument();

    // Select the attachment (it occupies a single character position in Trix's model)
    // Walk through attachment pieces to find the matching one
    const pieces = document_.getBlocks().flatMap((block) => block.pieces ?? []);
    let pos = 0;

    for (const piece of pieces) {
        if (
            piece.attachment &&
            piece.attachment.attributes.values.content === currentHtml
        ) {
            editor.recordUndoEntry('Edit tlist');
            editor.setSelectedRange([pos, pos + 1]);
            editor.insertAttachment(
                new Trix.Attachment({
                    content: newHtml,
                    contentType: 'application/vnd.tlist',
                }),
            );
            break;
        }

        pos += piece.toString ? piece.toString().length : 1;
    }
});

// ────────────────────────────────────────────────────────────────────────────
// Styles  (Filament-compatible, respects html.dark)
// ────────────────────────────────────────────────────────────────────────────
const styleSheet = document.createElement('style');
styleSheet.textContent = `
    /* ── CSS tokens (light) – matches Filament light panel ── */
    .tlist-modal-overlay,
    .tlist-modal-overlay * {
        --tlist-bg:          #ffffff;
        --tlist-bg-subtle:   #f5f5f4;
        --tlist-border:      #e4e4e7;
        --tlist-text:        #18181b;
        --tlist-text-muted:  #71717a;
        --tlist-input-bg:    #ffffff;
        --tlist-input-bd:    #d4d4d8;
        --tlist-hover-bg:    #f4f4f5;
        --tlist-danger:      #ef4444;
        --tlist-primary:     var(--fi-primary, #f59e0b);
        --tlist-primary-dk:  color-mix(in srgb, var(--tlist-primary) 80%, #000);
        --tlist-ring:        color-mix(in srgb, var(--tlist-primary) 25%, transparent);
    }

    /* ── CSS tokens (dark) – matches Filament dark panel (#1a1a1a bg) ── */
    html.dark .tlist-modal-overlay,
    html.dark .tlist-modal-overlay * {
        --tlist-bg:          #262626;
        --tlist-bg-subtle:   #1a1a1a;
        --tlist-border:      #3d3d3d;
        --tlist-text:        #fafafa;
        --tlist-text-muted:  #a1a1aa;
        --tlist-input-bg:    #303030;
        --tlist-input-bd:    #3d3d3d;
        --tlist-hover-bg:    #303030;
    }

    /* ── Toolbar button ── */
    .trix-button[data-trix-action="x-tlist"] {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        padding: 0;
        border: none;
        background: transparent;
        color: #52525b;
        cursor: pointer;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .trix-button[data-trix-action="x-tlist"]:hover {
        background-color: rgba(0,0,0,.07);
        color: #18181b;
    }

    html.dark .trix-button[data-trix-action="x-tlist"] { color: #a1a1aa; }
    html.dark .trix-button[data-trix-action="x-tlist"]:hover {
        background-color: rgba(255,255,255,.07);
        color: #fafafa;
    }

    .trix-button[data-trix-action="x-tlist"] svg { pointer-events: none; display: block; }

    /* ── Rendered tlist block in editor ── */
    .trix-content [data-tlist],
    trix-editor [data-tlist] {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px 18px;
        margin: 12px 0;
        background: #f9fafb;
        cursor: pointer;
        transition: border-color .15s;
    }

    .trix-content [data-tlist]:hover,
    trix-editor [data-tlist]:hover { border-color: #6366f1; }

    .trix-content [data-tlist] h3,
    trix-editor [data-tlist] h3 { margin: 0 0 8px; font-size: 1rem; font-weight: 600; color: #111827; }

    .trix-content [data-tlist] ul,
    trix-editor [data-tlist] ul { margin: 0; padding-left: 20px; color: #6b7280; }

    /* ── Modal overlay ── */
    .tlist-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        backdrop-filter: blur(3px);
    }

    .tlist-modal-dialog {
        background: var(--tlist-bg);
        border: 1px solid var(--tlist-border);
        border-radius: 12px;
        box-shadow: 0 25px 60px rgba(0,0,0,.25);
        width: 480px;
        max-width: 95vw;
        overflow: hidden;
        font-family: inherit;
        animation: tlist-modal-in .15s ease;
    }

    @keyframes tlist-modal-in {
        from { opacity: 0; transform: scale(.97) translateY(6px); }
        to   { opacity: 1; transform: none; }
    }

    .tlist-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--tlist-border);
        background: var(--tlist-bg-subtle);
    }

    .tlist-modal-title {
        margin: 0;
        font-size: .9375rem;
        font-weight: 600;
        color: var(--tlist-text);
    }

    .tlist-modal-close {
        background: none;
        border: none;
        font-size: 1.4rem;
        cursor: pointer;
        color: var(--tlist-text-muted);
        line-height: 1;
        padding: 2px 6px;
        border-radius: 4px;
        transition: background .1s, color .1s;
    }

    .tlist-modal-close:hover {
        background: var(--tlist-hover-bg);
        color: var(--tlist-text);
    }

    .tlist-modal-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        background: var(--tlist-bg);
    }

    .tlist-modal-label {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: .8125rem;
        font-weight: 500;
        color: var(--tlist-text-muted);
    }

    .tlist-modal-input {
        width: 100%;
        padding: 8px 12px;
        background: var(--tlist-input-bg);
        border: 1px solid var(--tlist-input-bd);
        border-radius: 6px;
        font-size: .9375rem;
        color: var(--tlist-text);
        outline: none;
        box-sizing: border-box;
        transition: border-color .15s, box-shadow .15s;
    }

    .tlist-modal-input::placeholder { color: var(--tlist-text-muted); }

    .tlist-modal-input:focus {
        border-color: var(--tlist-primary);
        box-shadow: 0 0 0 3px var(--tlist-ring);
    }

    .tlist-items-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .tlist-item-row { display: flex; gap: 6px; align-items: center; }
    .tlist-item-row input { flex: 1; }

    .tlist-remove-item {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: var(--tlist-text-muted);
        padding: 2px 5px;
        border-radius: 4px;
        line-height: 1;
        flex-shrink: 0;
        transition: background .1s, color .1s;
    }

    .tlist-remove-item:hover {
        background: rgba(239,68,68,.1);
        color: var(--tlist-danger);
    }

    .tlist-add-item {
        align-self: flex-start;
        background: none;
        border: 1px dashed var(--tlist-input-bd);
        border-radius: 6px;
        padding: 5px 14px;
        font-size: .8125rem;
        font-weight: 500;
        color: var(--tlist-primary);
        cursor: pointer;
        margin-top: 4px;
        transition: background .1s, border-color .1s;
    }

    .tlist-add-item:hover {
        background: var(--tlist-hover-bg);
        border-color: var(--tlist-primary);
    }

    .tlist-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 14px 20px;
        border-top: 1px solid var(--tlist-border);
        background: var(--tlist-bg-subtle);
    }

    .tlist-btn {
        padding: 8px 18px;
        border-radius: 6px;
        font-size: .875rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: background .15s;
    }

    .tlist-btn-cancel {
        background: var(--tlist-hover-bg);
        color: var(--tlist-text-muted);
        border: 1px solid var(--tlist-border);
    }

    .tlist-btn-cancel:hover { background: var(--tlist-input-bd); }

    .tlist-btn-submit { background: var(--tlist-primary); color: #fff; }
    .tlist-btn-submit:hover { background: var(--tlist-primary-dk); }
`;
document.head.appendChild(styleSheet);
