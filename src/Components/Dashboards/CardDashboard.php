<?php

namespace CodeByKyle\NovaCustomNavigation\Components\Dashboards;

use CodeByKyle\NovaCustomNavigation\Components\Dashboard;
use Illuminate\Http\Request;
use Laravel\Nova\ResolvesCards;


abstract class CardDashboard extends Dashboard
{
    use ResolvesCards;

    /**
     * Load the card component
     *
     * @var string
     */
    public $component = 'card-dashboard';

    /**
     * Cards to display on the group dashboard
     *
     * @param Request $request
     * @return array
     */
    public abstract function cards(Request $request);


    public function resolveCards(Request $request) {
        return collect($this->cards($request))
            ->filter
            ->authorize($request)
            ->values();
    }

    /**
     * JSON serialize this class with some information about the group and the dashboard
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'uriKey' => $this->uriKey(),
            'cards' => $this->resolveCards(request())
        ]);
    }
}
