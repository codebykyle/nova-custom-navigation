<?php

namespace CodeByKyle\NovaCustomNavigation\Links;

use Illuminate\Http\Request;
use Laravel\Nova\Element;


class WebLink extends Element implements Redirect
{
    public static $type = 'link';

    public $label;

    public $url;

    public $target;

    public $component = 'web-link';

    /**
     * Link constructor.
     * @param $label
     * @param $url
     * @param string $target
     */
    public function __construct($label, $url, $target='_blank')
    {
        parent::__construct();

        $this->label = $label;
        $this->url = $url;
        $this->target = $target;
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
