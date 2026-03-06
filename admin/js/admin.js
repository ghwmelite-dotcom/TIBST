/**
 * TIBST Admin Panel — Client-side interactivity
 */
document.addEventListener('DOMContentLoaded', () => {

    // ─── Sidebar toggle (mobile) ────────────────────────────────────────
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay?.classList.toggle('active');
        });
    }
    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });
    }

    // ─── Image preview on file input ────────────────────────────────────
    document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        input.addEventListener('change', (e) => {
            const preview = document.getElementById(input.dataset.preview);
            if (preview && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    });

    // ─── Delete confirmations ───────────────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', (e) => {
            if (!confirm(el.dataset.confirm || 'Are you sure?')) {
                e.preventDefault();
            }
        });
    });

    // ─── Auto-dismiss alerts after 5s ───────────────────────────────────
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // ─── Dismiss alert on click ─────────────────────────────────────────
    document.querySelectorAll('.alert-dismiss').forEach(btn => {
        btn.addEventListener('click', () => {
            const alert = btn.closest('.alert');
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    });

    // ─── Auto-generate slug from title ──────────────────────────────────
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    if (titleInput && slugInput && !slugInput.value) {
        titleInput.addEventListener('input', () => {
            slugInput.value = titleInput.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '')
                .substring(0, 255);
        });
    }

    // ─── Auto-generate initials from name ───────────────────────────────
    const nameInput = document.getElementById('author-name');
    const initialsInput = document.getElementById('initials');
    if (nameInput && initialsInput && !initialsInput.value) {
        nameInput.addEventListener('input', () => {
            initialsInput.value = nameInput.value
                .split(' ')
                .map(w => w.charAt(0).toUpperCase())
                .join('')
                .substring(0, 5);
        });
    }

    // ─── Initialize TinyMCE if available ────────────────────────────────
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.rich-editor',
            height: 400,
            menubar: false,
            plugins: 'lists link image code table',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
            content_style: "body { font-family: 'Manrope', sans-serif; font-size: 14px; }",
            branding: false,
        });
    }

    // ─── Initialize SortableJS if available ─────────────────────────────
    document.querySelectorAll('[data-sortable]').forEach(container => {
        if (typeof Sortable !== 'undefined') {
            Sortable.create(container, {
                handle: '.sort-handle',
                animation: 150,
                onEnd: function () {
                    const items = container.querySelectorAll('[data-id]');
                    const order = Array.from(items).map((item, index) => ({
                        id: item.dataset.id,
                        sort_order: index
                    }));

                    const table = container.dataset.sortable;
                    fetch('ajax/reorder.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ table, order })
                    });
                }
            });
        }
    });

});
