<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Links;

use CodeByKyle\NovaCustomNavigation\Components\Redirects\Redirect;
use Illuminate\Http\Request;
use Laravel\Nova\Element;


abstract class NavigationLink extends Element
{
    public $label;

    public $visible = true;

    public $redirectsTo;

    public $component = 'navigation-item';

    /**
     * Link constructor.
     * @param $label
     * @param $url
     * @param string $target
     */
    public function __construct($label)
    {
        parent::__construct();
        $this->label = $label;
    }

    /**
     * Set the label of the navigation item
     * @param $label
     * @return $this
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return Redirect|null
     */
    public abstract function getRedirect(Request $request);

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
     * If this item is visible
     *
     * @return bool
     */
    public function visible() {
        return $this->visible;
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'label' => $this->label(),
            'linkUrl' => $this->getRedirect(request()),
            'visible' => $this->visible()
        ]);
    }
}
