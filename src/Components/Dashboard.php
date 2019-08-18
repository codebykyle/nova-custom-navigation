<?php

namespace CodeByKyle\NovaCustomNavigation\Components;

use CodeByKyle\NovaCustomNavigation\Helpers\NovaRouteBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Element;

abstract class Dashboard extends Element
{

    /**
     * The URL of the Dashboard
     * @var
     */
    public static $uriKey;

    /**
     * The label of the dashboard
     * @var
     */
    public static $label;

    /**
     * The component of the dashboard
     *
     * @var string
     */
    public $component;

    /**
     * Resolve the URL of the Group Dashboard
     *
     * @return string
     */
    public static function uriKey() {
        return static::$uriKey ?? Str::slug(static::label());
    }

    /**
     * Resolve the label for the dashboard
     *
     * @return mixed
     */
    public static function label() {
        return static::$label;
    }

    /**
     * JSON serialize this class with some information about the group and the dashboard
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'uriKey' => $this->uriKey(),
            'label' => static::label(),
        ]);
    }
}
