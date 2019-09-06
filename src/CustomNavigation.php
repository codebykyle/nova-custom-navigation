<?php

namespace CodeByKyle\NovaCustomNavigation;

use CodeByKyle\NovaCustomNavigation\Components\NavigationGroup;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class CustomNavigation
{
    /**
     * Custom Navigation groups
     *
     * @var array
     */
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

        $navGroupCollection = static::sortNavGroups(
            static::makeGroups($navGroups), $sortBy
        );

        static::navigationGroups($navGroupCollection);
    }

    /**
     * If we are using autoloading, we can apply sorts via class properties.
     * This function sorts by those keys.
     *
     * @param $navGroups
     * @param $sortKeys
     * @return mixed
     */
    public static function sortNavGroups($navGroups, $sortKeys) {
        $navGroupCollection = collect($navGroups);

        foreach ($sortKeys as $sort) {
            $navGroupCollection = $navGroupCollection->sortBy($sort);
        }

        return $navGroupCollection->all();
    }

    /**
     * Turn the name of a class into an instance of that class.
     *
     * @param $navGroups
     * @return \Illuminate\Support\Collection
     */
    public static function makeGroups($navGroups) {
        return collect($navGroups)
            ->transform(function ($navGroup) {
                if ($navGroup instanceof NavigationGroup) {
                    return $navGroup;
                }

                return app()->make($navGroup);
            })
            ->all();
    }

    /**
     * Add to the navigation groups
     *
     * @param array $items
     * @return CustomNavigation
     */
    public static function navigationGroups(array $items) {
        static::$navigationGroups = array_merge(
            static::$navigationGroups,
            static::makeGroups($items)
        );

        return new static;
    }

    /**
     * Override the existing navigation groups by specifying an array
     *
     * @param array $array
     * @return CustomNavigation
     */
    public static function setNavigationGroups(array $array) {
        static::$navigationGroups = self::makeGroups($array);
        return new static();
    }
}