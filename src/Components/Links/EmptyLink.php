<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Links;

use CodeByKyle\NovaCustomNavigation\Components\NavigationLink;
use CodeByKyle\NovaCustomNavigation\Components\Redirects\WebRedirect;
use Illuminate\Http\Request;

class EmptyLink extends NavigationLink
{
    public $component = 'empty-link';

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
     * Get the redirect
     *
     * @param Request $request
     * @return  WebRedirect|null
     */
    public function getRedirect(Request $request)
    {
        return null;
    }
}
