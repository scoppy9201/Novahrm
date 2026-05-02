document.addEventListener('DOMContentLoaded', function () {
    // INDEX — Check All
    const checkAll = document.getElementById('check-all');
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
        });
        document.querySelectorAll('.row-check').forEach(cb => {
            cb.addEventListener('change', function () {
                const all     = document.querySelectorAll('.row-check');
                const checked = document.querySelectorAll('.row-check:checked');
                checkAll.indeterminate = checked.length > 0 && checked.length < all.length;
                checkAll.checked = checked.length === all.length;
            });
        });
    }

    // INDEX — Search debounce
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 500);
        });
    }

    // INDEX — SPA Navigation
    const spaContent = document.getElementById('spa-content');
    if (spaContent) {

        function spaNavigate(url) {
            spaContent.style.opacity = '0.5';
            spaContent.style.pointerEvents = 'none';
            fetch(url, { headers: { 'X-SPA-Request': '1' } })
                .then(res => res.text())
                .then(html => {
                    spaContent.innerHTML = html;
                    spaContent.style.opacity = '1';
                    spaContent.style.pointerEvents = '';
                    history.pushState({ url }, '', url);
                    updateActiveTab(url);
                    bindContentEvents();
                })
                .catch(() => { window.location.href = url; });
        }

        function updateActiveTab(url) {
            document.querySelectorAll('.emp-tab').forEach(tab => {
                const tabUrl = tab.getAttribute('href');
                tab.classList.toggle('active', url === tabUrl);
            });
        }

        function bindContentEvents() {
            // Checkbox
            const ca = document.getElementById('check-all');
            if (ca) {
                ca.addEventListener('change', function () {
                    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
                });
                document.querySelectorAll('.row-check').forEach(cb => {
                    cb.addEventListener('change', function () {
                        const all     = document.querySelectorAll('.row-check');
                        const checked = document.querySelectorAll('.row-check:checked');
                        ca.indeterminate = checked.length > 0 && checked.length < all.length;
                        ca.checked = checked.length === all.length;
                    });
                });
            }
            // Search
            const si = document.getElementById('search-input');
            if (si) {
                let t;
                si.addEventListener('input', function () {
                    clearTimeout(t);
                    t = setTimeout(() => document.getElementById('filter-form').submit(), 500);
                });
            }
            // Filter form
            const ff = document.getElementById('filter-form');
            if (ff) {
                ff.addEventListener('submit', function (e) {
                    e.preventDefault();
                    spaNavigate(this.action + '?' + new URLSearchParams(new FormData(this)).toString());
                });
            }
            // Pagination
            document.querySelectorAll('.emp-pagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    if (this.getAttribute('href') === '#') return;
                    e.preventDefault();
                    spaNavigate(this.href);
                });
            });
        }

        // Tab clicks (index dùng href, không dùng data-tab)
        document.querySelectorAll('.emp-tab[href]').forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                spaNavigate(this.href);
            });
        });

        window.addEventListener('popstate', e => {
            if (e.state?.url) spaNavigate(e.state.url);
        });

        bindContentEvents();
    }

    // SHOW — Tab switching (dùng data-tab)
    const tabs   = document.querySelectorAll('.emp-tab[data-tab]');
    const panels = document.querySelectorAll('.emp-tab-panel');

    if (tabs.length > 0) {
        function switchTab(tabId) {
            tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === tabId));
            panels.forEach(p => {
                p.style.display = p.id === tabId
                    ? (p.id === 'tab-overview' ? 'grid' : 'block')
                    : 'none';
            });
        }

        tabs.forEach(tab => tab.addEventListener('click', e => {
            e.preventDefault();
            switchTab(tab.dataset.tab);
        }));

        document.querySelectorAll('[data-goto-tab]').forEach(el => {
            el.addEventListener('click', e => {
                e.preventDefault();
                switchTab(el.dataset.gotoTab);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        const hash = location.hash.replace('#', '');
        if (hash && document.getElementById(hash)) switchTab(hash);
        else switchTab('tab-overview');
    }

    // SHOW — Modals
    const terminateModal = document.getElementById('terminate-modal');
    if (terminateModal) {
        document.getElementById('btn-terminate')?.addEventListener('click',    () => terminateModal.classList.add('open'));
        document.getElementById('close-terminate')?.addEventListener('click',  () => terminateModal.classList.remove('open'));
        document.getElementById('cancel-terminate')?.addEventListener('click', () => terminateModal.classList.remove('open'));
    }

    const transferModal = document.getElementById('transfer-modal');
    if (transferModal) {
        document.getElementById('btn-transfer')?.addEventListener('click',    () => transferModal.classList.add('open'));
        document.getElementById('close-transfer')?.addEventListener('click',  () => transferModal.classList.remove('open'));
        document.getElementById('cancel-transfer')?.addEventListener('click', () => transferModal.classList.remove('open'));
    }

    [terminateModal, transferModal].forEach(modal => {
        modal?.addEventListener('click', e => {
            if (e.target === modal) modal.classList.remove('open');
        });
    });

    // SHOW — Autocomplete transfer manager
    const tSearch   = document.getElementById('transfer-manager-search');
    const tIdInput  = document.getElementById('transfer-manager-id');
    const tDropdown = document.getElementById('transfer-manager-dropdown');

    if (tSearch) {
        let tTimer;
        tSearch.addEventListener('input', function () {
            const q = this.value.trim();
            if (q.length < 2) { tDropdown.classList.remove('open'); return; }
            clearTimeout(tTimer);
            tTimer = setTimeout(async () => {
                try {
                    const res  = await fetch(`{{ route('hr.employees.search') }}?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    tDropdown.innerHTML = data.length
                        ? data.map(e => `
                            <div class="emp-autocomplete-item" data-id="${e.id}" data-name="${e.name}">
                                <img src="${e.avatar}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0" onerror="this.style.display='none'"/>
                                <div>
                                    <div class="emp-autocomplete-item-name">${e.name}</div>
                                    <div class="emp-autocomplete-item-sub">${e.position || ''} ${e.department ? '· '+e.department : ''}</div>
                                </div>
                            </div>`).join('')
                        : `<div style="padding:12px;font-size:12px;color:#94a3b8">Không tìm thấy</div>`;
                    tDropdown.classList.add('open');
                    tDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
                        item.addEventListener('click', () => {
                            tSearch.value  = item.dataset.name;
                            tIdInput.value = item.dataset.id;
                            tDropdown.classList.remove('open');
                        });
                    });
                } catch(e) { console.error(e); }
            }, 300);
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('.emp-autocomplete')) tDropdown.classList.remove('open');
        });
    }

    // CHUNG — Flash auto close
    document.querySelectorAll('.emp-alert[data-auto-close]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }, 4000);
    });
});