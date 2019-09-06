<?php

namespace CodeByKyle\NovaCustomNavigation\Components;

use App\AccountTransferRule;
use CodeByKyle\NovaCustomNavigation\Components\Items\WebLink;
use CodeByKyle\NovaCustomNavigation\Components\Items\ResourceIndexLink;
use CodeByKyle\NovaCustomNavigation\Components\Items\ResourceLink;
use CodeByKyle\NovaCustomNavigation\Components\Links\EmptyLink;
use Illuminate\Http\Request;
use Laravel\Nova\Element;


abstract class NavigationGroup extends Element
{
    public static $label;

    public static $icon;

    public static $visible = true;

    public $component = 'navigation-group';

    /**
     * The link to go to when the group is clicked
     *
     * @param Request $request
     * @return NavigationLink|null $link
     */
    public function link(Request $request)
    {
        return null;
    }

    /**
     * Get the items available for this group
     * @param Request $request
     * @return array
     */
    public function items(Request $request)
    {
        return [];
    }

    /**
     * Get the CSS classes for the navigation group component
     *
     * @param Request $request
     * @return array
     */
    public function classes(Request $request)
    {
        return [];
    }

    /**
     * Get the label to show in navigation
     * @return string
     */
    public function resolveLabel()
    {
        return static::$label;
    }

    /**
     * Get the icon for this navigation group
     *
     * @return array|string
     * @throws \Throwable
     */
    public function icon()
    {
        return view(static::$icon)->render();
    }

    /**
     * Get if the navigation item is visible
     *
     * @param Request $request
     * @return boolean
     */
    public function visible(Request $request)
    {
        return static::$visible;
    }

    /**
     * Get an icon from a callback for svg support
     *
     * @return array|mixed|string
     * @throws \Throwable
     */
    protected function resolveIcon()
    {
        return view('nova-custom-navigation::icons.default')->render();
    }

    /**
     * Resolve the classes for the navigation item
     *
     * @param Request $request
     * @return array
     */
    protected function resolveClasses(Request $request)
    {
        return $this->classes($request);
    }

    /**
     * Get this navigation items links
     *
     * @param Request $request
     * @return array
     */
    protected function resolveItems(Request $request)
    {
        return collect($this->items($request))
            ->filter(function ($item) use ($request) {
                return $item->authorizedToSee($request);
            })
            ->all();
    }

    /**
     * Resolve the link for this group
     *
     * @param Request $request
     * @return NavigationLink|null $redirect
     */
    protected function resolveLink(Request $request)
    {
        if ($link = $this->link($request)) {
            return $link->label($this->resolveLabel());
        } else {
            return (new EmptyLink())->label($this->resolveLabel());
        }
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
            'label' => $this->resolveLabel(),
            'classes' => $this->resolveClasses($request),
            'icon' => $this->resolveIcon(),
            'link' => $this->resolveLink($request),
            'items' => $this->resolveItems($request),
        ]);
    }
}
