<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierPerformanceController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('purchaseOrders')
            ->orderBy('company_name')
            ->get();

        $totalSuppliers = $suppliers->count();

        $totalOrders = $suppliers->sum(function ($supplier) {
            return $supplier->purchaseOrders->count();
        });

        $completedOrders = $suppliers->sum(function ($supplier) {
            return $supplier->purchaseOrders
                ->where('status', 'received')->count();
        });

        $pendingOrders = $suppliers->sum(function ($supplier) {
            return $supplier->purchaseOrders
                ->whereIn('status', ['draft', 'pending', 'approved', 'sent'])
                ->count();
        });

        $totalAmount = $suppliers->sum(function ($supplier) {
            return $supplier->purchaseOrders->sum('total');
        });

        return view('supplier_performance.index', compact(
            'suppliers',
            'totalSuppliers',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'totalAmount'
        ));
    }
}