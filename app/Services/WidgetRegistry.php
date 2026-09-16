<?php

namespace App\Services;

use App\Models\User;

class WidgetRegistry
{
    protected array $widgets =
        [
            'dashboard.widgets.pending-approvals' => 'approve purchase-requests',
            'dashboard.widgets.recent-purchase-orders' => 'manage purchase-orders',
            'dashboard.widgets.critical-stocks-stock' => 'view stock',
        ];

    public function getWidgetsForUser(User $user): array
    {
        $allowedWidgets = [];

        foreach ($this->widgets as $componentName => $permission) {
            if ($user->hasRole('superadmin') || $user->can($permission)) {
                $allowedWidgets[] = $componentName;
            }
        }

        return $allowedWidgets;
    }
}
