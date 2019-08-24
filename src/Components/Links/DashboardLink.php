<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Links;

use CodeByKyle\NovaCustomNavigation\Components\NavigationLink;
use CodeByKyle\NovaCustomNavigation\Components\Redirects\RouteRedirect;
use Illuminate\Http\Request;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Nova;

class DashboardLink extends NavigationLink
{
    /**
     * The dashboard to link to
     * @var Dashboard|null
     */
    public $dashboard;

    /**
     * The type of component to use client-side
     *
     * @var string
     */
    public $component = 'resource-link';

    /**
     * DashboardLink constructor.
     * @param $dashboard
     * @param null $label
     */
    public function __construct($dashboard=null, $label=null)
    {
        parent::__construct($label);
        $this->dashboard = $dashboard;
    }

    /**
     * Get the label of the navigation item
     *
     * @return mixed
     */
    public function resolveLabel()
    {
        if (!empty($label = parent::resolveLabel())) {
            return $label;
        }

        if (!empty($this->dashboard)) {
            return $this->dashboard::label();
        }

        return 'Dashboard';
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getRedirect(Request $request) {
        return RouteRedirect::make([
            'name' => 'dashboard.custom',
            'params' => $this->getParams()
        ]);
    }

    /**
     * Get the params of the request
     * @return array
     */
    protected function getParams() {
        return array_merge($this->additionalInformation, [
            'name' =>  !empty($this->dashboard) ? $this->dashboard::uriKey() : 'main'
        ]);
    }


    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize() {
        return array_merge(parent::jsonSerialize(), [

        ]);
    }
}
