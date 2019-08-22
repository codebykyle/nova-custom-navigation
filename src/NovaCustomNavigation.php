<?php

namespace CodeByKyle\NovaCustomNavigation;

use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;


class NovaCustomNavigation extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-custom-navigation', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-custom-navigation', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        $request = request();

        $navigationGroups = collect(CustomNavigation::$navigationGroups)
            ->filter
            ->authorize($request)
            ->map(function ($navigation) {
                return $navigation->jsonSeralize();
            })
            ->unique()
            ->filter
            ->values();

        return view('nova-custom-navigation::navigation', [
            'navigationGroups' => $navigationGroups
        ]);
    }
}
