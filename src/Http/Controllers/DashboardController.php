<?php

namespace CodeByKyle\NovaCustomNavigation\Http\Controllers;

use CodeByKyle\NovaCustomNavigation\CustomNavigation;
use Illuminate\Routing\Controller;
use Laravel\Nova\Nova;

class DashboardController extends Controller
{
    public function show($slug) {

        $dashboard = tap(CustomNavigation::dashboardForKey($slug), function ($dashboard) {
            abort_if(is_null($dashboard), 404);
            abort_if(!$dashboard->authorize(request()), 403);
        });


        return response()->json($dashboard->jsonSerialize());
    }
}