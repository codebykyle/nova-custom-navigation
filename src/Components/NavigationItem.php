<?php

namespace CodeByKyle\NovaCustomNavigation\Components;

use Illuminate\Http\Request;
use Laravel\Nova\Element;


abstract class NavigationItem extends Element implements Redirect
{
    public static $type = 'link';

    public $label;

    public $component = 'navigation-item';

    public $visible = true;

    /**
     * Link constructor.
     * @param $label
     * @param $url
     * @param string $target
     */
    public function __construct($label)
    {
        parent::__construct();

        $this->label = $label;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public abstract function getUrl(Request $request);

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

    public function visible() {
        return $this->visible;
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
            'visible' => $this->visible()
        ]);
    }
}
