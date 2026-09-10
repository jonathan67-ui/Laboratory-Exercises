let products = [
    {
        id: 1,
        name: "Classic Burger",
        category: "Food",
        price: 250,
        stock: 25,
        minimumStock: 10
    },
    {
        id: 2,
        name: "Cheese Pizza",
        category: "Food",
        price: 450,
        stock: 8,
        minimumStock: 10
    },
    {
        id: 3,
        name: "Italian Pasta",
        category: "Food",
        price: 320,
        stock: 18,
        minimumStock: 8
    },
    {
        id: 4,
        name: "Chicken Meal",
        category: "Food",
        price: 280,
        stock: 5,
        minimumStock: 10
    },
    {
        id: 5,
        name: "Iced Tea",
        category: "Beverage",
        price: 80,
        stock: 40,
        minimumStock: 15
    },
    {
        id: 6,
        name: "Coffee",
        category: "Beverage",
        price: 120,
        stock: 30,
        minimumStock: 10
    },
    {
        id: 7,
        name: "Soft Drink",
        category: "Beverage",
        price: 70,
        stock: 12,
        minimumStock: 15
    },
    {
        id: 8,
        name: "French Fries",
        category: "Side Dish",
        price: 150,
        stock: 20,
        minimumStock: 8
    },
    {
        id: 9,
        name: "Chocolate Cake",
        category: "Dessert",
        price: 180,
        stock: 7,
        minimumStock: 10
    },
    {
        id: 10,
        name: "Ice Cream",
        category: "Dessert",
        price: 130,
        stock: 22,
        minimumStock: 8
    }
];

let recentChanges = [
    {
        product: "Cheese Pizza",
        action: "Stock decreased",
        quantity: -2,
        time: "Just now"
    },
    {
        product: "Iced Tea",
        action: "Stock increased",
        quantity: 5,
        time: "5 minutes ago"
    },
    {
        product: "Chicken Meal",
        action: "Stock decreased",
        quantity: -3,
        time: "10 minutes ago"
    }
];

let salesData = {
    labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
    values: [9500, 11200, 12450, 10800, 13600, 15200, 14500]
};

function initializeData() {
    return products;
}

function getProducts() {
    return products;
}

function getProductById(id) {
    return products.find(function(product) {
        return product.id === Number(id);
    });
}

function getProductsByCategory(category) {
    if (category === "All") {
        return products;
    }

    return products.filter(function(product) {
        return product.category === category;
    });
}

function getLowStockProducts() {
    return products.filter(function(product) {
        return product.stock <= product.minimumStock;
    });
}

function getStockStatus(product) {
    if (product.stock === 0) {
        return "Out of Stock";
    }

    if (product.stock <= product.minimumStock) {
        return "Low Stock";
    }

    return "In Stock";
}

function getStockStatistics() {
    let inStock = 0;
    let lowStock = 0;
    let outOfStock = 0;

    products.forEach(function(product) {
        const status = getStockStatus(product);

        if (status === "In Stock") {
            inStock++;
        }

        if (status === "Low Stock") {
            lowStock++;
        }

        if (status === "Out of Stock") {
            outOfStock++;
        }
    });

    return {
        inStock: inStock,
        lowStock: lowStock,
        outOfStock: outOfStock
    };
}

function getCategorySummary() {
    const summary = {};

    products.forEach(function(product) {
        if (!summary[product.category]) {
            summary[product.category] = 0;
        }

        summary[product.category] += product.price * product.stock;
    });

    return summary;
}

function getTopProductsByValue() {
    return [...products]
        .sort(function(a, b) {
            return (b.price * b.stock) - (a.price * a.stock);
        })
        .slice(0, 5);
}

function filterByStockStatus(list, status) {
    if (status === "All") {
        return list;
    }

    return list.filter(function(product) {
        return getStockStatus(product) === status;
    });
}

function filterByPriceRange(list, minPrice, maxPrice) {
    return list.filter(function(product) {
        const min = minPrice === "" ? 0 : Number(minPrice);
        const max = maxPrice === "" ? Infinity : Number(maxPrice);

        return product.price >= min && product.price <= max;
    });
}

function searchProducts(list, searchTerm) {
    if (!searchTerm.trim()) {
        return list;
    }

    const term = searchTerm.toLowerCase();

    return list.filter(function(product) {
        return (
            product.name.toLowerCase().includes(term) ||
            product.category.toLowerCase().includes(term)
        );
    });
}

function getFilteredProducts(filters) {
    let result = products;

    result = getProductsByCategory(filters.category, result);

    if (filters.category !== "All") {
        result = products.filter(function(product) {
            return product.category === filters.category;
        });
    }

    result = filterByStockStatus(result, filters.stock);
    result = filterByPriceRange(result, filters.minPrice, filters.maxPrice);
    result = searchProducts(result, filters.search);

    return result;
}

function exportToCSV(list) {
    let csv = "ID,Product,Category,Price,Stock,Stock Status,Inventory Value\n";

    list.forEach(function(product) {
        const value = product.price * product.stock;

        csv += [
            product.id,
            product.name,
            product.category,
            product.price,
            product.stock,
            getStockStatus(product),
            value
        ].join(",") + "\n";
    });

    const blob = new Blob([csv], {
        type: "text/csv;charset=utf-8;"
    });

    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");

    link.href = url;
    link.download = "tasty-table-inventory.csv";
    link.click();

    URL.revokeObjectURL(url);
}

function simulateInventoryUpdate() {
    const randomProduct =
        products[Math.floor(Math.random() * products.length)];

    const change = Math.random() > 0.5 ? 1 : -1;

    randomProduct.stock = Math.max(
        0,
        randomProduct.stock + change
    );

    recentChanges.unshift({
        product: randomProduct.name,
        action: change > 0 ? "Stock increased" : "Stock decreased",
        quantity: change,
        time: "Just now"
    });

    recentChanges = recentChanges.slice(0, 5);

    return randomProduct;
}

function getRecentChanges() {
    return recentChanges;
}

function getSalesData() {
    return salesData;
}