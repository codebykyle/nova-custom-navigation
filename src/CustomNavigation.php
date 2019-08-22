<?php

namespace CodeByKyle\NovaCustomNavigation;

use CodeByKyle\NovaCustomNavigation\Components;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class CustomNavigation
{
    public static $navigationGroups = [];

    /**
     * Register one or more navigation groups
     *
     * @param NavigationGroup ...$groups
     * @return CustomNavigation
     */
    public static function registerNavigationGroups(NavigationGroup ...$groups) {
        return static::navigationGroups($groups);
    }

    /**
     * Automatically register the navigation items in the navigation directory
     *
     * @param $directory
     * @param array $sortBy
     * @throws \ReflectionException
     */
    public static function navigationGroupsIn($directory, $sortBy=['label', 'order']) {
        $namespace = app()->getNamespace();
        $navGroups = [];

        foreach ((new Finder)->in($directory)->files() as $navGroup) {
            $navGroup = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($navGroup->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($navGroup, NavigationGroup::class) && !(new \ReflectionClass($navGroup))->isAbstract()) {
                $navGroups[] = $navGroup;
            }
        }

        $navGroupCollection = collect($navGroups)->transform(function ($navGroup) {
            if ($navGroup instanceof NavigationGroup) {
                return $navGroup;
            }

            return app()->make($navGroup);
        });

        foreach ($sortBy as $sort) {
            $navGroupCollection = $navGroupCollection->sortBy($sort);
        }

        static::navigationGroups($navGroupCollection->all());
    }

    /**
     * Add to the navigation groups
     *
     * @param array $items
     * @return CustomNavigation
     */
    public static function navigationGroups(array $items) {
        static::$navigationGroups = array_merge(static::$navigationGroups, $items);
        return new static;
    }
}