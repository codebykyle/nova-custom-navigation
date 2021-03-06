<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Links;

use App\Nova\Resource;
use CodeByKyle\NovaCustomNavigation\Components\NavigationLink;
use CodeByKyle\NovaCustomNavigation\Components\Redirects\RouteRedirect;
use Illuminate\Http\Request;
use Laravel\Nova\Metable;
use Laravel\Nova\Nova;


class ResourceLink extends NavigationLink
{
    /**
     * The type of component to use client-side
     *
     * @var string
     */
    public $component = 'resource-link';

    /**
     * The resource to link to
     * @var Resource
     */
    public $resource;

    /**
     * The page to link to, ie: index, detail, edit
     * @var string
     */
    public $page;

    /**
     * The ID of the object to view for a detail or update view
     * @var int|string|null
     */
    public $resourceId;

    /**
     * Act as if this link was redirected from a specific resource type
     * 
     * @var Resource|null
     */
    public $viaResource;

    /**
     * Act as if this link was redirected from a specific resource ID
     * @var int|string
     */
    public $viaResourceId;

    /**
     * Act as if this link was redirected from a specific relationship
     * @var string|null
     */
    public $viaRelationship;

    /**
     * Extra parameters to add to the link
     * @var array 
     */
    public $additionalInformation = [];

    /**
     * ResourceLink constructor.
     * @param Resource $resource
     * @param string|null $label
     */
    public function __construct($resource, $page='index', $label=null)
    {
        parent::__construct($label);
        $this->resource($resource);
        $this->page($page);
    }

    /**
     * Set the resource of the navigation component
     *
     * @param $resource
     * @return $this
     */
    public function resource($resource) {
        $this->resource = $resource;
        return $this;
    }

    /**
     * Get the label of the navigation item
     *
     * @return mixed
     */
    public function resolveLabel()
    {
        if (!empty($label = parent::resolveLabel())) {
            return $label;
        }

        return $this->resource::label();
    }


    /**
     * Set the page to view. index, create, update,
     * @param string $page
     * @return $this
     */
    public function page($page='index') {
        $this->page = $page;
        return $this;
    }

    /**
     * Get the Uri Key of the resource page to visit
     * 
     * @return mixed
     */
    protected function getPage() {
        return $this->page;
    }


    /**
     * Set the resource ID from an ID or a callback
     *
     * @param string|integer $id
     * @return $this
     */
    public function resourceId($id) {
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
    public function setViaFromModel($model, $viaRelationship=null) {
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
    public function additionalInformation(array $array=[])
    {
        $this->additionalInformation = $array;
        return $this;
    }

    protected function getParams() {
        return array_merge($this->additionalInformation, [
            'resourceId' => $this->resourceId,
            'resourceName' => $this->resource::uriKey(),
            'viaRelationship' => $this->viaRelationship,
            'viaResource' => $this->viaResource,
            'viaResourceId' => $this->viaResourceId
        ]);
    }

    /**
     * Get the navigation URL or redirect
     *
     * @param Request $request
     * @return mixed
     */
    public function getRedirect(Request $request) {
         return RouteRedirect::make([
             'name' => $this->getPage(),
             'params' => $this->getParams()
         ]);
    }

    /**
     * Prepare the tool for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize() {
        return array_merge(parent::jsonSerialize(), []);
    }
}
