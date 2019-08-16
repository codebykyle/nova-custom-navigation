<?php

namespace CodeByKyle\NovaCustomNavigation;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaCustomNavigation extends Tool
{
    public $goToResourceInstead;

    public $resources = [];

    public $tools = [];

    public $label = 'Navigation Item';

    public $codeName = 'navigation_item';

    public $iconCallback;

    /**
     * Create a new element.
     *
     * @param string|null $component
     * @return void
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    /**
     * Set a callback to get the icon
     *
     * @param callable $callback
     * @return Tool
     */
    public function iconCallback(callable $callback):Tool {
        $this->iconCallback = $callback;
        return $this;
    }


    /**
     * Get an icon from a callback for svg support
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getIcon() {
        if (is_callable($this->iconCallback)) {
            return call_user_func($this->iconCallback);
        }

        return view('nova-custom-navigation::icons.default');
    }

    /**
     * Set the label to show in navigation
     *
     * @param $string
     * @return $this
     */
    public function setLabel($string) {
        $this->label = $string;
        return $this;
    }


    /**
     * Go to a resource index instead of the dashboard
     *
     * @param $resource
     * @return $this
     */
    public function goToResourceIndex($resource)
    {
        $this->goToResourceInstead = $resource;
        return $this;
    }

    /**
     * Resources to display
     *
     * @param array $resourcesArray
     * @return $this;
     */
    public function setResources(array $resourcesArray)
    {
        $this->resources = $resourcesArray;
        return $this;
    }

    /**
     * Set the name used on the client side for this resource
     *
     * @param $code_name
     * @return $this
     */
    public function setCodeName($code_name)
    {
        $this->codeName = $code_name;
        return $this;
    }

    public function getCodeName() {
        return $this->codeName;
    }

    /**
     * Set the tools for the dashboard
     *
     * @param array $tools
     * @return $this
     */
    public function tools(array $tools)
    {
        $this->tools = $tools;
        return $this;
    }

    /**
     * Get the tools available for the dashboard
     *
     * @return array $tools
     */
    public function getTools() : array
    {
        return $this->tools;
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
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        $request = request();
        $navigationItems = $this->resources;

        return view('nova-custom-navigation::navigation', [
            'tool' => $this
        ]);
    }
}
