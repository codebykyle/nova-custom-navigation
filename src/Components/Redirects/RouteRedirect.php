<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Redirects;

use CodeByKyle\NovaCustomNavigation\Components\Redirect;
use CodeByKyle\NovaCustomNavigation\Components\RedirectTypes;
use CodeByKyle\NovaCustomNavigation\Components\RouteTypes;
use Illuminate\Http\Request;

class RouteRedirect extends Redirect
{
    /**
     * An array representation of a vue-router/nova link
     * @var
     */
    public $route;

    /**
     * The route type to display
     * @see RouteTypes
     * @var string
     */
    public $routeType;

    /**
     * Link constructor.
     * @param array $route
     *
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * Make a new instance of this class
     * @param mixed ...$args
     * @return RouteRedirect
     */
    public static function make(...$args) {
        return new static(...$args);
    }

    /**
     * Set the route manually
     *
     * @param $route
     * @return $this
     */
    public function setRoute($route) {
        $this->route = $route;
        return $this;
    }

    /**
     * Manually set the route type
     * @see RouteTypes
     *
     * @param string $type
     * @return $this
     */
    public function routeType($type) {
        $this->routeType = $type;
        return $this;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getUrl(Request $request) {
        return $this->route;
    }

    /**
     * Get the redirect type
     *
     * @return string
     */
    public function redirectType()
    {
        return RedirectTypes::$ROUTE;
    }

    /**
     * The type of object that this route redirects to. If it is not set,
     * try to guess the route type based on the Nova Link
     *
     * @see RouteTypes
     * @return string
     */
    public function getRouteType() {
        if (!empty($this->routeType)) {
            return $this->routeType;
        }

        switch(collect($this->route)->get('name')) {
            case 'dashboard':
            case 'dashboard.custom':
                return RouteTypes::$DASHBOARD;
            case 'index':
            case 'detail':
            case 'create':
            case 'edit':
                return RouteTypes::$RESOURCE;
            case 'lens':
                return RouteTypes::$LENS;
            default:
                return RouteTypes::$TOOL;
        }
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'routeType' => $this->getRouteType(),
        ]);
    }
}
