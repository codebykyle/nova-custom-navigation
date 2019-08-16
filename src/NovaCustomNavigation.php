<?php

namespace CodeByKyle\NovaCustomNavigation;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Metable;
use Laravel\Nova\Nova;
use Laravel\Nova\ResolvesCards;
use Laravel\Nova\Resource;
use Laravel\Nova\Tool;
use JsonSerializable;
use function Aws\map;


class NovaCustomNavigation extends Tool implements JsonSerializable
{
    use ResolvesCards, Metable;

    public $label;

    public $navigationComponent;

    public $dashboardComponent;

    public $uriKey;

    public $resources = [];

    public $cards = [];

    public $link;

    public $icon;

    public $visible;

    public $classes = [];

    public $allowExpansion = true;

    public $alwaysExpanded = false;

    public $linkType = null;

    public $route = null;

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
     * Set the CSS classes for the navigation component
     * @param $classes
     * @return $this
     */
    public function classes($classes) {
        $this->classes[] = $classes;
        return $this;
    }


    /**
     * Set the label to show in navigation
     *
     * @param $label
     * @return $this
     */
    public function label($label) {
        $this->label = $label;
        return $this;
    }
    /**
     * Set a callback to get the icon
     *
     * @param callable $callback
     * @return Tool
     */
    public function icon(callable $callback):Tool {
        $this->icon = $callback;
        return $this;
    }

    /**
     * Resources to display
     *
     * @param array $resourcesArray
     * @return $this;
     */
    public function resources(array $resourcesArray)
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
    public function uriKey($code_name)
    {
        $this->uriKey = $code_name;
        return $this;
    }
    /**
     * Set the cards to display on the dashboard, if applicable
     *
     * @return $this
     */
    public function setCards($cards) {
        $this->cards = $cards;
        return $this;
    }

    /**
     * Return the cards to display on the dashboard, if applicable
     *
     * @return array
     */
    public function cards(Request $request) {
        return $this->cards;
    }

    /**
     * Set the navigation
     * @param $component
     * @return $this
     */
    public function navigationComponent($component) {
        $this->navigationComponent = $component;
        return $this;
    }

    /**
     * The component to use for the generated dashboard
     *
     * @param $component
     * @return $this
     */
    public function dashboardComponent($component) {
        $this->dashboardComponent = $component;
        return $this;
    }

    /**
     * Get if the navigation item is visible
     * @param $isVisible
     * @return $this
     */
    public function visible($isVisible) {
        $this->visible = $isVisible;
        return $this;
    }

    /**
     * Set the item to always be expanded
     *
     * @param bool $expanded
     * @return $this
     */
    public function alwaysExpanded($expanded=True) {
        $this->alwaysExpanded = $expanded;
        return $this;
    }

    /**
     * Set the navigation component to redirect to an index page
     *
     * @param $namespace
     * @return $this
     */
    public function dashboard($cards=null)
    {
        $this->route('category-dashboard', [
            'categoryName' => $this->resolveUriKey()
        ]);

        if (!empty($cards)) {
            $this->setCards($cards);
        }

        return $this;
    }

    /**
     * Set the navigation component to redirect to an index page
     *
     * @param $namespace
     * @return $this
     */
    public function index($namespace)
    {
        $this->route('index', [
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
    public function detail($namespace, $id)
    {
        $this->route('detail', [
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
    public function create($namespace)
    {
        $this->route('create', [
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
    public function edit($namespace, $id)
    {
        $this->route('edit', [
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
    public function lens($namespace, $key)
    {
        $this->route('lens', [
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
    public function link($href, $target = '_blank')
    {
        $this->linkType = 'link';

        $this->link = compact('href', 'target');

        return $this;
    }

    public function route($name, $params)
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
    public function withFilters(array $filters)
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
     * Resolve the dashboard component to use
     *
     * @param $component
     * @return string
     */
    public function resolveDashboardComponent() {
        return $this->dashboardComponent;
    }


    /**
     * Get the navigation component
     *
     * @return string|null
     */
    public function resolveNavigationComponent() {
        return $this->navigationComponent ?? 'navigation-group';
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
