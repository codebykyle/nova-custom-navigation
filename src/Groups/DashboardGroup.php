<?php

namespace CodeByKyle\NovaCustomNavigation;

use CodeByKyle\NovaCustomNavigation\Links\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Metable;
use Laravel\Nova\Nova;
use Laravel\Nova\ResolvesCards;
use Laravel\Nova\Resource;
use Laravel\Nova\Tool;
use JsonSerializable;


 class DashboardGroup extends NavigationGroup implements Redirect
{
    use ResolvesCards, Metable;

    public static $label;

    public static $dashboardComponent;

    public static $uriKey;

    public static $resources = [];

    public static $link;

    public static $icon;

    public static $visible = true;

    public static $allowExpansion = true;

    public static $alwaysExpanded = false;

    protected $linkType = null;

    protected $route = null;

    public function __construct()
    {

    }

    public function navigateTo(Request $request) {
        return $this->goToDashboard();
    }

    /**
     * Get the CSS classes for the navigation group component
     *
     * @param Request $request
     * @return array
     */
    public function classes(Request $request) {
        return [];
    }


    /**
     * Get the label to show in navigation
     * @param Request $request
     * @return string
     */
    public function label(Request $request) {
        return static::$label;
    }

    /**
     * Get the icon for this navigation group
     *
     * @param Request $request
     * @return array|string
     * @throws \Throwable
     */
    public function icon(Request $request) {
        return view(static::$icon)->render();
    }

    /**
     * Get the resources to display
     *
     * @param $request
     * @return array
     */
    public function resources(Request $request) {
        return static::$resources;
    }

    /**
     * Get the URI key for the navigation group
     *
     * @return $this|string
     */
    public function uriKey()
    {
        return static::$uriKey ?? Str::snake(static::label(request()));
    }

    /**
     * Return the cards to display on the dashboard, if applicable
     *
     * @return array
     */
    public function cards(Request $request) {
        return [];
    }

    /**
     * Get the Group Navigation component
     *
     * @return $this
     */
    public function navigationComponent() {
        return static::$navigationComponent;
    }

    /**
     * Get the Dashboard component
     *
     * @return $this
     */
    public function dashboardComponent() {
        return static::$dashboardComponent;
    }

    /**
     * Get if the navigation item is visible
     *
     * @param Request $request
     * @return boolean
     */
    public function visible(Request $request) {
        return static::$visible;
    }

    /**
     * Set the item to always be expanded
     *
     * @return boolean
     */
    public function alwaysExpanded() {
        return static::$alwaysExpanded;
    }

    /**
     * Set the navigation component to redirect to an index page
     *
     * @return $this
     */
    public function goToDashboard()
    {
        $this->setRoute('category-dashboard', [
            'categoryName' => $this->resolveUriKey()
        ]);

        return $this;
    }

    /**
     * Set the navigation component to redirect to an index page
     *
     * @param $namespace
     * @return $this
     */
    protected function goToIndex($namespace)
    {
        $this->setRoute('index', [
            'resourceName' => $this->normalizeResourceName($namespace)
        ]);

        return $this;
    }

    /**
     * Set the navigation component to redirect to a detail page
     *
     * @param $namespace
     * @param $id
     * @return $this
     */
    protected function goToDetail($namespace, $id)
    {
        $this->setRoute('detail', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'resourceId' => $id,
        ]);
        
        return $this;
    }

    /**
     * Set the navigation component to redirect to a create page
     *
     * @param $namespace
     * @return $this
     */
    protected function goToCreate($namespace)
    {
        $this->setRoute('create', [
            'resourceName' => $this->normalizeResourceName($namespace)
        ]);

        return $this;
    }

    /**
     * Set the navigation component to redirect to an edit page
     * @param $namespace
     * @param $id
     * @return $this
     */
    protected function goToEdit($namespace, $id)
    {
        $this->setRoute('edit', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'resourceId' => $id,
        ]);

        return $this;
    }

    /**
     * Set the navigation category to direct to a lens
     *
     * @param $namespace
     * @param $key
     * @return $this
     */
    protected function goToLens($namespace, $key)
    {
        $this->setRoute('lens', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'lens' => $key
        ]);

        return $this;
    }

    /**
     * Set the navigation category to a link
     *
     * @param $href
     * @param string $target
     * @return $this
     */
    protected function goToLink($href, $target = '_blank')
    {
        $this->linkType = 'link';
        $this->link = compact('href', 'target');
        return $this;
    }

    protected function setRoute($name, $params)
    {
        $this->linkType = 'route';
        $this->route = $this->makeRoute($name, $params);
        return $this;
    }

    protected function makeRoute($name, $params) {
        return [
            'name' => $name,
            'params' => $params,
            'query' => [],
        ];
    }

    /**
     * Add filters to index view.
     *
     * @param  array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $key = $this->route['params']['resourceName'] . '_filter';

        $this->route['query'][$key] = base64_encode(json_encode(collect($filters)->map(function ($value, $key) {
            return [
                'class' => $key,
                'value' => $value
            ];
        })->values()));

        return $this;
    }

    /**
     * Turn the link into a string by calling the user function or string
     *
     * @param $request
     * @return callable
     */
    protected function resolveRoute() {
        return $this->route;
    }

    /**
     * Get the navigation URI key
     *
     * @return string
     */
    protected function resolveUriKey() {
        if ($this->uriKey) {
            return $this->uriKey;
        }

        return Str::kebab($this->label);
    }

    /**
     * Get an icon from a callback for svg support
     *
     * @return array|mixed|string
     * @throws \Throwable
     */
    protected function resolveIcon() {
        if (is_callable($this->icon)) {
            return call_user_func($this->icon);
        }

        return view('nova-custom-navigation::icons.default')->render();
    }

    /**
     * Resolve the classes for the navigation item
     *
     * @param $request
     * @return array
     */
    protected function resolveClasses($request) {
        return $this->classes;
    }

    /**
     * Resolve the resources available to the user for navigation
     *
     * @param $request
     * @param callable $withFunction
     * @return array
     */
    protected function resolveResources($request, callable $withFunction = null) {
        $availableResources = collect($this->resources)
            ->filter(function ($resource) use ($request) {
                return $resource::authorizedToViewAny($request) &&
                    $resource::availableForNavigation($request);
            });

        if (is_callable($withFunction)) {
            return $availableResources->map($withFunction)->all();
        }

        return $availableResources->all();
    }

    protected function resolveLink() {
        return $this->link;
    }

    protected function resolveLinkType() {
        return $this->linkType;
    }

    /**
     * @param  string $namespace
     * @return string
     */
    protected function normalizeResourceName($namespace)
    {
        return class_exists($namespace) && is_subclass_of($namespace, Resource::class)
            ? $namespace::uriKey() : $namespace;
    }

    /**
     * Disable this navigation item from opening
     *
     * @param bool $disabled
     * @return $this
     */
    public function disableExpansion($disabled=true) {
        $this->allowExpansion = !$disabled;
        return $this;
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $request = request();

        return array_merge(parent::jsonSerialize(), [
            'label' => $this->label,
            'classes' => $this->resolveClasses($request),
            'route' => $this->resolveRoute(),
            'link' => $this->resolveLink(),
            'linkType' => $this->resolveLinkType(),
            'dashboardUri' => $this->resolveUriKey(),
            'icon' => $this->resolveIcon(),
            'dashboardComponent' => $this->resolveDashboardComponent(),
            'navigationComponent' => $this->resolveNavigationComponent(),
            'alwaysExpanded' => $this->alwaysExpanded,
            'resources' => $this->resolveResources($request, function ($resource) use ($request) {
                return [
                    'label' => $resource::label(),
                    'uriKey' => $resource::uriKey(),
                    'isVisible' => $resource::$displayInNavigation,
                    'link' => $this->makeRoute('index', [
                        'resourceName' => $this->normalizeResourceName($resource)
                    ])
                ];
            })
        ]);
    }
}
