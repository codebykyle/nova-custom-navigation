<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Items;

use CodeByKyle\NovaCustomNavigation\Components\NavigationItem;
use Illuminate\Http\Request;


class ExternalLink extends NavigationItem
{
    public static $type = 'link';

    public $label;

    public $url;

    public $target;

    public $component = 'external-link';

    /**
     * Link constructor.
     * @param $label
     * @param $url
     * @param string $target
     */
    public function __construct($label, $url, $target='_blank')
    {
        parent::__construct($label);

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
            'target' => $this->target
        ]);
    }
}
