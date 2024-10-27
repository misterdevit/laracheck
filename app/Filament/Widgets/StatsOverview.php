<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Recent Bugs', \App\Models\Bug::where('logged_at', '>', \Illuminate\Support\Facades\Date::now()->subDay(3))->count())
                ->description('Errors occurred in the last 3 Days')
                ->descriptionIcon('heroicon-m-bug-ant'),
            Stat::make('Recent Outages', \App\Models\Outage::where('occurred_at', '>', \Illuminate\Support\Facades\Date::now()->subDay(3))->count())
                ->description('Outages occurred in the last 3 Days')
                ->descriptionIcon('heroicon-m-bolt-slash'),
            Stat::make('Current Outages', \App\Models\Outage::whereNull('resolved_at')->count())
                ->description('Sites currently down')
                ->descriptionIcon('heroicon-m-bolt-slash'),
        ];
    }
}
