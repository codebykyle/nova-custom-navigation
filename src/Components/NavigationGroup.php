<?php

namespace CodeByKyle\NovaCustomNavigation\Components;

use App\AccountTransferRule;
use CodeByKyle\NovaCustomNavigation\Components\Items\WebLink;
use CodeByKyle\NovaCustomNavigation\Components\Items\ResourceIndexLink;
use CodeByKyle\NovaCustomNavigation\Components\Items\ResourceLink;
use Illuminate\Http\Request;
use Laravel\Nova\Element;


abstract class NavigationGroup extends Element
{
    public static $label;

    public static $icon;

    public static $visible = true;

    public static $allowExpansion = true;

    public static $alwaysExpanded = false;

    public $component = 'navigation-group';

    /**
     * The link to go to when the group is clicked
     *
     * @param Request $request
     * @return null|Redirect $redirect
     */
    public function link(Request $request) {
        return null;
    }

    /**
     * Get the items available for this group
     * @param Request $request
     * @return array
     */
    public function items(Request $request) {
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
    public static function label() {
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
    protected function resolveItems(Request $request) {
        return collect($this->items($request))->map(function ($item) use ($request) {
            if (!$item->authorize($request)) {
                return null;
            }

            return $item->jsonSerialize();
        })->filter();
    }

    /**
     * Resolve the link for this group
     *
     * @param Request $request
     * @return null|Redirect $redirect
     */
    protected function resolveLink(Request $request) {
        return $this->link($request);
    }


    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     * @throws
     */
    public function jsonSerialize()
    {
        $request = request();

        return array_merge(parent::jsonSerialize(), [
            'label' => $this->label(),
            'classes' => $this->resolveClasses($request),
            'icon' => $this->resolveIcon(),
            'allowExpansion' => static::$allowExpansion,
            'alwaysExpanded' => static::$alwaysExpanded,
            'link' => $this->resolveLink($request),
            'links' => $this->resolveItems($request),
        ]);
    }
}
