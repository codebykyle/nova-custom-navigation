<?php


namespace CodeByKyle\NovaCustomNavigation;


use CodeByKyle\NovaCustomNavigation\Components\Dashboard;
use Illuminate\Support\Str;
use Laravel\Nova\Resource;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class CustomNavigation
{
    public static $dashboards = [];

    public static function dashboards(array $dashboards) {
        static::$dashboards = array_merge(static::$dashboards, $dashboards);
        return new static;
    }

    public static function dashboardsIn($directory)
    {
        $namespace = app()->getNamespace();

        $dashboards = [];

        foreach ((new Finder)->in($directory)->files() as $dashboard) {
            $dashboard = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($dashboard->getPathname(), app_path() . DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($dashboard, Dashboard::class) &&
                !(new ReflectionClass($dashboard))->isAbstract()) {
                $dashboards[] = $dashboard;
            }
        }

        static::dashboards(
            collect($dashboards)->sort()->all()
        );
    }

    public static function dashboardForKey($key) {
        $dashboard =  collect(static::$dashboards)->first(function ($value) use ($key) {
            return $value::uriKey() === $key;
        });

        if (empty($dashboard)) {
            return null;
        }

        return static::makeDashboard($dashboard);
    }

    public static function makeDashboard($class) {
        return new $class;
    }
}