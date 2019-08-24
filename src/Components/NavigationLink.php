<?php

namespace CodeByKyle\NovaCustomNavigation\Components;

use CodeByKyle\NovaCustomNavigation\Components\Links\DashboardLink;
use CodeByKyle\NovaCustomNavigation\Components\Redirects\Redirect;
use Illuminate\Http\Request;
use Laravel\Nova\Element;


abstract class NavigationLink extends Element
{
    public $label;

    public $visible = true;

    public $component = 'navigation-item';

    public $additionalInformation = [];

    /**
     * Link constructor.
     * @param $label
     * @param $url
     * @param string $target
     */
    public function __construct($label=null)
    {
        parent::__construct();
        $this->label = $label;
    }


    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return Redirect|null
     */
    public abstract function getRedirect(Request $request);

    /**
     * Set the label of the navigation item
     * @param $label
     * @return $this
     */
    public function label($label) {
        $this->label = $label;
        return $this;
    }

    /**
     * If this item is visible
     *
     * @param Request $request
     * @return bool
     */
    public function resolveVisible(Request $request) {
        return $this->visible;
    }

    /**
     * Get the label of the navigation item
     *
     * @param Request $request
     * @return mixed
     */
    public function resolveLabel()
    {
        return $this->label;
    }

    /**
     * Set any additional information to merge into the link
     *
     * @param array $array
     * @return $this
     */
    public function additionalInformation(array $array=[])
    {
        $this->additionalInformation = $array;
        return $this;
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $request = request();

        return array_merge(parent::jsonSerialize(), [
            'label' => $this->resolveLabel(),
            'link' => $this->getRedirect($request),
            'visible' => $this->resolveVisible($request),
            'meta' => $this->additionalInformation
        ]);
    }
}
