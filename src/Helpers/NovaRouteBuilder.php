<?php

namespace CodeByKyle\NovaCustomNavigation\Links\Helpers;

use Laravel\Nova\Resource;

class NovaRouteBuilder
{
    public static function makeDashboardRoute($dashboardName)
    {
        return static::makeRoute('category-dashboard', [
            'categoryName' => $dashboardName
        ]);
    }

    protected static function makeIndexRoute($namespace)
    {
        return static::makeRoute('index', [
            'resourceName' => static::normalizeResourceName($namespace)
        ]);
    }

    protected static function makeDetailRoute($namespace, $id)
    {
        return static::makeRoute('detail', [
            'resourceName' => static::normalizeResourceName($namespace),
            'resourceId' => $id,
        ]);
    }

    protected static function makeCreateRoute($namespace)
    {
        return static::makeRoute('create', [
            'resourceName' => static::normalizeResourceName($namespace)
        ]);
    }

    protected static function makeEditRoute($namespace, $id)
    {
        return static::makeRoute('edit', [
            'resourceName' => static::normalizeResourceName($namespace),
            'resourceId' => $id,
        ]);
    }

    protected static function makeLensRoute($namespace, $key)
    {
        return static::makeRoute('lens', [
            'resourceName' => static::normalizeResourceName($namespace),
            'lens' => $key
        ]);
    }

    public static function makeFilterString(array $filters)
    {
        return base64_encode(json_encode(collect($filters)->map(function ($value, $key) {
            return [
                'class' => $key,
                'value' => $value
            ];
        })->values()));
    }

    protected static function makeRoute($name, $params, $filters=null) {
        return [
            'name' => $name,
            'params' => $params,
            'query' => [],
        ];
    }

    /**
     * @param  string $namespace
     * @return string
     */
    protected static function normalizeResourceName($namespace)
    {
        return class_exists($namespace) && is_subclass_of($namespace, Resource::class)
            ? $namespace::uriKey() : $namespace;
    }
}