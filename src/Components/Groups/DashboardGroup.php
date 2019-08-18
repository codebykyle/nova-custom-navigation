<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Groups;

use CodeByKyle\NovaCustomNavigation\Components\Dashboard;
use CodeByKyle\NovaCustomNavigation\Components\NavigationGroupRedirect;
use CodeByKyle\NovaCustomNavigation\Helpers\NovaRouteBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\ResolvesCards;

abstract class DashboardGroup extends NavigationGroupRedirect
{
    use ResolvesCards;

    /**
     * Set the link type of the redirection to a vue-js route
     * @var string
     */
    public static $linkType = 'route';


    /**
     * The component of the group
     *
     * @var string
     */
    public $component = 'dashboard-group';

    /**
     * The dashboard class to use
     *
     * @var
     */
    public static $dashboard;


    public function getUrl(Request $request) {
        return $this->makeDashboardRoute($this->dashboard($request));
    }

    /**
     * Resolve the user settings into an instance of a dashboard
     *
     * @param Request $request
     * @return array
     */
    public function dashboard(Request $request)
    {
        return new static::$dashboard();
    }

    /**
     * Calculate a vue-router link to the dashboard
     *
     * @param Dashboard $dashboard
     * @return array
     */
    protected function makeDashboardRoute($dashboard)
    {
        return NovaRouteBuilder::makeRoute('custom-dashboard', [
            'dashboardName' => $dashboard::uriKey(),
        ]);
    }

    /**
     * JSON serialize this class with some information about the group and the dashboard
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'dashboard' => $this->dashboard(request())->jsonSerialize(),
        ]);
    }
}
