<?php

namespace App\Http\Controllers;

use App\Services\WidgetRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(WidgetRegistry $widgetRegistry, Request $request)
    {
        $user = Auth::user();

        return view('dashoard.index', [
            'activeWidgets' => $widgetRegistry->getWidgetsForUser($user),
        ]);
    }
}
