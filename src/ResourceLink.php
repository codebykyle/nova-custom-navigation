<?php

namespace CodeByKyle\NovaCustomNavigation\Links;

use Illuminate\Http\Request;
use Laravel\Nova\Element;


abstract class ResourceLink extends Element implements Redirect
{
    public static $type = 'route';

    public $label;

    public $resource;

    public static $component = 'resource-link';

    public $params;

    /**
     * IndexLink constructor.
     * @param $resource
     * @param string|null $label
     * @param array|null $params
     */
    public function __construct($resource, $label=null, $params=null) {
        parent::__construct();

        $this->resource = $resource;
        $this->label = $label;
        $this->params = $params;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getUrl(Request $request) {
        return [

        ];
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
     * Get the label of the navigation item
     *
     * @return mixed
     */
    public function label()
    {
        return $this->label;
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'label' => $this->label(),
            'linkType' => $this->linkType(),
            'linkUrl' => $this->getUrl(request()),
        ]);
    }

    public function component()
    {
        return static::$component;
    }
}
