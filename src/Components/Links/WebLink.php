<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Links;

use CodeByKyle\NovaCustomNavigation\Components\NavigationLink;
use CodeByKyle\NovaCustomNavigation\Components\Redirects\WebRedirect;
use Illuminate\Http\Request;

class WebLink extends NavigationLink
{
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
     * @return mixed
     */
    public function label()
    {
        return $this->label;
    }

    /**
     * Get the redirect
     *
     * @param Request $request
     * @return  WebRedirect|null
     */
    public function getRedirect(Request $request)
    {
        return WebRedirect::make($this->url, $this->target);
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), []);
    }
}
