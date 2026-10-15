document.addEventListener("DOMContentLoaded", async () => {
    const username = localStorage.getItem("username") || "admin";
    
    if (!username) {
        window.location.href = "index.html";
        return;
    }

    const navUserEl = document.getElementById("navUsername");
    if (navUserEl) navUserEl.textContent = username;

    let categoryChartInstance = null;
    let statusChartInstance = null;
    let salesTrendChartInstance = null;
    let autoUpdateInterval = null;
    let isAutoUpdating = true;

    let weeklySales = [9500, 11200, 12450, 10800, 14200, 18500, 16300];

    const dashboardView = document.getElementById("dashboardView");
    const pageContent = document.getElementById("pageContent");
    const menuLinks = document.querySelectorAll(".menu-link");

    const tableBody = document.getElementById("inventoryTableBody");
    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");
    const statusFilter = document.getElementById("statusFilter");
    const resetFiltersBtn = document.getElementById("resetFiltersBtn");
    const exportCsvBtn = document.getElementById("exportCsvBtn");
    const simulateBtn = document.getElementById("simulateBtn");
    const syncIcon = document.getElementById("syncIcon");
    const liveBadge = document.getElementById("liveBadge");
    const alertContainer = document.getElementById("alertContainer");

    const logoutBtn = document.getElementById("logoutButton");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
            localStorage.removeItem("username");
            window.location.href = "index.html";
        });
    }

    const brandBtn = document.getElementById("brandButton");
    if (brandBtn) {
        brandBtn.addEventListener("click", (e) => {
            e.preventDefault();
            showPage("dashboard");
        });
    }

    function updateGreeting() {
        const hour = new Date().getHours();
        let greeting = hour < 12 ? "Good Morning" : hour < 18 ? "Good Afternoon" : "Good Evening";
        const greetingEl = document.getElementById("greetingText");
        if (greetingEl) greetingEl.textContent = `${greeting}, ${username}!`;

        const date = new Date();
        const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
        const dateEl = document.getElementById("currentDate");
        if (dateEl) dateEl.textContent = `📅 ${date.toLocaleDateString("en-US", options)}`;
    }

    async function loadDashboard(simulate = false) {
        await window.dataManager.fetchInventory(simulate);
        
        if (simulate) {
            weeklySales = weeklySales.map(val => {
                const change = Math.floor(Math.random() * 1000) - 500;
                return Math.max(5000, val + change);
            });
        }

        populateCategoryDropdown();
        renderDashboard();
    }

    function populateCategoryDropdown() {
        if (!categoryFilter) return;
        const currentVal = categoryFilter.value;
        const categories = window.dataManager.getCategories();
        categoryFilter.innerHTML = `<option value="ALL">All Categories</option>`;
        categories.forEach(cat => {
            const opt = document.createElement("option");
            opt.value = cat;
            opt.textContent = cat;
            categoryFilter.appendChild(opt);
        });
        if (currentVal) categoryFilter.value = currentVal;
    }

    function renderDashboard() {
        renderTable();
        renderKPIs();
        renderCharts();
        checkAlerts();
    }

    function renderTable() {
        if (!tableBody) return;
        const filtered = window.dataManager.getFilteredInventory();
        tableBody.innerHTML = "";
        
        const badgeEl = document.getElementById("itemCountBadge");
        if (badgeEl) badgeEl.textContent = `${filtered.length} items`;

        if (filtered.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">No inventory items match current filter criteria.</td></tr>`;
            return;
        }

        filtered.forEach(item => {
            const status = window.dataManager.getStockStatus(item);
            const totalVal = (item.unit_price || item.price) * item.quantity;
            const tr = document.createElement("tr");

            tr.innerHTML = `
                <td><strong>${item.sku || item.code}</strong></td>
                <td>${item.name}</td>
                <td><span class="badge bg-light text-dark border">${item.category}</span></td>
                <td>₱${Number(item.unit_price || item.price).toFixed(2)}</td>
                <td><strong>${item.quantity}</strong></td>
                <td><span class="${status.cssClass}">${status.label}</span></td>
                <td class="fw-bold text-success">₱${totalVal.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
            `;
            tableBody.appendChild(tr);
        });
    }

    function renderKPIs() {
        const items = window.dataManager.getInventory();
        const totalVal = items.reduce((acc, item) => acc + ((item.unit_price || item.price) * item.quantity), 0);
        const lowStockCount = window.dataManager.getLowStockItems().length;

        const kpiItems = document.getElementById("kpiTotalItems");
        const kpiVal = document.getElementById("kpiTotalValue");
        const kpiLow = document.getElementById("kpiLowStock");
        const kpiCats = document.getElementById("kpiCategories");

        if (kpiItems) kpiItems.textContent = items.length;
        if (kpiVal) kpiVal.textContent = `₱${totalVal.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
        if (kpiLow) kpiLow.textContent = lowStockCount;
        if (kpiCats) kpiCats.textContent = window.dataManager.getCategories().length;
    }

    function renderCharts() {
        const catSummary = window.dataManager.getCategorySummary();
        const catCanvas = document.getElementById("categoryValueChart");
        if (catCanvas) {
            if (categoryChartInstance) categoryChartInstance.destroy();
            categoryChartInstance = window.ChartConfig.renderCategoryChart(
                catCanvas.getContext("2d"),
                Object.keys(catSummary),
                Object.values(catSummary)
            );
        }

        const statusDist = window.dataManager.getStatusDistribution();
        const statusCanvas = document.getElementById("stockStatusChart");
        if (statusCanvas) {
            if (statusChartInstance) statusChartInstance.destroy();
            statusChartInstance = window.ChartConfig.renderStatusChart(
                statusCanvas.getContext("2d"),
                statusDist
            );
        }

        const salesCanvas = document.getElementById("salesTrendChart");
        if (salesCanvas) {
            if (salesTrendChartInstance) salesTrendChartInstance.destroy();
            salesTrendChartInstance = window.ChartConfig.renderSalesTrendChart(
                salesCanvas.getContext("2d"),
                weeklySales
            );
        }
    }

    function checkAlerts() {
        if (!alertContainer) return;
        const lowStockItems = window.dataManager.getLowStockItems();
        if (lowStockItems.length > 0) {
            alertContainer.innerHTML = `
                <div class="alert alert-warning alert-dismissible fade show shadow-sm border-warning mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Attention Required:</strong> There are <strong>${lowStockItems.length}</strong> items low or out of stock!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        } else {
            alertContainer.innerHTML = "";
        }
    }

    function startAutoLiveUpdates() {
        if (autoUpdateInterval) clearInterval(autoUpdateInterval);
        autoUpdateInterval = setInterval(() => {
            if (isAutoUpdating) {
                if (syncIcon) syncIcon.classList.add("spin-animation");
                loadDashboard(true).then(() => {
                    setTimeout(() => {
                        if (syncIcon) syncIcon.classList.remove("spin-animation");
                    }, 500);
                });
            }
        }, 3000);
    }

    function showPage(page) {
        menuLinks.forEach(link => {
            link.classList.remove("active");
            if (link.dataset.page === page) link.classList.add("active");
        });

        if (page === "dashboard") {
            if (dashboardView) dashboardView.classList.remove("d-none");
            if (pageContent) pageContent.innerHTML = "";
            renderCharts();
            return;
        }

        if (dashboardView) dashboardView.classList.add("d-none");
        if (pageContent) {
            pageContent.innerHTML = `
                <div class="content-card mt-3">
                    <h4 class="fw-bold text-success">${page.toUpperCase()} Section</h4>
                    <p class="text-muted">Welcome to the ${page} page. Additional features can be loaded here.</p>
                </div>
            `;
        }
    }

    menuLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            showPage(link.dataset.page);
        });
    });

    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            window.dataManager.activeFilters.searchQuery = e.target.value;
            renderTable();
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener("change", (e) => {
            window.dataManager.activeFilters.category = e.target.value;
            renderTable();
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener("change", (e) => {
            window.dataManager.activeFilters.status = e.target.value;
            renderTable();
        });
    }

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener("click", () => {
            if (searchInput) searchInput.value = "";
            if (categoryFilter) categoryFilter.value = "ALL";
            if (statusFilter) statusFilter.value = "ALL";
            window.dataManager.activeFilters = { searchQuery: "", category: "ALL", status: "ALL" };
            renderTable();
        });
    }

    if (exportCsvBtn) {
        exportCsvBtn.addEventListener("click", () => {
            window.dataManager.exportToCSV();
        });
    }

    if (simulateBtn) {
        simulateBtn.addEventListener("click", () => {
            isAutoUpdating = !isAutoUpdating;
            if (isAutoUpdating) {
                simulateBtn.className = "btn btn-success btn-sm";
                if (liveBadge) liveBadge.className = "badge bg-danger d-flex align-items-center gap-1 py-2 px-3";
            } else {
                simulateBtn.className = "btn btn-outline-secondary btn-sm";
                if (liveBadge) liveBadge.className = "badge bg-secondary d-flex align-items-center gap-1 py-2 px-3";
            }
        });
    }

    updateGreeting();
    await loadDashboard();
    startAutoLiveUpdates();
});