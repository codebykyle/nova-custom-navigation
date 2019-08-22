<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Redirects;

use Illuminate\Http\Request;


class RouteRedirect implements Redirect
{
    /**
     * An array representation of a vue-router/nova link
     * @var
     */
    public $route;

    /**
     * The type of route this should use. Often 'web' or 'route'
     * @var string
     */
    public static $type = 'route';

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
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getUrl(Request $request) {
        return $this->route;
    }

    /**
     * Get the label of the navigation item
     *
     * @return string
     */
    public function linkType()
    {
        return static::$type;
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'route' => json_encode($this->getUrl()),
            'linkType' => static::linkType()
        ];
    }
}
