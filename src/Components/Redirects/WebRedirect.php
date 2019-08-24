<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Redirects;

use CodeByKyle\NovaCustomNavigation\Components\Redirect;
use CodeByKyle\NovaCustomNavigation\Components\RedirectTypes;
use Illuminate\Http\Request;

class WebRedirect extends Redirect
{
    public $url;

    public $target;

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
    public function redirectType()
    {
        return RedirectTypes::$WEB;
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'routeType' => $this->getRouteType(),
            'target' => $this->target,
        ]);
    }
}
