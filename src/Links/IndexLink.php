<?php

namespace CodeByKyle\NovaCustomNavigation\Links;

use Illuminate\Http\Request;
use Laravel\Nova\Element;


class IndexLink extends Element implements Redirect
{
    public static $type = 'route';

    public $label;

    public $url;

    public $target;

    public $resource;

    /**
     * IndexLink constructor.
     * @param $resource
     * @param null $label
     */
    public function __construct($resource, $label=null)
    {
        parent::__construct();
        $this->resource = $resource;
        $this->label = $label;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getUrl(Request $request) {
        return $this->url;
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
            'target' => $this->target
        ]);
    }
}
