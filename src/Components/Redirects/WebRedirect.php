<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Redirects;

use Illuminate\Http\Request;


class WebRedirect implements Redirect
{
    public $url;

    public $target;

    public static $type = 'link';

    /**
     * Link constructor.
     * @param $label
     * @param $url
     * @param string $target
     */
    public function __construct($url, $target='_blank')
    {
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
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'url' => $this->getUrl(request()),
            'target' => $this->target,
            'linkType' => static::linkType()
        ];
    }
}
