<?php

header("Content-Type: application/json");

$products = [
    [
        "id" => 1,
        "name" => "Classic Burger",
        "category" => "Food",
        "price" => 250,
        "stock" => 25,
        "minimumStock" => 10
    ],
    [
        "id" => 2,
        "name" => "Cheese Pizza",
        "category" => "Food",
        "price" => 450,
        "stock" => 8,
        "minimumStock" => 10
    ],
    [
        "id" => 3,
        "name" => "Italian Pasta",
        "category" => "Food",
        "price" => 320,
        "stock" => 18,
        "minimumStock" => 8
    ],
    [
        "id" => 4,
        "name" => "Chicken Meal",
        "category" => "Food",
        "price" => 280,
        "stock" => 5,
        "minimumStock" => 10
    ],
    [
        "id" => 5,
        "name" => "Iced Tea",
        "category" => "Beverage",
        "price" => 80,
        "stock" => 40,
        "minimumStock" => 15
    ],
    [
        "id" => 6,
        "name" => "Coffee",
        "category" => "Beverage",
        "price" => 120,
        "stock" => 30,
        "minimumStock" => 10
    ],
    [
        "id" => 7,
        "name" => "Soft Drink",
        "category" => "Beverage",
        "price" => 70,
        "stock" => 12,
        "minimumStock" => 15
    ],
    [
        "id" => 8,
        "name" => "French Fries",
        "category" => "Side Dish",
        "price" => 150,
        "stock" => 20,
        "minimumStock" => 8
    ],
    [
        "id" => 9,
        "name" => "Chocolate Cake",
        "category" => "Dessert",
        "price" => 180,
        "stock" => 7,
        "minimumStock" => 10
    ],
    [
        "id" => 10,
        "name" => "Ice Cream",
        "category" => "Dessert",
        "price" => 130,
        "stock" => 22,
        "minimumStock" => 8
    ]
];

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    echo json_encode([
        "success" => true,
        "products" => $products
    ]);
    exit;
}

if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid data"
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Product received",
        "product" => $data
    ]);
    exit;
}

if ($method === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid data"
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Product update received",
        "product" => $data
    ]);
    exit;
}

http_response_code(405);

echo json_encode([
    "success" => false,
    "message" => "Method not allowed"
]);

?>