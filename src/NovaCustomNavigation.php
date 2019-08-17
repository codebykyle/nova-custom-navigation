<?php

namespace CodeByKyle\NovaCustomNavigation;

use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;


class NovaCustomNavigation extends Tool
{
    public $navigationGroups;

    public function __construct($groups=[])
    {
        parent::__construct();
        $this->navigationGroups = $groups;
    }

    /**
     * Add an item to the navigation group
     *
     * @param NavigationGroup|array $group
     * @return $this
     */
    public function addGroups($group) {
        $groups[] = $group;
        $this->navigationGroups = array_merge($this->navigationGroups, $groups);
        return $this;
    }

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
     * Turn the available groups into a concrete array
     *
     * @param Request $request
     * @return array
     */
    protected function resolveGroups(Request $request) {
        return $this->navigationGroups;
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        $request = request();
        $navigationGroups = $this->resolveGroups($request);

        return view('nova-custom-navigation::navigation', [
            'navigationGroups' => collect($navigationGroups)->map(function ($group) {
                return $group->jsonSerialize();
            })
        ]);
    }
}
