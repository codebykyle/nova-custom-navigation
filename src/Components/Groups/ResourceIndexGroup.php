<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Groups;

use CodeByKyle\NovaCustomNavigation\Components\NavigationGroupRedirect;
use CodeByKyle\NovaCustomNavigation\Helpers\NovaRouteBuilder;
use Illuminate\Http\Request;

abstract class ResourceIndexGroup extends NavigationGroupRedirect
{
    public static $linkType = 'route';

    public static $resource;

    public function getResource() {
        return static::$resource;
    }

    public function getUrl(Request $request)
    {
        return NovaRouteBuilder::makeIndexRoute($this->getResource());
    }
}
