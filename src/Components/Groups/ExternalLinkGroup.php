<?php

namespace CodeByKyle\NovaCustomNavigation\Groups;

use CodeByKyle\NovaCustomNavigation\Components\NavigationGroupRedirect;
use Illuminate\Http\Request;

abstract class ExternalLinkGroup  extends NavigationGroupRedirect
{
     public static $linkType = 'link';

     public $component = 'web-link-group';

     public $target = '_blank';

    /**
     * Get the URL when the user clicks the group header
     * @param Request $request
     * @return string
     */
    public abstract function getUrl(Request $request);

    /**
     * Type of link to display
     *
     * @return string
     */
    public function linkType()
    {
        return static::$linkType;
    }

    /**
     * Open in the current window or a new one
     *
     * @return mixed
     */
    public function target() {
        return $this->target();
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
             'linkType' => $this->linkType(),
             'linkUrl' => $this->getUrl($request),
             'target' => $this->target(),
         ]);
     }
 }
