<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

$dbFile = __DIR__ . '/inventory_db.json';

if (!file_exists($dbFile)) {
    $initialData = [
        ["id" => 1, "name" => "Premium Beef Patties", "sku" => "MEAT-001", "category" => "Meat & Poultry", "quantity" => 145, "unit_price" => 120.00, "reorder_level" => 40],
        ["id" => 2, "name" => "Cheddar Cheese Slices", "sku" => "DAIRY-002", "category" => "Dairy & Cheese", "quantity" => 210, "unit_price" => 15.00, "reorder_level" => 50],
        ["id" => 3, "name" => "Brioche Burger Buns", "sku" => "GRAIN-003", "category" => "Grains & Pasta", "quantity" => 24,  "unit_price" => 22.00, "reorder_level" => 30],
        ["id" => 4, "name" => "Italian Spaghetti Pasta", "sku" => "GRAIN-004", "category" => "Grains & Pasta", "quantity" => 85,  "unit_price" => 45.00, "reorder_level" => 20],
        ["id" => 5, "name" => "Fresh Iceberg Lettuce", "sku" => "PROD-005", "category" => "Produce", "quantity" => 0,   "unit_price" => 60.00, "reorder_level" => 15],
        ["id" => 6, "name" => "Fresh Chicken Breasts", "sku" => "MEAT-006", "category" => "Meat & Poultry", "quantity" => 92,  "unit_price" => 180.00, "reorder_level" => 25],
        ["id" => 7, "name" => "Whole Milk Gallons", "sku" => "DAIRY-007", "category" => "Dairy & Cheese", "quantity" => 11,  "unit_price" => 150.00, "reorder_level" => 15]
    ];
    file_put_contents($dbFile, json_encode($initialData, JSON_PRETTY_PRINT));
}

$method = $_SERVER["REQUEST_METHOD"];
$inventory = json_decode(file_get_contents($dbFile), true);

if ($method === 'GET') {
    if (isset($_GET['simulate']) && $_GET['simulate'] === 'true') {
        foreach ($inventory as &$item) {
            $offset = rand(-2, 2);
            $item['quantity'] = max(0, $item['quantity'] + $offset);
        }
        file_put_contents($dbFile, json_encode($inventory, JSON_PRETTY_PRINT));
    }
    echo json_encode($inventory);
} elseif ($method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    if (isset($input['id']) && isset($input['quantity'])) {
        foreach ($inventory as &$item) {
            if ($item['id'] == $input['id']) {
                $item['quantity'] = max(0, intval($input['quantity']));
                break;
            }
        }
        file_put_contents($dbFile, json_encode($inventory, JSON_PRETTY_PRINT));
        echo json_encode(["status" => "success", "message" => "Stock saved successfully."]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid request payload attributes."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed."]);
}
?>