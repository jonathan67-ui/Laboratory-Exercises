<?php

namespace App\Policies;

use App\Models\PurchaseOrder;
use App\Models\User;

class PurchaseOrderPolicy
{
    // Change these role names if your project uses different names.
    private function isAdmin(User $user)
    {
        return $user->role === 'admin';
    }

    private function isManager(User $user)
    {
        return in_array($user->role, ['manager', 'admin']);
    }

    private function isWarehouse(User $user)
    {
        return in_array($user->role, ['warehouse', 'admin']);
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, PurchaseOrder $purchaseOrder)
    {
        return $this->isAdmin($user)
            || $this->isManager($user)
            || $this->isWarehouse($user)
            || $purchaseOrder->created_by === $user->id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, PurchaseOrder $purchaseOrder)
    {
        return $purchaseOrder->status === 'draft'
            && (
                $this->isAdmin($user)
                || $purchaseOrder->created_by === $user->id
            );
    }

    public function delete(User $user, PurchaseOrder $purchaseOrder)
    {
        return $purchaseOrder->status === 'draft'
            && $this->isAdmin($user);
    }

   public function approve(User $user, PurchaseOrder $purchaseOrder)
{
    return $purchaseOrder->status === 'draft';
}

    public function receive(User $user, PurchaseOrder $purchaseOrder)
    {
        return $this->isWarehouse($user)
            && in_array($purchaseOrder->status, ['approved', 'sent']);
    }

    public function send(User $user, PurchaseOrder $purchaseOrder)
    {
        return (
            $this->isAdmin($user)
            || $purchaseOrder->created_by === $user->id
        ) && $purchaseOrder->status === 'approved';
    }
}
