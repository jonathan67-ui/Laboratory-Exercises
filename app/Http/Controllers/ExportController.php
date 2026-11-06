<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function productsCsv()
    {
        $products = Product::all();

        $fileName = 'products_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () use ($products) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Product Name',
                'SKU',
                'Description',
                'Category',
                'Quantity',
                'Reorder Level',
                'Unit Price',
                'Supplier'
            ]);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->description,
                    $product->category,
                    $product->quantity,
                    $product->reorder_level,
                    $product->unit_price,
                    $product->supplier
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function productsPdf()
{
    $products = Product::all();

    $pdf = Pdf::loadView('exports.products-pdf', [
        'products' => $products
    ]);

    return $pdf->download('products_' . date('Y-m-d') . '.pdf');
}
}