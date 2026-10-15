class DataManager {
    constructor() {
        this.inventory = [];
        this.activeFilters = {
            searchQuery: "",
            category: "ALL",
            status: "ALL"
        };
    }

    async fetchInventory(simulate = false) {
        const endpoints = [
            "api/inventory.php",
            "api/products.php",
            "inventory.php",
            "products.php"
        ];

        let fetchedData = null;

        for (let url of endpoints) {
            try {
                const fetchUrl = simulate ? `${url}?simulate=true` : url;
                const response = await fetch(fetchUrl);
                if (response.ok) {
                    fetchedData = await response.json();
                    break;
                }
            } catch (e) {
                // Continue trying next endpoint
            }
        }

        // Auto-fallback default data if PHP backend is not accessible via fetch
        if (!fetchedData || !Array.isArray(fetchedData) || fetchedData.length === 0) {
            console.warn("Backend API not reached. Loading default fallback dataset.");
            fetchedData = [
                {"id": 1, "name": "Premium Beef Patties", "sku": "MEAT-001", "category": "Meat & Poultry", "quantity": 145, "unit_price": 120.00, "reorder_level": 40},
                {"id": 2, "name": "Cheddar Cheese Slices", "sku": "DAIRY-002", "category": "Dairy & Cheese", "quantity": 210, "unit_price": 15.00, "reorder_level": 50},
                {"id": 3, "name": "Brioche Burger Buns", "sku": "GRAIN-003", "category": "Grains & Pasta", "quantity": 24, "unit_price": 22.00, "reorder_level": 30},
                {"id": 4, "name": "Italian Spaghetti Pasta", "sku": "GRAIN-004", "category": "Grains & Pasta", "quantity": 85, "unit_price": 45.00, "reorder_level": 20},
                {"id": 5, "name": "Fresh Iceberg Lettuce", "sku": "PROD-005", "category": "Produce", "quantity": 0, "unit_price": 60.00, "reorder_level": 15},
                {"id": 6, "name": "Fresh Chicken Breasts", "sku": "MEAT-006", "category": "Meat & Poultry", "quantity": 92, "unit_price": 180.00, "reorder_level": 25},
                {"id": 7, "name": "Whole Milk Gallons", "sku": "DAIRY-007", "category": "Dairy & Cheese", "quantity": 11, "unit_price": 150.00, "reorder_level": 15}
            ];
        }

        this.inventory = fetchedData;
        return this.inventory;
    }

    getInventory() {
        return this.inventory;
    }

    getStockStatus(item) {
        if (item.quantity === 0) {
            return { label: "Out of Stock", code: "out_of_stock", cssClass: "status-out" };
        }
        if (item.quantity <= (item.reorder_level || item.reorderLevel || 20)) {
            return { label: "Low Stock", code: "low_stock", cssClass: "status-pending" };
        }
        return { label: "In Stock", code: "in_stock", cssClass: "status-completed" };
    }

    getFilteredInventory() {
        return this.inventory.filter(item => {
            const skuVal = item.sku || item.code || "";
            const matchesSearch = item.name.toLowerCase().includes(this.activeFilters.searchQuery.toLowerCase()) ||
                                  skuVal.toLowerCase().includes(this.activeFilters.searchQuery.toLowerCase());
            const matchesCategory = this.activeFilters.category === "ALL" || item.category === this.activeFilters.category;
            const statusObj = this.getStockStatus(item);
            const matchesStatus = this.activeFilters.status === "ALL" || statusObj.code === this.activeFilters.status;

            return matchesSearch && matchesCategory && matchesStatus;
        });
    }

    getLowStockItems() {
        return this.inventory.filter(item => item.quantity <= (item.reorder_level || item.reorderLevel || 20));
    }

    getCategories() {
        return [...new Set(this.inventory.map(item => item.category))];
    }

    getCategorySummary() {
        const summary = {};
        this.getCategories().forEach(cat => {
            summary[cat] = this.inventory
                .filter(item => item.category === cat)
                .reduce((sum, item) => sum + ((item.unit_price || item.price) * item.quantity), 0);
        });
        return summary;
    }

    getStatusDistribution() {
        const dist = { in_stock: 0, low_stock: 0, out_of_stock: 0 };
        this.inventory.forEach(item => {
            const status = this.getStockStatus(item).code;
            dist[status]++;
        });
        return dist;
    }

    exportToCSV() {
        const headers = ["SKU", "Name", "Category", "Unit Price", "Quantity", "Total Value", "Status"];
        const rows = this.getFilteredInventory().map(item => [
            item.sku || item.code,
            `"${item.name}"`,
            item.category,
            item.unit_price || item.price,
            item.quantity,
            ((item.unit_price || item.price) * item.quantity).toFixed(2),
            this.getStockStatus(item).label
        ]);

        const csvContent = "data:text/csv;charset=utf-8," + [headers.join(","), ...rows.map(e => e.join(","))].join("\n");
        const link = document.createElement("a");
        link.href = encodeURI(csvContent);
        link.download = `tasty_table_inventory_${new Date().toISOString().slice(0, 10)}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

window.dataManager = new DataManager();