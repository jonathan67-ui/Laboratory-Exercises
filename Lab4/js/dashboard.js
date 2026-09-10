const username = localStorage.getItem("username");

if (!username) {
    window.location.href = "index.html";
}

document.getElementById("navUsername").textContent = username;

const dashboardView = document.getElementById("dashboardView");
const pageContent = document.getElementById("pageContent");
const menuLinks = document.querySelectorAll(".menu-link");
const logoutButton = document.getElementById("logoutButton");
const brandButton = document.getElementById("brandButton");
const viewOrdersButton = document.getElementById("viewOrdersButton");

let categoryChart;
let stockChart;
let salesChart;

function updateGreeting() {
    const hour = new Date().getHours();
    let greeting;

    if (hour < 12) {
        greeting = "Good Morning";
    } else if (hour < 18) {
        greeting = "Good Afternoon";
    } else {
        greeting = "Good Evening";
    }

    document.getElementById("greetingText").textContent =
        `${greeting}, ${username}!`;

    const date = new Date();

    const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
    };

    document.getElementById("currentDate").textContent =
        `📅 ${date.toLocaleDateString("en-US", options)}`;
}

function updateStatistics() {
    const stats = [
        {
            title: "Today's Orders",
            value: "48",
            change: "↑ 12% from yesterday",
            changeClass: "positive"
        },
        {
            title: "Today's Revenue",
            value: "₱12,450",
            change: "↑ 8% from yesterday",
            changeClass: "positive"
        },
        {
            title: "Available Tables",
            value: "12 / 20",
            change: "8 tables occupied",
            changeClass: "normal"
        },
        {
            title: "Popular Item",
            value: "Burger",
            change: "24 orders today",
            changeClass: "normal"
        }
    ];

    stats.forEach(function(stat, index) {
        const num = index + 1;

        document.getElementById(`stat${num}-title`).textContent = stat.title;
        document.getElementById(`stat${num}-value`).textContent = stat.value;

        const changeEl = document.getElementById(`stat${num}-change`);

        changeEl.textContent = stat.change;
        changeEl.className = stat.changeClass;
    });
}

function populateActivityTable() {
    const activities = [
        {
            order: "#1001",
            customer: "Maria Santos",
            item: "Classic Burger",
            amount: "₱350",
            status: "Completed"
        },
        {
            order: "#1002",
            customer: "John Cruz",
            item: "Chicken Meal",
            amount: "₱280",
            status: "Completed"
        },
        {
            order: "#1003",
            customer: "Anna Reyes",
            item: "Italian Pasta",
            amount: "₱420",
            status: "Pending"
        }
    ];

    const tbody = document.getElementById("activityTableBody");

    tbody.innerHTML = "";

    activities.forEach(function(activity) {
        const statusClass =
            activity.status === "Completed"
                ? "status-completed"
                : "status-pending";

        const row = document.createElement("tr");

        row.innerHTML = `
            <td><strong>${activity.order}</strong></td>
            <td>${activity.customer}</td>
            <td>${activity.item}</td>
            <td>${activity.amount}</td>
            <td><span class="${statusClass}">${activity.status}</span></td>
        `;

        tbody.appendChild(row);
    });
}

function showPage(page) {
    menuLinks.forEach(function(link) {
        link.classList.remove("active");

        if (link.dataset.page === page) {
            link.classList.add("active");
        }
    });

    if (page === "dashboard") {
        dashboardView.classList.remove("d-none");
        pageContent.innerHTML = "";
        return;
    }

    dashboardView.classList.add("d-none");

    if (page === "orders") showOrders();
    if (page === "menu") showMenu();
    if (page === "customers") showCustomers();
    if (page === "tables") showTables();
    if (page === "reports") showReports();
    if (page === "inventory") showInventory();
}

function showOrders() {
    pageContent.innerHTML = `
        <header class="welcome-section">
            <div>
                <p class="welcome-small">RESTAURANT MANAGEMENT</p>
                <h1>Orders</h1>
                <p>Manage restaurant orders.</p>
            </div>
        </header>

        <section class="content-card">
            <div class="section-header">
                <div>
                    <h4>All Orders</h4>
                    <p>Current restaurant orders</p>
                </div>
                <button class="btn btn-success">+ New Order</button>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><strong>#1001</strong></td>
                            <td>Maria Santos</td>
                            <td>Classic Burger</td>
                            <td>₱350</td>
                            <td><span class="status-completed">Completed</span></td>
                            <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                        </tr>

                        <tr>
                            <td><strong>#1002</strong></td>
                            <td>John Cruz</td>
                            <td>Chicken Meal</td>
                            <td>₱280</td>
                            <td><span class="status-completed">Completed</span></td>
                            <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                        </tr>

                        <tr>
                            <td><strong>#1003</strong></td>
                            <td>Anna Reyes</td>
                            <td>Italian Pasta</td>
                            <td>₱420</td>
                            <td><span class="status-pending">Pending</span></td>
                            <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                        </tr>

                        <tr>
                            <td><strong>#1004</strong></td>
                            <td>Mark Garcia</td>
                            <td>Cheese Pizza</td>
                            <td>₱550</td>
                            <td><span class="status-completed">Completed</span></td>
                            <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    `;
}

function showMenu() {
    pageContent.innerHTML = `
        <header class="welcome-section">
            <div>
                <p class="welcome-small">RESTAURANT MANAGEMENT</p>
                <h1>Menu</h1>
                <p>Manage your restaurant menu items.</p>
            </div>
        </header>

        <section class="row g-4">
            <div class="col-md-6 col-xl-4">
                <div class="content-card text-center">
                    <div class="food-icon mx-auto mb-3">🍔</div>
                    <h4>Classic Burger</h4>
                    <p>Beef burger with cheese and vegetables.</p>
                    <h5 class="text-success">₱250</h5>
                    <button class="btn btn-outline-primary">Edit Item</button>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="content-card text-center">
                    <div class="food-icon mx-auto mb-3">🍕</div>
                    <h4>Cheese Pizza</h4>
                    <p>Fresh pizza with mozzarella cheese.</p>
                    <h5 class="text-success">₱450</h5>
                    <button class="btn btn-outline-primary">Edit Item</button>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="content-card text-center">
                    <div class="food-icon mx-auto mb-3">🍝</div>
                    <h4>Italian Pasta</h4>
                    <p>Creamy pasta with special sauce.</p>
                    <h5 class="text-success">₱320</h5>
                    <button class="btn btn-outline-primary">Edit Item</button>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="content-card text-center">
                    <div class="food-icon mx-auto mb-3">🍗</div>
                    <h4>Chicken Meal</h4>
                    <p>Crispy chicken with rice and vegetables.</p>
                    <h5 class="text-success">₱280</h5>
                    <button class="btn btn-outline-primary">Edit Item</button>
                </div>
            </div>
        </section>
    `;
}

function showCustomers() {
    pageContent.innerHTML = `
        <header class="welcome-section">
            <div>
                <p class="welcome-small">CUSTOMER MANAGEMENT</p>
                <h1>Customers</h1>
                <p>View your restaurant customers.</p>
            </div>
        </header>

        <section class="content-card">
            <div class="section-header">
                <div>
                    <h4>Customer List</h4>
                    <p>Registered restaurant customers</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Maria Santos</td>
                            <td>maria@example.com</td>
                            <td>12</td>
                            <td>₱4,250</td>
                            <td><span class="status-completed">Active</span></td>
                        </tr>

                        <tr>
                            <td>John Cruz</td>
                            <td>john@example.com</td>
                            <td>8</td>
                            <td>₱2,850</td>
                            <td><span class="status-completed">Active</span></td>
                        </tr>

                        <tr>
                            <td>Anna Reyes</td>
                            <td>anna@example.com</td>
                            <td>15</td>
                            <td>₱5,120</td>
                            <td><span class="status-completed">Active</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    `;
}

function showTables() {
    pageContent.innerHTML = `
        <header class="welcome-section">
            <div>
                <p class="welcome-small">RESTAURANT MANAGEMENT</p>
                <h1>Tables</h1>
                <p>Check the current table availability.</p>
            </div>
        </header>

        <section class="row g-4">

            <div class="col-md-6 col-xl-3">
                <div class="content-card text-center">
                    <h4>Table 01</h4>
                    <div class="food-icon mx-auto my-3">🪑</div>
                    <p>4 seats</p>
                    <span class="available">Available</span>
                    <br>
                    <button class="btn btn-outline-primary mt-3">Reserve</button>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="content-card text-center">
                    <h4>Table 02</h4>
                    <div class="food-icon mx-auto my-3">🪑</div>
                    <p>2 seats</p>
                    <span class="occupied">Occupied</span>
                    <br>
                    <button class="btn btn-outline-danger mt-3">Occupied</button>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="content-card text-center">
                    <h4>Table 03</h4>
                    <div class="food-icon mx-auto my-3">🪑</div>
                    <p>4 seats</p>
                    <span class="available">Available</span>
                    <br>
                    <button class="btn btn-outline-primary mt-3">Reserve</button>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="content-card text-center">
                    <h4>Table 04</h4>
                    <div class="food-icon mx-auto my-3">🪑</div>
                    <p>6 seats</p>
                    <span class="occupied">Occupied</span>
                    <br>
                    <button class="btn btn-outline-danger mt-3">Occupied</button>
                </div>
            </div>

        </section>
    `;
}

function showReports() {
    pageContent.innerHTML = `
        <header class="welcome-section">
            <div>
                <p class="welcome-small">BUSINESS REPORT</p>
                <h1>Reports</h1>
                <p>Today's restaurant performance.</p>
            </div>
        </header>

        <section class="row g-4">

            <div class="col-md-6 col-xl-3">
                <div class="dashboard-card">
                    <div class="card-icon green">💰</div>
                    <div class="card-info">
                        <p>Total Revenue</p>
                        <h2>₱12,450</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="dashboard-card">
                    <div class="card-icon orange">🧾</div>
                    <div class="card-info">
                        <p>Total Orders</p>
                        <h2>48</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="dashboard-card">
                    <div class="card-icon blue">👥</div>
                    <div class="card-info">
                        <p>Customers</p>
                        <h2>36</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="dashboard-card">
                    <div class="card-icon red">⭐</div>
                    <div class="card-info">
                        <p>Rating</p>
                        <h2>4.8</h2>
                    </div>
                </div>
            </div>

        </section>

        <section class="content-card mt-4">
            <div class="section-header">
                <div>
                    <h4>Daily Sales</h4>
                    <p>Restaurant sales summary</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Monday</td>
                            <td>35</td>
                            <td>₱9,500</td>
                        </tr>

                        <tr>
                            <td>Tuesday</td>
                            <td>42</td>
                            <td>₱11,200</td>
                        </tr>

                        <tr>
                            <td>Wednesday</td>
                            <td>48</td>
                            <td>₱12,450</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    `;
}

function showInventory() {
    pageContent.innerHTML = `
        <header class="welcome-section">
            <div>
                <p class="welcome-small">LABORATORY EXERCISE 4</p>
                <h1>Inventory Management</h1>
                <p>Manage restaurant products, stock levels, and inventory values.</p>
            </div>
        </header>

        <div id="lowStockAlert"></div>

        <section class="content-card mb-4">
            <div class="section-header">
                <div>
                    <h4>Inventory Controls</h4>
                    <p>Search, filter, and export inventory data</p>
                </div>

                <button class="btn btn-success" id="exportButton">
                    Export CSV
                </button>
            </div>

            <div class="row g-3">

                <div class="col-md-6 col-lg-3">
                    <label class="form-label">Search Product</label>
                    <input
                        type="text"
                        class="form-control"
                        id="productSearch"
                        placeholder="Search product...">
                </div>

                <div class="col-md-6 col-lg-2">
                    <label class="form-label">Category</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="All">All</option>
                        <option value="Food">Food</option>
                        <option value="Beverage">Beverage</option>
                        <option value="Side Dish">Side Dish</option>
                        <option value="Dessert">Dessert</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <label class="form-label">Stock Status</label>
                    <select class="form-select" id="stockFilter">
                        <option value="All">All</option>
                        <option value="In Stock">In Stock</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <label class="form-label">Min Price</label>
                    <input
                        type="number"
                        class="form-control"
                        id="minPrice"
                        placeholder="₱0">
                </div>

                <div class="col-md-6 col-lg-2">
                    <label class="form-label">Max Price</label>
                    <input
                        type="number"
                        class="form-control"
                        id="maxPrice"
                        placeholder="₱9999">
                </div>

            </div>
        </section>

        <div id="loadingMessage" class="alert alert-info d-none">
            Loading inventory...
        </div>

        <div id="errorMessage" class="alert alert-danger d-none"></div>

        <section class="content-card mb-4">
            <div class="section-header">
                <div>
                    <h4>Inventory Products</h4>
                    <p>Current restaurant stock</p>
                </div>
                <span class="inventory-count" id="inventoryCount">0 products</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Inventory Value</th>
                        </tr>
                    </thead>

                    <tbody id="inventoryTableBody"></tbody>
                </table>
            </div>
        </section>

        <section class="row g-4 mb-4">

            <div class="col-lg-6">
                <div class="content-card chart-card">
                    <div class="section-header">
                        <div>
                            <h4>Inventory Value by Category</h4>
                            <p>Total inventory value</p>
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="content-card chart-card">
                    <div class="section-header">
                        <div>
                            <h4>Stock Status</h4>
                            <p>Product stock distribution</p>
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="content-card chart-card">
                    <div class="section-header">
                        <div>
                            <h4>Sales Trends</h4>
                            <p>Weekly restaurant sales</p>
                        </div>
                    </div>

                    <div class="chart-container sales-chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

        </section>

        <section class="content-card">
            <div class="section-header">
                <div>
                    <h4>Recent Inventory Changes</h4>
                    <p>Latest stock updates</p>
                </div>
                <span class="live-indicator">● LIVE</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Action</th>
                            <th>Quantity</th>
                            <th>Time</th>
                        </tr>
                    </thead>

                    <tbody id="changesTableBody"></tbody>
                </table>
            </div>
        </section>
    `;

    initializeInventory();
}

function initializeInventory() {
    initializeData();

    renderInventory();
    renderLowStockAlert();
    renderRecentChanges();
    renderCharts();

    document.getElementById("productSearch")
        .addEventListener("input", renderInventory);

    document.getElementById("categoryFilter")
        .addEventListener("change", renderInventory);

    document.getElementById("stockFilter")
        .addEventListener("change", renderInventory);

    document.getElementById("minPrice")
        .addEventListener("input", renderInventory);

    document.getElementById("maxPrice")
        .addEventListener("input", renderInventory);

    document.getElementById("exportButton")
        .addEventListener("click", function() {
            exportToCSV(getCurrentFilteredProducts());
        });
}

function getCurrentFilteredProducts() {
    return getFilteredProducts({
        search: document.getElementById("productSearch").value,
        category: document.getElementById("categoryFilter").value,
        stock: document.getElementById("stockFilter").value,
        minPrice: document.getElementById("minPrice").value,
        maxPrice: document.getElementById("maxPrice").value
    });
}

function renderInventory() {
    const tableBody = document.getElementById("inventoryTableBody");

    if (!tableBody) {
        return;
    }

    const list = getCurrentFilteredProducts();

    tableBody.innerHTML = "";

    list.forEach(function(product) {
        const status = getStockStatus(product);

        let statusClass = "stock-in";

        if (status === "Low Stock") {
            statusClass = "stock-low";
        }

        if (status === "Out of Stock") {
            statusClass = "stock-out";
        }

        const searchTerm =
            document.getElementById("productSearch").value.trim();

        let productName = product.name;

        if (searchTerm) {
            const regex = new RegExp(
                searchTerm.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"),
                "gi"
            );

            productName = product.name.replace(
                regex,
                function(match) {
                    return `<mark>${match}</mark>`;
                }
            );
        }

        const row = document.createElement("tr");

        row.innerHTML = `
            <td><strong>${productName}</strong></td>
            <td>${product.category}</td>
            <td>₱${product.price.toLocaleString()}</td>
            <td>${product.stock}</td>
            <td>
                <span class="stock-badge ${statusClass}">
                    ${status}
                </span>
            </td>
            <td>₱${(product.price * product.stock).toLocaleString()}</td>
        `;

        tableBody.appendChild(row);
    });

    document.getElementById("inventoryCount").textContent =
        `${list.length} product${list.length === 1 ? "" : "s"}`;

    renderLowStockAlert();
}

function renderLowStockAlert() {
    const alert = document.getElementById("lowStockAlert");

    if (!alert) {
        return;
    }

    const lowStockProducts = getLowStockProducts();

    if (lowStockProducts.length === 0) {
        alert.innerHTML = "";
        return;
    }

    alert.innerHTML = `
        <div class="low-stock-alert">
            <div>
                <strong>⚠️ Low Stock Alert</strong>
                <p>
                    ${lowStockProducts.length}
                    product${lowStockProducts.length === 1 ? "" : "s"}
                    need${lowStockProducts.length === 1 ? "s" : ""}
                    attention.
                </p>
            </div>

            <div class="low-stock-items">
                ${lowStockProducts
                    .map(function(product) {
                        return `
                            <span>
                                ${product.name}: ${product.stock}
                            </span>
                        `;
                    })
                    .join("")}
            </div>
        </div>
    `;
}

function renderRecentChanges() {
    const body = document.getElementById("changesTableBody");

    if (!body) {
        return;
    }

    body.innerHTML = "";

    getRecentChanges().forEach(function(change) {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td><strong>${change.product}</strong></td>
            <td>${change.action}</td>
            <td class="${change.quantity > 0 ? "change-positive" : "change-negative"}">
                ${change.quantity > 0 ? "+" : ""}${change.quantity}
            </td>
            <td>${change.time}</td>
        `;

        body.appendChild(row);
    });
}

function renderCharts() {
    const categoryData = getCategorySummary();

    const categoryCanvas =
        document.getElementById("categoryChart");

    const stockCanvas =
        document.getElementById("stockChart");

    const salesCanvas =
        document.getElementById("salesChart");

    if (categoryChart) {
        categoryChart.destroy();
    }

    if (stockChart) {
        stockChart.destroy();
    }

    if (salesChart) {
        salesChart.destroy();
    }

    categoryChart = new Chart(categoryCanvas, {
        type: "bar",
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                label: "Inventory Value",
                data: Object.values(categoryData)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const stock = getStockStatistics();

    stockChart = new Chart(stockCanvas, {
        type: "doughnut",
        data: {
            labels: [
                "In Stock",
                "Low Stock",
                "Out of Stock"
            ],
            datasets: [{
                data: [
                    stock.inStock,
                    stock.lowStock,
                    stock.outOfStock
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const sales = getSalesData();

    salesChart = new Chart(salesCanvas, {
        type: "line",
        data: {
            labels: sales.labels,
            datasets: [{
                label: "Sales",
                data: sales.values,
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

menuLinks.forEach(function(link) {
    link.addEventListener("click", function(event) {
        event.preventDefault();
        showPage(link.dataset.page);
    });
});

brandButton.addEventListener("click", function(event) {
    event.preventDefault();
    showPage("dashboard");
});

logoutButton.addEventListener("click", function() {
    localStorage.removeItem("username");
    window.location.href = "index.html";
});

viewOrdersButton.addEventListener("click", function() {
    showPage("orders");
});

updateGreeting();
updateStatistics();
populateActivityTable();
showPage("dashboard");

setInterval(function() {
    if (document.querySelector("#inventoryTableBody")) {
        simulateInventoryUpdate();
        renderInventory();
        renderRecentChanges();
        renderCharts();
    }
}, 15000);