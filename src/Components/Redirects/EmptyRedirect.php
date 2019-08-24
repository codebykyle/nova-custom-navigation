<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Redirects;

use CodeByKyle\NovaCustomNavigation\Components\Redirect;
use CodeByKyle\NovaCustomNavigation\Components\RedirectTypes;
use Illuminate\Http\Request;

class EmptyRedirect extends Redirect
{
    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getUrl(Request $request) {
        return null;
    }

    /**
     * Get the label of the navigation item
     *
     * @return string
     */
    public function redirectType()
    {
        return RedirectTypes::$NONE;
    }
}
