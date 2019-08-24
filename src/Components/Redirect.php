<?php

namespace CodeByKyle\NovaCustomNavigation\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;


abstract class Redirect implements JsonSerializable
{
    use Macroable;

    /**
     * Get the label of the navigation item
     *
     * @return string
     */
    public function redirectType() {
        return RedirectTypes::$NONE;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public abstract function getUrl(Request $request);

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize() {
        return [
            'route' =>$this->getUrl(request()),
            'redirectType' => static::redirectType(),
        ];
    }
}
