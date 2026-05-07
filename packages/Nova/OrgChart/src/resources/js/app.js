import '../../../../Core/src/resources/js/nova-ui.js';

// State 
const state = {
    tree:        [],
    view:        'vertical',   // vertical | horizontal | compact
    zoom:        1,
    panX:        0,
    panY:        0,
    collapsed:   new Set(),    // dept id đã collapse
    highlighted: new Set(),    // node id đang highlight (search)
    drawerOpen:  false,
};

// DOM refs 
const canvas       = document.getElementById('orgchart-canvas');
const body         = document.getElementById('orgchart-body');
const loading      = document.getElementById('orgchart-loading');
const zoomLabel    = document.getElementById('zoom-label');
const drawer       = document.getElementById('orgchart-drawer');
const drawerOverlay= document.getElementById('drawer-overlay');
const drawerTitle  = document.getElementById('drawer-title');
const drawerBody   = document.getElementById('drawer-body');
const drawerFooter = document.getElementById('drawer-footer');
const searchInput  = document.getElementById('orgchart-search-input');
const filterDept   = document.getElementById('orgchart-filter-dept');
const cfg          = window.__orgChartConfig;

// Fetch tree 
async function fetchTree() {
    loading.style.display = 'flex';
    try {
        const res  = await fetch(cfg.treeUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await res.json();
        state.tree = data.tree || [];
        populateDeptFilter(state.tree);
        renderTree();
        fitScreen();
    } catch (e) {
        console.error('Lỗi tải sơ đồ:', e);
    } finally {
        loading.style.display = 'none';
    }
}

// Populate dept filter 
function populateDeptFilter(nodes) {
    const flat = flattenDepts(nodes);
    flat.forEach(d => {
        const opt = document.createElement('option');
        opt.value = d.id;
        opt.textContent = d.name;
        filterDept.appendChild(opt);
    });
}

function flattenDepts(nodes, arr = []) {
    nodes.forEach(n => {
        arr.push(n);
        if (n.children?.length) flattenDepts(n.children, arr);
    });
    return arr;
}

// Render 
function renderTree() {
    canvas.innerHTML = '';

    if (!state.tree.length) {
        showEmpty();
        return;
    }

    // Bọc canvas content trong wrapper để tính toán offset
    const wrap = document.createElement('div');
    wrap.style.cssText = 'position:relative; display:inline-block;';
    canvas.appendChild(wrap);

    if (state.view === 'vertical') {
        renderVertical(state.tree, wrap, 0);
    } else if (state.view === 'horizontal') {
        renderHorizontal(state.tree, wrap, 0);
    } else {
        renderCompact(state.tree, wrap);
    }

    // Vẽ connector sau khi DOM đã render xong
    requestAnimationFrame(() => {
        requestAnimationFrame(() => drawConnectors(wrap));
    });
}

// Vertical layout 
function renderVertical(nodes, container, depth) {
    const row = document.createElement('div');
    row.dataset.depth = depth;
    row.style.cssText = 'display:flex; gap:32px; justify-content:center; align-items:flex-start; position:relative;';

    nodes.forEach((node) => {
        const wrapper = document.createElement('div');
        wrapper.dataset.nodeId = node.id;
        wrapper.style.cssText = 'display:flex; flex-direction:column; align-items:center; position:relative;';

        const card = createDeptCard(node);
        wrapper.appendChild(card);

        if (!state.collapsed.has(node.id) && node.children?.length) {
            const childRow = document.createElement('div');
            childRow.style.cssText = 'margin-top:48px;'; // khoảng trống cho connector
            renderVertical(node.children, childRow, depth + 1);
            wrapper.appendChild(childRow);
        }

        if (!state.collapsed.has(node.id) && node.employees?.length) {
            const empRow = createEmpRow(node.employees, depth);
            empRow.style.marginTop = '48px';
            wrapper.appendChild(empRow);
        }

        row.appendChild(wrapper);
    });

    container.appendChild(row);
}

function addSiblingConnector(row, count) {
    // Vẽ đường ngang nối các anh em
    const connector = document.createElement('div');
    connector.style.cssText = `
        position:absolute; top:32px; left:50%; transform:translateX(-50%);
        height:1.5px; background:#cbd5e1;
        width:calc(100% - 220px);
        pointer-events:none;
    `;
    row.style.position = 'relative';
    row.appendChild(connector);
}

// Horizontal layout 
function renderHorizontal(nodes, container, depth) {
    const col = document.createElement('div');
    col.style.cssText = 'display:flex; flex-direction:column; gap:24px; align-items:flex-start;';

    nodes.forEach(node => {
        const row = document.createElement('div');
        row.dataset.nodeId = node.id;
        row.style.cssText = 'display:flex; align-items:center; gap:0;';

        const card = createDeptCard(node);
        row.appendChild(card);

        if (!state.collapsed.has(node.id) && node.children?.length) {
            const childCol = document.createElement('div');
            childCol.style.cssText = 'margin-left:56px;'; // khoảng trống cho connector
            renderHorizontal(node.children, childCol, depth + 1);
            row.appendChild(childCol);
        }

        col.appendChild(row);
    });

    container.appendChild(col);
}

function drawConnectors(wrap) {
    // Xóa SVG cũ nếu có
    wrap.querySelectorAll('.orgchart-connector-svg').forEach(s => s.remove());

    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.classList.add('orgchart-connector-svg');
    svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    wrap.insertBefore(svg, wrap.firstChild);

    const wrapRect = wrap.getBoundingClientRect();

    if (state.view === 'vertical') {
        drawVerticalConnectors(svg, state.tree, wrapRect);
    } else if (state.view === 'horizontal') {
        drawHorizontalConnectors(svg, state.tree, wrapRect);
    }
    // compact: không có connector
}

function getCardRect(nodeId, wrapRect) {
    // Tìm .orgchart-dept-card của node theo data-id
    const el = document.querySelector(`.orgchart-dept-node[data-id="${nodeId}"] .orgchart-dept-card`);
    if (!el) return null;
    const r = el.getBoundingClientRect();
    return {
        top:    r.top    - wrapRect.top,
        left:   r.left   - wrapRect.left,
        bottom: r.bottom - wrapRect.top,
        right:  r.right  - wrapRect.left,
        cx:     r.left   - wrapRect.left + r.width / 2,
        cy:     r.top    - wrapRect.top  + r.height / 2,
        width:  r.width,
        height: r.height,
    };
}

function drawLine(svg, x1, y1, x2, y2) {
    // Base line (đường chính — xám nhạt, dày)
    const base = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    const d = buildPath(x1, y1, x2, y2, 'vertical');
    base.setAttribute('d', d);
    base.setAttribute('class', 'oc-edge');
    svg.appendChild(base);

    // Flow animation line (xanh, chạy)
    const flow = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    flow.setAttribute('d', d);
    flow.setAttribute('class', 'oc-edge-flow');
    svg.appendChild(flow);
}

function drawLineH(svg, x1, y1, x2, y2) {
    const base = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    const d = buildPath(x1, y1, x2, y2, 'horizontal');
    base.setAttribute('d', d);
    base.setAttribute('class', 'oc-edge');
    svg.appendChild(base);

    const flow = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    flow.setAttribute('d', d);
    flow.setAttribute('class', 'oc-edge-flow');
    svg.appendChild(flow);
}

// Tạo path đẹp: đường thẳng với corner radius 12px
function buildPath(x1, y1, x2, y2, direction) {
    const r = 12; // corner radius

    if (direction === 'vertical') {
        // Từ bottom của parent → top của child, L-shape với bo góc
        const mx = x1;
        const my = (y1 + y2) / 2;

        if (Math.abs(x2 - x1) < 2) {
            // Thẳng đứng
            return `M ${x1} ${y1} L ${x2} ${y2}`;
        }

        const dx = x2 > x1 ? r : -r;
        return `M ${x1} ${y1}
                L ${mx} ${my - r}
                Q ${mx} ${my} ${mx + dx} ${my}
                L ${x2 - dx} ${my}
                Q ${x2} ${my} ${x2} ${my + r}
                L ${x2} ${y2}`;
    } else {
        // horizontal
        const midX = (x1 + x2) / 2;

        if (Math.abs(y2 - y1) < 2) {
            return `M ${x1} ${y1} L ${x2} ${y2}`;
        }

        const dy = y2 > y1 ? r : -r;
        return `M ${x1} ${y1}
                L ${midX - r} ${y1}
                Q ${midX} ${y1} ${midX} ${y1 + dy}
                L ${midX} ${y2 - dy}
                Q ${midX} ${y2} ${midX + r} ${y2}
                L ${x2} ${y2}`;
    }
}

function drawVerticalConnectors(svg, nodes, wrapRect) {
    nodes.forEach(node => {
        const parentRect = getCardRect(node.id, wrapRect);
        if (!parentRect) return;

        const children = state.collapsed.has(node.id) ? [] : (node.children || []);

        children.forEach(child => {
            const childRect = getCardRect(child.id, wrapRect);
            if (!childRect) return;

            drawLineH(svg,
                parentRect.right, parentRect.cy,
                childRect.left,   childRect.cy
            );

            // Đệ quy
            drawVerticalConnectors(svg, [child], wrapRect);
        });

        // Connector tới employee cards nếu có
        if (!state.collapsed.has(node.id) && node.employees?.length) {
            // Lấy toàn bộ emp card trong wrapper của node này
            const nodeWrapper = document.querySelector(`.orgchart-dept-node[data-id="${node.id}"]`)?.closest('[data-node-id]');
            if (nodeWrapper) {
                const empCardEls = nodeWrapper.querySelectorAll('.orgchart-emp-card');
                empCardEls.forEach(empEl => {
                    const er = empEl.getBoundingClientRect();
                    const empR = {
                        top:  er.top  - wrapRect.top,
                        cx:   er.left - wrapRect.left + er.width / 2,
                    };
                    drawLine(svg,
                        parentRect.cx, parentRect.bottom,
                        empR.cx, empR.top
                    );
                });
            }
        }
    });
}

function drawHorizontalConnectors(svg, nodes, wrapRect) {
    nodes.forEach(node => {
        const parentRect = getCardRect(node.id, wrapRect);
        if (!parentRect) return;

        const children = state.collapsed.has(node.id) ? [] : (node.children || []);

        children.forEach(child => {
            const childRect = getCardRect(child.id, wrapRect);
            if (!childRect) return;

            drawLineH(svg,                   
                parentRect.right, parentRect.cy,
                childRect.left,   childRect.cy
            );

            drawHorizontalConnectors(svg, [child], wrapRect); 
        });
    });
}

// Compact layout 
function renderCompact(nodes, container) {
    const grid = document.createElement('div');
    grid.style.cssText = 'display:flex; flex-wrap:wrap; gap:16px; padding:20px;';

    const flat = flattenDepts(nodes);
    flat.forEach(node => {
        const card = createDeptCard(node);
        card.querySelector('.orgchart-dept-card').style.width = '200px';
        grid.appendChild(card);
    });

    container.appendChild(grid);
}

// Create dept card 
function createDeptCard(node) {
    const isCollapsed   = state.collapsed.has(node.id);
    const isHighlighted = state.highlighted.has(`dept-${node.id}`);
    const color         = node.color || '#1d4ed8';
    const hasChildren   = node.children?.length > 0;

    const wrap = document.createElement('div');
    wrap.className = 'orgchart-dept-node';
    wrap.dataset.id = node.id;

    wrap.innerHTML = `
        <div class="orgchart-dept-card ${isHighlighted ? 'highlighted' : ''}">
            <div class="orgchart-dept-accent" style="background:${color}"></div>
            <div class="orgchart-dept-body">
                <div class="orgchart-dept-name">${escHtml(node.name)}</div>
                ${node.code ? `<div class="orgchart-dept-code">${escHtml(node.code)}</div>` : ''}
                ${node.manager ? `
                    <div class="orgchart-dept-manager">
                        <img class="orgchart-dept-manager-av" src="${escHtml(node.manager.avatar)}" alt="${escHtml(node.manager.name)}"/>
                        <div class="orgchart-dept-manager-info">
                            <div class="orgchart-dept-manager-name">${escHtml(node.manager.name)}</div>
                            <div class="orgchart-dept-manager-title">${escHtml(node.manager.job_title || '—')}</div>
                        </div>
                    </div>
                ` : ''}
                <div class="orgchart-dept-footer">
                    <div class="orgchart-dept-count">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        ${node.employee_count} nhân viên
                    </div>
                    ${hasChildren ? `
                        <button class="orgchart-dept-collapse ${isCollapsed ? 'collapsed' : ''}" data-id="${node.id}" title="${isCollapsed ? 'Mở rộng' : 'Thu gọn'}">
                            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                    ` : ''}
                </div>
            </div>
        </div>
    `;

    // Click card → mở drawer dept
    wrap.querySelector('.orgchart-dept-card').addEventListener('click', (e) => {
        if (e.target.closest('.orgchart-dept-collapse')) return;
        openDeptDrawer(node);
    });

    // Click collapse
    const collapseBtn = wrap.querySelector('.orgchart-dept-collapse');
    if (collapseBtn) {
        collapseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleCollapse(node.id);
        });
    }

    // Gắn drag & drop
    requestAnimationFrame(() => window.__deptCardCreated?.(wrap, node));

    return wrap;
}

// Create employee row 
function createEmpRow(employees, depth) {
    const wrap = document.createElement('div');
    wrap.style.cssText = 'display:flex; gap:12px; margin-top:16px; flex-wrap:wrap; justify-content:center;';

    // Connector line
    const line = document.createElement('div');
    line.style.cssText = 'width:1.5px; height:16px; background:#cbd5e1; margin:0 auto;';
    wrap.appendChild(line);

    const row = document.createElement('div');
    row.style.cssText = 'display:flex; gap:12px; flex-wrap:wrap; justify-content:center;';

    employees.forEach(emp => {
        const card = createEmpCard(emp);
        row.appendChild(card);
    });

    wrap.appendChild(row);
    return wrap;
}

// Create employee card 
function createEmpCard(emp) {
    const isHighlighted = state.highlighted.has(`emp-${emp.id}`);

    const wrap = document.createElement('div');
    wrap.className = 'orgchart-emp-node';

    wrap.innerHTML = `
        <div class="orgchart-emp-card ${isHighlighted ? 'highlighted' : ''}">
            <div style="position:relative; display:inline-block;">
                <img class="orgchart-emp-av" src="${escHtml(emp.avatar)}" alt="${escHtml(emp.name)}"/>
                <span class="orgchart-emp-status ${emp.is_active ? 'status-active' : 'status-inactive'}"></span>
            </div>
            <div class="orgchart-emp-name">${escHtml(emp.name)}</div>
            <div class="orgchart-emp-title">${escHtml(emp.job_title || '—')}</div>
            ${emp.is_manager ? `<span class="orgchart-badge orgchart-badge-blue" style="margin-top:2px;">Trưởng phòng</span>` : ''}
        </div>
    `;

    wrap.querySelector('.orgchart-emp-card').addEventListener('click', () => {
        openEmpDrawer(emp);
    });

    return wrap;
}

// Collapse toggle 
function toggleCollapse(id) {
    if (state.collapsed.has(id)) {
        state.collapsed.delete(id);
    } else {
        state.collapsed.add(id);
    }
    renderTree();
}

// Search & highlight 
function doSearch(keyword) {
    state.highlighted.clear();

    if (!keyword.trim()) {
        renderTree();
        return;
    }

    const kw = keyword.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

    function searchNodes(nodes) {
        nodes.forEach(node => {
            const dName = node.name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            if (dName.includes(kw)) state.highlighted.add(`dept-${node.id}`);

            node.employees?.forEach(emp => {
                const eName = emp.name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                const eTitle = (emp.job_title || '').toLowerCase();
                if (eName.includes(kw) || eTitle.includes(kw)) {
                    state.highlighted.add(`emp-${emp.id}`);
                    // Auto expand dept chứa nhân viên này
                    state.collapsed.delete(node.id);
                }
            });

            if (node.children?.length) searchNodes(node.children);
        });
    }

    searchNodes(state.tree);
    renderTree();
}

// Drawer: Department 
function openDeptDrawer(node) {
    drawerTitle.textContent = node.name;

    drawerBody.innerHTML = `
        <div class="orgchart-drawer-profile" style="align-items:flex-start; text-align:left;">
            <div style="display:flex; align-items:center; gap:12px; width:100%;">
                <div style="width:44px; height:44px; border-radius:12px; background:${node.color || '#1d4ed8'}22; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="${node.color || '#1d4ed8'}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <div class="orgchart-drawer-name">${escHtml(node.name)}</div>
                    ${node.code ? `<div class="orgchart-drawer-job">${escHtml(node.code)}</div>` : ''}
                </div>
            </div>
        </div>

        <div>
            <div class="orgchart-drawer-section-title">Thông tin</div>
            <div class="orgchart-drawer-row">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <span class="orgchart-drawer-row-label">Nhân viên</span>
                <span class="orgchart-drawer-row-val">${node.employee_count} người</span>
            </div>
            ${node.manager ? `
                <div class="orgchart-drawer-row">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                    <span class="orgchart-drawer-row-label">Trưởng phòng</span>
                    <span class="orgchart-drawer-row-val">${escHtml(node.manager.name)}</span>
                </div>
                <div class="orgchart-drawer-row">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <span class="orgchart-drawer-row-label">Chức danh</span>
                    <span class="orgchart-drawer-row-val">${escHtml(node.manager.job_title || '—')}</span>
                </div>
            ` : ''}
            ${node.children?.length ? `
                <div class="orgchart-drawer-row">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="2" x2="12" y2="22"/><path d="M17 7l-5-5-5 5"/></svg>
                    <span class="orgchart-drawer-row-label">Phòng ban con</span>
                    <span class="orgchart-drawer-row-val">${node.children.length} phòng</span>
                </div>
            ` : ''}
        </div>

        ${node.employees?.length ? `
            <div>
                <div class="orgchart-drawer-section-title">Nhân viên (${node.employees.length})</div>
                ${node.employees.map(emp => `
                    <div class="orgchart-drawer-row" style="cursor:pointer;" onclick="openEmpDrawerById(${emp.id})">
                        <img class="orgchart-chain-av" src="${escHtml(emp.avatar)}" alt="${escHtml(emp.name)}"/>
                        <div>
                            <div class="orgchart-chain-name">${escHtml(emp.name)}</div>
                            <div class="orgchart-chain-title">${escHtml(emp.job_title || '—')}</div>
                        </div>
                        ${emp.is_manager ? `<span class="orgchart-badge orgchart-badge-blue" style="margin-left:auto;">Trưởng phòng</span>` : ''}
                    </div>
                `).join('')}
            </div>
        ` : ''}
    `;

    drawerFooter.innerHTML = `
        <button class="btn-orgchart-danger" style="flex:1; justify-content:center;" id="btn-delete-dept">
            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
            Xóa
        </button>
        <button class="btn-orgchart-primary" style="flex:1; justify-content:center;" id="btn-edit-dept">
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Chỉnh sửa
        </button>
    `;

    document.getElementById('btn-edit-dept').addEventListener('click', () => {
        openEditModal(node);
    });

    document.getElementById('btn-delete-dept').addEventListener('click', () => {
        deleteDept(node);
    });

    openDrawer();
}

// Drawer: Employee 
async function openEmpDrawer(emp) {
    drawerTitle.textContent = emp.name;

    drawerBody.innerHTML = `
        <div class="orgchart-drawer-profile">
            <img class="orgchart-drawer-av" src="${escHtml(emp.avatar)}" alt="${escHtml(emp.name)}"/>
            <div class="orgchart-drawer-name">${escHtml(emp.name)}</div>
            <div class="orgchart-drawer-job">${escHtml(emp.job_title || '—')}</div>
            <span class="orgchart-badge ${emp.is_active ? 'orgchart-badge-green' : 'orgchart-badge-gray'}">
                ${emp.is_active ? 'Đang làm việc' : 'Không hoạt động'}
            </span>
        </div>
        <div id="drawer-chain-wrap">
            <div class="orgchart-drawer-section-title">Chuỗi báo cáo</div>
            <div style="font-size:12px; color:#94a3b8;">Đang tải...</div>
        </div>
    `;

    drawerFooter.innerHTML = `
        <button class="btn-orgchart-secondary" style="flex:1;" onclick="closeDrawer()">Đóng</button>
        <button class="btn-orgchart-primary" style="flex:1;">
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Xem hồ sơ
        </button>
    `;

    openDrawer();

    // Load chain
    try {
        const url = cfg.chainUrl.replace('__ID__', emp.id);
        const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await res.json();

        const chainWrap = document.getElementById('drawer-chain-wrap');
        if (chainWrap) {
            chainWrap.innerHTML = `
                <div class="orgchart-drawer-section-title">Chuỗi báo cáo</div>
                <div class="orgchart-chain">
                    ${(data.chain || []).map(c => `
                        <div class="orgchart-chain-item">
                            <img class="orgchart-chain-av" src="${escHtml(c.avatar)}" alt="${escHtml(c.name)}"/>
                            <div>
                                <div class="orgchart-chain-name">${escHtml(c.name)}</div>
                                <div class="orgchart-chain-title">${escHtml(c.job_title || '—')} ${c.department ? '· ' + escHtml(c.department) : ''}</div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }
    } catch (e) {
        console.error('Lỗi tải chain:', e);
    }
}

// Expose để dùng trong onclick inline
window.openEmpDrawerById = function(id) {
    const flat = flattenDepts(state.tree);
    for (const dept of flat) {
        const emp = dept.employees?.find(e => e.id === id);
        if (emp) { openEmpDrawer(emp); return; }
    }
};

// Drawer open/close 
function openDrawer() {
    drawer.classList.add('open');
    drawerOverlay.classList.add('open');
    state.drawerOpen = true;
}

function closeDrawer() {
    drawer.classList.remove('open');
    drawerOverlay.classList.remove('open');
    state.drawerOpen = false;
}

window.closeDrawer = closeDrawer;

// Zoom & Pan 
function applyTransform() {
    canvas.style.transform = `translate(${state.panX}px, ${state.panY}px) scale(${state.zoom})`;
    zoomLabel.textContent   = Math.round(state.zoom * 100) + '%';
}

function setZoom(z) {
    state.zoom = Math.min(2, Math.max(0.2, z));
    applyTransform();
}

function fitScreen() {
    const bRect = body.getBoundingClientRect();
    const cRect = canvas.getBoundingClientRect();

    const scaleX = bRect.width  / (canvas.scrollWidth  + 120);
    const scaleY = bRect.height / (canvas.scrollHeight + 120);
    const scale  = Math.min(scaleX, scaleY, 1);

    state.zoom = scale;
    state.panX = (bRect.width  - canvas.scrollWidth  * scale) / 2;
    state.panY = (bRect.height - canvas.scrollHeight * scale) / 2;
    applyTransform();
}

// Pan (drag)
let isPanning = false, startX = 0, startY = 0, startPanX = 0, startPanY = 0;

body.addEventListener('mousedown', (e) => {
    if (e.target.closest('.orgchart-dept-card') || e.target.closest('.orgchart-emp-card')) return;
    isPanning = true;
    startX    = e.clientX;
    startY    = e.clientY;
    startPanX = state.panX;
    startPanY = state.panY;
    canvas.classList.add('grabbing');
});

window.addEventListener('mousemove', (e) => {
    if (!isPanning) return;
    state.panX = startPanX + (e.clientX - startX);
    state.panY = startPanY + (e.clientY - startY);
    applyTransform();
});

window.addEventListener('mouseup', () => {
    isPanning = false;
    canvas.classList.remove('grabbing');
});

// Scroll to zoom
body.addEventListener('wheel', (e) => {
    e.preventDefault();
    const delta = e.deltaY > 0 ? -0.08 : 0.08;
    setZoom(state.zoom + delta);
}, { passive: false });

// Empty state 
function showEmpty() {
    canvas.innerHTML = `
        <div class="orgchart-empty">
            <div class="orgchart-empty-icon">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="orgchart-empty-text">Chưa có dữ liệu sơ đồ</div>
            <div class="orgchart-empty-sub">Hãy thêm phòng ban để bắt đầu</div>
        </div>
    `;
}

// Escape HTML 
function escHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// Event listeners 
document.getElementById('drawer-close').addEventListener('click', closeDrawer);
drawerOverlay.addEventListener('click', closeDrawer);

document.getElementById('btn-zoom-in').addEventListener('click',  () => setZoom(state.zoom + 0.1));
document.getElementById('btn-zoom-out').addEventListener('click', () => setZoom(state.zoom - 0.1));
document.getElementById('btn-fit-screen').addEventListener('click', fitScreen);

document.getElementById('btn-collapse-all').addEventListener('click', () => {
    const flat = flattenDepts(state.tree);
    flat.forEach(d => state.collapsed.add(d.id));
    renderTree();
});

document.querySelectorAll('.orgchart-view-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.orgchart-view-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        state.view = btn.dataset.view;
        renderTree();
        fitScreen();
    });
});

searchInput.addEventListener('input', (e) => doSearch(e.target.value));

filterDept.addEventListener('change', (e) => {
    const id = parseInt(e.target.value);
    if (!id) {
        state.collapsed.clear();
        renderTree();
        return;
    }
    // Collapse tất cả trừ dept được chọn
    const flat = flattenDepts(state.tree);
    flat.forEach(d => {
        if (d.id !== id) state.collapsed.add(d.id);
        else state.collapsed.delete(d.id);
    });
    renderTree();
});

document.getElementById('btn-fullscreen').addEventListener('click', () => {
    if (!document.fullscreenElement) {
        body.requestFullscreen?.();
    } else {
        document.exitFullscreen?.();
    }
});

// Tab switch
// Tab switch
const sectionSoDo     = document.getElementById('section-so-do');
const sectionDanhSach = document.getElementById('section-danh-sach');
const orgchartToolbar = document.getElementById('orgchart-toolbar');
const listToolbar     = document.getElementById('list-toolbar');

document.querySelectorAll('.orgchart-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.orgchart-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        if (tab.dataset.tab === 'so-do') {
            sectionSoDo.style.display     = 'flex';
            sectionDanhSach.style.display = 'none';
            orgchartToolbar.style.display = '';
            listToolbar.style.display     = 'none';
        } else {
            sectionSoDo.style.display     = 'none';
            sectionDanhSach.style.display = 'flex';
            orgchartToolbar.style.display = 'none';
            listToolbar.style.display     = '';
            renderList();
        }
    });
});

// ── Render danh sách ──
function renderList(keyword = '', levelFilter = '') {
    const tbody = document.getElementById('orgchart-table-body');
    const empty = document.getElementById('list-empty');
    const count = document.getElementById('list-count');

    // Gán depth
    function assignDepth(nodes, depth = 0) {
        nodes.forEach(n => {
            n._depth = depth;
            if (n.children?.length) assignDepth(n.children, depth + 1);
        });
    }
    assignDepth(state.tree);

    let flat = flattenDepts(state.tree);

    // Filter level
    if (levelFilter !== '') {
        const lv = parseInt(levelFilter);
        flat = flat.filter(d => lv >= 2 ? d._depth >= 2 : d._depth === lv);
    }

    // Filter keyword
    if (keyword.trim()) {
        const kw = keyword.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        flat = flat.filter(d => {
            const name = d.name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            const code = (d.code || '').toLowerCase();
            return name.includes(kw) || code.includes(kw);
        });
    }

    count.textContent = flat.length + ' phòng ban';

    if (!flat.length) {
        tbody.innerHTML    = '';
        empty.style.display = '';
        return;
    }

    empty.style.display = 'none';

    const levelLabel = ['Cấp 1', 'Cấp 2', 'Cấp 3'];
    const levelBadge = ['orgchart-badge-blue', 'orgchart-badge-green', 'orgchart-badge-gray'];

    tbody.innerHTML = flat.map(dept => {
        const depth     = dept._depth || 0;
        const badgeClass = levelBadge[Math.min(depth, 2)];
        const label      = levelLabel[Math.min(depth, 2)];
        const indent     = depth * 20;

        return `
        <tr class="orgchart-table-row" onclick="handleListRowClick(${dept.id})" style="cursor:pointer;">
            <td>
                <div style="display:flex; align-items:center; gap:8px; padding-left:${indent}px;">
                    ${depth > 0 ? `<span style="color:#cbd5e1; font-size:11px;">└</span>` : ''}
                    <div style="width:8px; height:8px; border-radius:50%; background:${dept.color || '#1d4ed8'}; flex-shrink:0;"></div>
                    <span style="font-weight:700; color:#0f172a; font-size:12.5px;">${escHtml(dept.name)}</span>
                    ${dept.code ? `<span style="font-size:10px; color:#3b82f6; font-weight:700; font-family:monospace; background:#eff6ff; padding:1px 6px; border-radius:4px;">${escHtml(dept.code)}</span>` : ''}
                </div>
            </td>
            <td>
                ${dept.manager
                    ? `<div style="display:flex; align-items:center; gap:8px;">
                        <img src="${escHtml(dept.manager.avatar)}" style="width:26px;height:26px;border-radius:50%;object-fit:cover;border:1.5px solid #e2e8f0;" onerror="this.style.display='none'"/>
                        <div>
                            <div style="font-size:12px;font-weight:600;color:#0f172a;">${escHtml(dept.manager.name)}</div>
                            <div style="font-size:10px;color:#94a3b8;">${escHtml(dept.manager.job_title || '')}</div>
                        </div>
                       </div>`
                    : '<span style="color:#cbd5e1;font-size:12px;">—</span>'
                }
            </td>
            <td>
                <span style="font-size:13px;font-weight:700;color:#0f172a;">${dept.employee_count}</span>
                <span style="font-size:11px;color:#94a3b8;"> người</span>
            </td>
            <td>
                ${dept.children?.length
                    ? `<span style="font-size:12px;font-weight:600;color:#334155;">${dept.children.length} phòng</span>`
                    : '<span style="color:#cbd5e1;font-size:12px;">—</span>'
                }
            </td>
            <td style="text-align:left; padding-left:14px;">
                <span class="orgchart-badge ${badgeClass}">${label}</span>
            </td>
            <td>
                <button class="btn-orgchart-icon" style="width:28px;height:28px;" title="Xem chi tiết">
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </td>
        </tr>`;
    }).join('');
}

window.handleListRowClick = function(deptId) {
    const flat = flattenDepts(state.tree);
    const dept = flat.find(d => d.id === deptId);
    if (dept) openDeptDrawer(dept);
};

// List search
document.getElementById('list-search-input').addEventListener('input', (e) => {
    const level = document.getElementById('list-filter-level').value;
    renderList(e.target.value, level);
});

// List filter level
document.getElementById('list-filter-level').addEventListener('change', (e) => {
    const kw = document.getElementById('list-search-input').value;
    renderList(kw, e.target.value);
});

// Init 
fetchTree();

// Modal thêm phòng ban 
const modalOverlay = document.getElementById('modal-overlay');
const modalClose   = document.getElementById('modal-close');
const modalCancel  = document.getElementById('modal-cancel');
const modalSubmit  = document.getElementById('modal-submit');
const colorInput   = document.getElementById('f-color');
const colorLabel   = document.getElementById('f-color-label');

function openModal() {
    // Populate parent dropdown từ state.tree
    const parentSelect = document.getElementById('f-parent');
    parentSelect.innerHTML = '<option value="">— Không có (cấp cao nhất) —</option>';
    flattenDepts(state.tree).forEach(d => {
        const opt = document.createElement('option');
        opt.value = d.id;
        opt.textContent = '　'.repeat(d._depth || 0) + d.name;
        parentSelect.appendChild(opt);
    });

    // Reset form
    ['f-name','f-code','f-description'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('f-color').value = '#1d4ed8';
    colorLabel.textContent = '#1d4ed8';
    ['err-name','err-code'].forEach(id => document.getElementById(id).textContent = '');

    modalOverlay.style.display = 'flex';
}

function closeModal() {
    modalOverlay.style.display = 'none';
}

document.getElementById('btn-add-dept').addEventListener('click', openModal);
modalClose.addEventListener('click', closeModal);
modalCancel.addEventListener('click', closeModal);
modalOverlay.addEventListener('click', (e) => {
    if (e.target === modalOverlay) closeModal();
});

colorInput.addEventListener('input', (e) => {
    colorLabel.textContent = e.target.value;
});

modalSubmit.addEventListener('click', async () => {
    // Clear errors
    ['err-name','err-code'].forEach(id => document.getElementById(id).textContent = '');

    const name = document.getElementById('f-name').value.trim();
    if (!name) {
        document.getElementById('err-name').textContent = 'Vui lòng nhập tên phòng ban';
        document.getElementById('f-name').focus();
        return;
    }

    const parentVal = document.getElementById('f-parent').value;
    const payload = {
        name:        name,
        code:        document.getElementById('f-code').value.trim() || null,
        description: document.getElementById('f-description').value.trim() || null,
        parent_id:   parentVal ? parseInt(parentVal) : null,
        color:       document.getElementById('f-color').value,
    };

    // Loading state
    modalSubmit.disabled = true;
    document.getElementById('modal-submit-text').textContent = 'Đang tạo...';

    try {
        const res  = await fetch(cfg.storeUrl, {
            method:  'POST',
            headers: {
                'Content-Type':     'application/json',
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     cfg.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (!res.ok) {
            // Hiển thị lỗi validation
            if (data.errors) {
                if (data.errors.name)  document.getElementById('err-name').textContent = data.errors.name[0];
                if (data.errors.code)  document.getElementById('err-code').textContent = data.errors.code[0];
            }
            return;
        }

        closeModal();
        // Reload tree để hiện dept mới
        await fetchTree();

    } catch (e) {
        console.error('Lỗi tạo phòng ban:', e);
    } finally {
        modalSubmit.disabled = false;
        document.getElementById('modal-submit-text').textContent = 'Tạo phòng ban';
    }
});

// Modal edit phòng ban 
const modalEditOverlay = document.getElementById('modal-edit-overlay');

function openEditModal(node) {
    // Pre-fill data
    document.getElementById('ef-id').value          = node.id;
    document.getElementById('ef-name').value        = node.name || '';
    document.getElementById('ef-code').value        = node.code || '';
    document.getElementById('ef-description').value = node.description || '';
    document.getElementById('ef-color').value       = node.color || '#1d4ed8';
    document.getElementById('ef-color-label').textContent = node.color || '#1d4ed8';

    // Populate parent dropdown — loại trừ chính nó và con cháu nó
    const parentSelect = document.getElementById('ef-parent');
    parentSelect.innerHTML = '<option value="">— Không có (cấp cao nhất) —</option>';

    function getDescendantIds(n) {
        const ids = [n.id];
        n.children?.forEach(c => ids.push(...getDescendantIds(c)));
        return ids;
    }
    const excludeIds = getDescendantIds(node);

    flattenDepts(state.tree).forEach(d => {
        if (excludeIds.includes(d.id)) return;
        const opt = document.createElement('option');
        opt.value = d.id;
        opt.textContent = '　'.repeat(d._depth || 0) + d.name;
        if (d.id == node.parent_id) opt.selected = true; 
        parentSelect.appendChild(opt);
    });

    // Clear errors
    ['ef-err-name', 'ef-err-code'].forEach(id => document.getElementById(id).textContent = '');

    modalEditOverlay.style.display = 'flex';
}

function closeEditModal() {
    modalEditOverlay.style.display = 'none';
}

document.getElementById('modal-edit-close').addEventListener('click', closeEditModal);
document.getElementById('modal-edit-cancel').addEventListener('click', closeEditModal);
modalEditOverlay.addEventListener('click', (e) => {
    if (e.target === modalEditOverlay) closeEditModal();
});

document.getElementById('ef-color').addEventListener('input', (e) => {
    document.getElementById('ef-color-label').textContent = e.target.value;
});

document.getElementById('modal-edit-submit').addEventListener('click', async () => {
    ['ef-err-name', 'ef-err-code'].forEach(id => document.getElementById(id).textContent = '');

    const id   = document.getElementById('ef-id').value;
    const name = document.getElementById('ef-name').value.trim();

    if (!name) {
        document.getElementById('ef-err-name').textContent = 'Vui lòng nhập tên phòng ban';
        document.getElementById('ef-name').focus();
        return;
    }

    const parentVal = document.getElementById('ef-parent').value;
    const payload = {
        name:        name,
        code:        document.getElementById('ef-code').value.trim() || null,
        description: document.getElementById('ef-description').value.trim() || null,
        parent_id:   parentVal ? parseInt(parentVal) : null,
        color:       document.getElementById('ef-color').value,
    };

    const submitBtn  = document.getElementById('modal-edit-submit');
    const submitText = document.getElementById('modal-edit-submit-text');
    submitBtn.disabled  = true;
    submitText.textContent = 'Đang lưu...';

    try {
        const url = cfg.updateUrl.replace('__ID__', id);
        const res = await fetch(url, {
            method:  'PUT',
            headers: {
                'Content-Type':     'application/json',
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     cfg.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (!res.ok) {
            if (data.errors) {
                if (data.errors.name) document.getElementById('ef-err-name').textContent = data.errors.name[0];
                if (data.errors.code) document.getElementById('ef-err-code').textContent = data.errors.code[0];
            }
            return;
        }

        closeEditModal();
        closeDrawer();
        await fetchTree();

    } catch (e) {
        console.error('Lỗi cập nhật:', e);
    } finally {
        submitBtn.disabled     = false;
        submitText.textContent = 'Lưu thay đổi';
    }
});

// Expose để drawer gọi được
window.openEditModal = openEditModal;

// Delete department
async function deleteDept(node) {
    const confirmed = await novaConfirm({
        title: 'Xác nhận xóa phòng ban',
        message: `Bạn có chắc muốn xóa phòng ban "${node.name}" không?<br>Hành động này không thể hoàn tác.`,
        confirmText: 'Xóa phòng ban',
        cancelText: 'Huỷ',
        type: 'danger',
    });
    if (!confirmed) return;

    const url = cfg.deleteUrl.replace('__ID__', node.id);

    try {
        const res  = await fetch(url, {
            method:  'DELETE',
            headers: {
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     cfg.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        const data = await res.json();

        if (!res.ok) {
            novaToast(data.message || 'Xóa thất bại. Vui lòng thử lại.', 'error');
            return;
        }

        closeDrawer();
        await fetchTree();
        novaToast(`Đã xóa phòng ban "${node.name}"`, 'success');

    } catch (e) {
        console.error('Lỗi xóa phòng ban:', e);
        novaToast('Đã xảy ra lỗi. Vui lòng thử lại.', 'error');
    }
}   

// DRAG & DROP — reorder departments

// Tạo drop-root zone
const dropRootZone = document.createElement('div');
dropRootZone.className = 'orgchart-drop-root';
dropRootZone.innerHTML = `
    <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
    Thả vào đây để đưa lên cấp cao nhất
`;
document.body.appendChild(dropRootZone);

let dragState = {
    nodeId:   null,
    nodeName: null,
    ghostEl:  null,
};

// Tạo ghost element khi bắt đầu drag
function createGhost(cardEl, name) {
    const ghost = document.createElement('div');
    ghost.style.cssText = `
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        background: #fff;
        border: 2px solid #3b82f6;
        border-radius: 12px;
        padding: 8px 14px;
        font-size: 12.5px;
        font-weight: 700;
        color: #1d4ed8;
        box-shadow: 0 8px 24px rgba(59,130,246,0.3);
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 7px;
        transform: rotate(-2deg) scale(1.05);
        transition: transform 0.1s;
    `;
    ghost.innerHTML = `
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
        </svg>
        ${escHtml(name)}
    `;
    document.body.appendChild(ghost);
    return ghost;
}

// Gắn drag events vào một dept card
function attachDragEvents(cardEl, nodeId, nodeName) {
    cardEl.setAttribute('draggable', 'true');

    cardEl.addEventListener('dragstart', (e) => {
        // Không cho drag khi click vào collapse button
        if (e.target.closest('.orgchart-dept-collapse')) {
            e.preventDefault();
            return;
        }

        dragState.nodeId   = nodeId;
        dragState.nodeName = nodeName;

        // Custom ghost
        dragState.ghostEl = createGhost(cardEl, nodeName);
        e.dataTransfer.setDragImage(dragState.ghostEl, -16, -16);
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', String(nodeId));

        setTimeout(() => {
            cardEl.classList.add('dragging');
            dropRootZone.classList.add('visible');
        }, 0);
    });

    cardEl.addEventListener('dragend', () => {
        cardEl.classList.remove('dragging');
        dropRootZone.classList.remove('visible', 'drag-over-root');

        // Xóa ghost
        if (dragState.ghostEl) {
            dragState.ghostEl.remove();
            dragState.ghostEl = null;
        }

        // Clear tất cả drag-over
        document.querySelectorAll('.orgchart-dept-card.drag-over')
            .forEach(el => el.classList.remove('drag-over'));

        dragState.nodeId   = null;
        dragState.nodeName = null;
    });

    cardEl.addEventListener('dragover', (e) => {
        if (!dragState.nodeId || dragState.nodeId === nodeId) return;
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        cardEl.classList.add('drag-over');
    });

    cardEl.addEventListener('dragleave', (e) => {
        // Chỉ remove khi thực sự rời khỏi card (không phải hover vào child)
        if (!cardEl.contains(e.relatedTarget)) {
            cardEl.classList.remove('drag-over');
        }
    });

    cardEl.addEventListener('drop', async (e) => {
        e.preventDefault();
        cardEl.classList.remove('drag-over');

        const fromId = dragState.nodeId;
        const toId   = nodeId;

        if (!fromId || fromId === toId) return;

        await moveDept(fromId, toId);
    });
}

// Gắn drop-root zone events
dropRootZone.addEventListener('dragover', (e) => {
    if (!dragState.nodeId) return;
    e.preventDefault();
    dropRootZone.classList.add('drag-over-root');
});

dropRootZone.addEventListener('dragleave', () => {
    dropRootZone.classList.remove('drag-over-root');
});

dropRootZone.addEventListener('drop', async (e) => {
    e.preventDefault();
    dropRootZone.classList.remove('drag-over-root');

    const fromId = dragState.nodeId;
    if (!fromId) return;

    await moveDept(fromId, null); // null = đưa lên root
});

// Gọi API move
async function moveDept(fromId, toId) {
    const fromNode = findNodeById(state.tree, fromId);
    const fromName = fromNode?.name || `#${fromId}`;

    // Kiểm tra client-side: không thể thả vào con cháu của chính nó
    if (toId && isDescendant(state.tree, fromId, toId)) {
        novaToast('Không thể di chuyển vào phòng ban con của chính nó', 'error');
        return;
    }

    // Kiểm tra nếu parent không đổi
    if (fromNode && fromNode.parent_id === toId) {
        return;
    }

    try {
        const url = cfg.moveUrl.replace('__ID__', fromId);
        const res = await fetch(url, {
            method:  'PATCH',
            headers: {
                'Content-Type':     'application/json',
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     cfg.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ parent_id: toId }),
        });

        const data = await res.json();

        if (!res.ok) {
            novaToast(data.message || 'Di chuyển thất bại', 'error');
            return;
        }

        const toNode = toId ? findNodeById(state.tree, toId) : null;
        const toName = toNode?.name || 'cấp cao nhất';
        novaToast(`Đã di chuyển "${fromName}" vào "${toName}"`, 'success');

        await fetchTree();

    } catch (err) {
        console.error('Lỗi di chuyển phòng ban:', err);
        novaToast('Đã xảy ra lỗi, vui lòng thử lại', 'error');
    }
}

// Tìm node theo id trong cây
function findNodeById(nodes, id) {
    for (const node of nodes) {
        if (node.id === id) return node;
        if (node.children?.length) {
            const found = findNodeById(node.children, id);
            if (found) return found;
        }
    }
    return null;
}

// Kiểm tra targetId có phải là con cháu của fromId không
function isDescendant(nodes, fromId, targetId) {
    const fromNode = findNodeById(nodes, fromId);
    if (!fromNode) return false;

    function hasDescendant(node, id) {
        return node.children?.some(c => c.id === id || hasDescendant(c, id));
    }

    return hasDescendant(fromNode, targetId);
}

// Hook vào createDeptCard để gắn drag events tự động
// Override createDeptCard để thêm drag handle + events
const _originalCreateDeptCard = createDeptCard;
// Patch: gắn drag events sau khi card được tạo xong
// Ta override bằng cách wrap
window.__deptCardCreated = function(wrap, node) {
    const cardEl = wrap.querySelector('.orgchart-dept-card');
    if (!cardEl) return;

    // Thêm drag handle icon
    const handle = document.createElement('div');
    handle.className = 'orgchart-dept-drag-handle';
    handle.title = 'Kéo để di chuyển';
    handle.innerHTML = `
        <svg viewBox="0 0 24 24">
            <circle cx="9"  cy="5"  r="1" fill="#94a3b8"/>
            <circle cx="15" cy="5"  r="1" fill="#94a3b8"/>
            <circle cx="9"  cy="12" r="1" fill="#94a3b8"/>
            <circle cx="15" cy="12" r="1" fill="#94a3b8"/>
            <circle cx="9"  cy="19" r="1" fill="#94a3b8"/>
            <circle cx="15" cy="19" r="1" fill="#94a3b8"/>
        </svg>
    `;
    cardEl.style.position = 'relative';
    cardEl.appendChild(handle);

    attachDragEvents(cardEl, node.id, node.name);
};

// EXPORT PDF
document.getElementById('btn-export-png').addEventListener('click', exportPDF);

async function exportPDF() {
    const btn = document.getElementById('btn-export-png');
    const originalTitle = btn.title;

    // Loading state
    btn.disabled = true;
    btn.innerHTML = `
        <svg viewBox="0 0 24 24" style="animation:orgchart-spin 0.7s linear infinite">
            <circle cx="12" cy="12" r="10" stroke-dasharray="31.4" stroke-dashoffset="10"/>
        </svg>
    `;

    try {
        // Load thư viện nếu chưa có
        await loadScript('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js');
        await loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');

        // Lưu transform hiện tại
        const savedTransform = canvas.style.transform;
        const savedZoom      = state.zoom;
        const savedPanX      = state.panX;
        const savedPanY      = state.panY;

        // Reset transform để chụp full
        canvas.style.transform = 'translate(0px, 0px) scale(1)';

        // Đợi DOM ổn định
        await new Promise(r => setTimeout(r, 120));

        // Chụp canvas
        const canvasEl = await html2canvas(canvas, {
            backgroundColor: '#f8fafc',
            scale:           1.5,   // độ phân giải cao hơn
            useCORS:         true,
            allowTaint:      true,
            scrollX:         0,
            scrollY:         0,
            width:           canvas.scrollWidth,
            height:          canvas.scrollHeight,
            windowWidth:     canvas.scrollWidth,
            windowHeight:    canvas.scrollHeight,
        });

        // Khôi phục transform
        state.zoom = savedZoom;
        state.panX = savedPanX;
        state.panY = savedPanY;
        applyTransform();

        // Tạo PDF
        const { jsPDF } = window.jspdf;

        const imgW  = canvasEl.width;
        const imgH  = canvasEl.height;
        const ratio = imgW / imgH;

        // Chọn orientation dựa trên tỉ lệ
        const orientation = ratio >= 1 ? 'landscape' : 'portrait';

        const pdf     = new jsPDF({ orientation, unit: 'mm', format: 'a4' });
        const pageW   = pdf.internal.pageSize.getWidth();
        const pageH   = pdf.internal.pageSize.getHeight();
        const margin  = 12;

        const availW  = pageW - margin * 2;
        const availH  = pageH - margin * 2 - 20; // 20mm cho header

        // Tính scale để vừa trang
        const scaleW  = availW / imgW;
        const scaleH  = availH / imgH;
        const scale   = Math.min(scaleW, scaleH);

        const drawW   = imgW * scale;
        const drawH   = imgH * scale;
        const offsetX = margin + (availW - drawW) / 2;
        const offsetY = margin + 20;

        // Header
        const now    = new Date();
        const dateStr = now.toLocaleDateString('vi-VN', {
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit',
        });

        pdf.setFillColor(29, 78, 216);
        pdf.rect(0, 0, pageW, 14, 'F');

        pdf.setTextColor(255, 255, 255);
        pdf.setFontSize(10);
        pdf.setFont('helvetica', 'bold');
        pdf.text('SƠ ĐỒ TỔ CHỨC', margin, 9);

        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(8);
        pdf.text(`Xuất ngày: ${dateStr}`, pageW - margin, 9, { align: 'right' });

        // Thêm ảnh
        const imgData = canvasEl.toDataURL('image/png', 1.0);
        pdf.addImage(imgData, 'PNG', offsetX, offsetY, drawW, drawH);

        // Footer
        pdf.setTextColor(148, 163, 184);
        pdf.setFontSize(7);
        pdf.setFont('helvetica', 'normal');
        pdf.text('Nova HRM+', margin, pageH - 5);
        pdf.text(`Trang 1/1`, pageW - margin, pageH - 5, { align: 'right' });

        // Nếu ảnh quá dài → chia nhiều trang
        if (drawH > availH) {
            pdf.deletePage(1);
            await exportMultiPage(pdf, canvasEl, pageW, pageH, margin, dateStr);
        }

        // Tên file
        const filename = `so-do-to-chuc-${now.getFullYear()}${String(now.getMonth()+1).padStart(2,'0')}${String(now.getDate()).padStart(2,'0')}.pdf`;
        pdf.save(filename);

        novaToast('Xuất PDF thành công!', 'success');

    } catch (err) {
        console.error('Lỗi xuất PDF:', err);
        novaToast('Xuất PDF thất bại, vui lòng thử lại', 'error');
    } finally {
        btn.disabled  = false;
        btn.title     = originalTitle;
        btn.innerHTML = `<svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>`;
    }
}

// Export nhiều trang khi sơ đồ quá dài
async function exportMultiPage(pdf, canvasEl, pageW, pageH, margin, dateStr) {
    const imgW     = canvasEl.width;
    const imgH     = canvasEl.height;
    const availW   = pageW - margin * 2;
    const availH   = pageH - margin * 2 - 20;

    // Scale theo chiều ngang
    const scale    = availW / imgW;
    const drawW    = imgW * scale;
    const sliceH   = availH / scale; // chiều cao mỗi slice theo pixel gốc

    const totalPages = Math.ceil(imgH / sliceH);

    for (let i = 0; i < totalPages; i++) {
        if (i > 0) pdf.addPage();

        // Header mỗi trang
        pdf.setFillColor(29, 78, 216);
        pdf.rect(0, 0, pageW, 14, 'F');
        pdf.setTextColor(255, 255, 255);
        pdf.setFontSize(10);
        pdf.setFont('helvetica', 'bold');
        pdf.text('SƠ ĐỒ TỔ CHỨC', margin, 9);
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(8);
        pdf.text(`Xuất ngày: ${dateStr}`, pageW - margin, 9, { align: 'right' });

        // Cắt slice từ canvas gốc
        const sliceCanvas  = document.createElement('canvas');
        const srcY         = Math.round(i * sliceH);
        const srcH         = Math.min(sliceH, imgH - srcY);
        sliceCanvas.width  = imgW;
        sliceCanvas.height = srcH;

        const ctx = sliceCanvas.getContext('2d');
        ctx.drawImage(canvasEl, 0, srcY, imgW, srcH, 0, 0, imgW, srcH);

        const sliceData = sliceCanvas.toDataURL('image/png', 1.0);
        const drawH     = srcH * scale;

        pdf.addImage(sliceData, 'PNG', margin, margin + 20, drawW, drawH);

        // Footer
        pdf.setTextColor(148, 163, 184);
        pdf.setFontSize(7);
        pdf.text('Nova HRM+', margin, pageH - 5);
        pdf.text(`Trang ${i+1}/${totalPages}`, pageW - margin, pageH - 5, { align: 'right' });
    }
}

// Load script động (tránh load lại nếu đã có)
function loadScript(src) {
    return new Promise((resolve, reject) => {
        if (document.querySelector(`script[src="${src}"]`)) {
            resolve();
            return;
        }
        const s    = document.createElement('script');
        s.src      = src;
        s.onload   = resolve;
        s.onerror  = reject;
        document.head.appendChild(s);
    });
}
