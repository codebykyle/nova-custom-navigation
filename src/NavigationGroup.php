<?php

namespace CodeByKyle\NovaCustomNavigation;

use CodeByKyle\NovaCustomNavigation\Links\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Element;
use Laravel\Nova\Metable;
use Laravel\Nova\Nova;
use Laravel\Nova\ResolvesCards;
use Laravel\Nova\Resource;
use Laravel\Nova\Tool;
use JsonSerializable;


abstract class NavigationGroup extends Element implements Redirect
{
    public static $linkType = 'route';

    public static $component = 'navigation-group';

    public static $label;

    public static $icon;

    public static $visible = true;

    public static $allowExpansion = true;

    public static $alwaysExpanded = false;

    public function component()
    {
        return static::$component;
    }

    public function linkType()
    {
        return static::$linkType;
    }

    /**
     * Get the URL when the user clicks the group header
     * @param Request $request
     * @return array
     */
    public abstract function getUrl(Request $request);

    /**
     * Get the links available for this group
     * @param Request $request
     * @return array
     */
    public function links(Request $request) {
        return [];
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
     * @return string
     */
    public function label() {
        return static::$label;
    }

    /**
     * Get the icon for this navigation group
     *
     * @return array|string
     * @throws \Throwable
     */
    public function icon() {
        return view(static::$icon)->render();
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
     * Get an icon from a callback for svg support
     *
     * @return array|mixed|string
     * @throws \Throwable
     */
    protected function resolveIcon() {
        if (is_callable(static::$icon)) {
            return call_user_func(static::$icon);
        }

        return view('nova-custom-navigation::icons.default')->render();
    }

    /**
     * Resolve the classes for the navigation item
     *
     * @param Request $request
     * @return array
     */
    protected function resolveClasses(Request $request) {
        return $this->classes($request);
    }

    /**
     * Get this navigation items links
     *
     * @param Request $request
     * @return array
     */
    protected function resolveLinks(Request $request) {
        return collect($this->links($request))->map(function ($item) use ($request) {
            if (!$item->authorize($request)) {
                return null;
            }

            return $item->jsonSerialize();
        })->filter->all();
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
            'label' => $this->label(),
            'classes' => $this->resolveClasses($request),
            'linkType' => $this->linkType(),
            'icon' => $this->resolveIcon($request),
            'alwaysExpanded' => static::$alwaysExpanded,
            'links' => $this->resolveLinks($request),
        ]);
    }
}
