<?php

namespace CodeByKyle\NovaCustomNavigation\Components;

use CodeByKyle\NovaCustomNavigation\Links\Helpers\NovaRouteBuilder;
use Illuminate\Http\Request;

abstract class NavigationGroupRedirect extends NavigationGroup implements Redirect
{
    public static $linkType = 'route';

    public $component = 'route-group';

    public static $resource;

    public function linkType()
    {
        return static::$linkType;
    }

    public function getResource() {
        return static::$resource;
    }

    public abstract function getUrl(Request $request);

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'linkType' => $this->linkType(),
            'linkUrl' => $this->getUrl(request()),
        ]);
    }
}
