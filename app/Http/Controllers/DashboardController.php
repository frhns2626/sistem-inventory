<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\WidgetRegistry;

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
