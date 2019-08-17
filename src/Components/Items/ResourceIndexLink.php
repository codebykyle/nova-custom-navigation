<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Items;

use CodeByKyle\NovaCustomNavigation\Components\NavigationItem;
use CodeByKyle\NovaCustomNavigation\Helpers\NovaRouteBuilder;
use Illuminate\Http\Request;


class ResourceIndexLink extends NavigationItem
{
    public static $type = 'route';

    public $component = 'resource-link';

    public $resource;

    /**
     * Link constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource::label());

        $this->resource = $resource;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getUrl(Request $request) {
        return NovaRouteBuilder::makeIndexRoute($this->resource);
    }
}
