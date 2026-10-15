class ChartConfig {
    static renderCategoryChart(ctx, categories, values) {
        return new Chart(ctx, {
            type: "bar",
            data: {
                labels: categories,
                datasets: [{
                    label: "Total Value (₱)",
                    data: values,
                    backgroundColor: "#2E7D32",
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    static renderStatusChart(ctx, statusCounts) {
        const totalItems = statusCounts.in_stock + statusCounts.low_stock + statusCounts.out_of_stock;

        return new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["In Stock", "Low Stock", "Out of Stock"],
                datasets: [{
                    data: [statusCounts.in_stock, statusCounts.low_stock, statusCounts.out_of_stock],
                    backgroundColor: ["#2E7D32", "#D97706", "#C62828"]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        const percentage = totalItems > 0 ? ((value / totalItems) * 100).toFixed(1) : 0;
                                        return {
                                            text: `${label}: ${value} (${percentage}%)`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw || 0;
                                const percentage = totalItems > 0 ? ((value / totalItems) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${value} items (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    static renderSalesTrendChart(ctx, salesData) {
        return new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                datasets: [{
                    label: "Revenue (₱)",
                    data: salesData,
                    borderColor: "#2E7D32",
                    backgroundColor: "rgba(46, 125, 50, 0.15)",
                    fill: true,
                    tension: 0.35,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: "#1B5E20"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: "top" },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` Revenue: ₱${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
}

window.ChartConfig = ChartConfig;