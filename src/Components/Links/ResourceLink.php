<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Links;

use CodeByKyle\NovaCustomNavigation\Components\Redirects\RouteRedirect;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;


class ResourceLink extends NavigationLink
{
    public static $type = 'route';

    public $component = 'resource-link';

    public $route;

    public $resource;

    public $page;

    public $resourceId;

    public $viaResource;

    public $viaResourceId;

    public $viaRelationship;

    public $extraParams = [];

    /**
     * Set the page to view. index, create, update,
     * @param string $page
     * @return $this
     */
    public function setPage($page='index') {
        $this->page = $page;
        return $this;
    }

    /**
     * Set the resource ID from an ID or a callback
     *
     * @param string|integer $id
     * @return $this
     */
    public function setResourceID($id) {
        $this->resourceId = $id;
        return $this;
    }

    /**
     * Set the 'Via' information in order to make it appear this came from a relationship
     *
     * @param $viaResource
     * @param string|null $viaResourceId
     * @param null $viaRelationship
     * @return $this
     */
    public function setVia($viaResource, $viaResourceId=null, $viaRelationship=null) {
        $this->viaResource = $viaResource;
        $this->viaResourceId = $viaResourceId;
        $this->viaRelationship = $viaRelationship;
        return $this;
    }

    /**
     * Set the Via information from an instance of a model
     * @param $model
     * @param string $viaRelationship
     * @return $this
     */
    public function setViaModel($model, $viaRelationship=null) {
        $this->viaResource = Nova::resourceForModel($model);
        $this->viaResourceId = $model->getQualifiedKeyName();
        $this->viaRelationship = $viaRelationship;
        return $this;
    }

    /**
     * Set any additional information to merge into the link
     *
     * @param array $array
     * @return $this
     */
    public function setExtraParameters(array $array=[])
    {
        $this->extraParams = $array;
        return $this;
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getRedirect(Request $request) {
        $navigationKeys = [
            'name' => $this->page,
            'params' => array_merge($this->extraParams, [
                'resourceId' => $this->resourceId,
                'resourceName' => !empty($this->resource) ? $this->resource::uriKey() : null,
                'viaRelationship' => $this->viaRelationship,
                'viaResource' => $this->viaResource,
                'viaResourceId' => $this->viaResourceId
            ])
        ];

         return RouteRedirect::make($navigationKeys);
    }

    /**
     * Get the label of the navigation item
     *
     * @return string
     */
    public function linkType()
    {
        return static::$type;
    }
}
