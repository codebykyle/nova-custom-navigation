<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Redirects;

use Illuminate\Http\Request;


interface Redirect
{
    /**
     * Get the label of the navigation item
     *
     * @return string
     */
    public function linkType();

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getUrl(Request $request);

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize();
}
