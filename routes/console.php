<?php

use App\Mail\BugsOccurred;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Artisan::command('check:sites', function () {
    $sites = \App\Models\Site::limit(10)
        ->orderBy('checked_at')
        ->get();

    foreach ($sites as $site) {
        \App\Jobs\SiteCheck::dispatch($site);

        $site->checked_at = now();
        $site->save();
    }

    $this->info('🚀 Sites checked successfully!');
})->everyMinute();

Artisan::command('check:bugs', function () {
    $bugs = \App\Models\Bug::where('logged_at', '>=', now()->subMinutes(5))
        ->orderBy('logged_at', 'desc')
        ->get();

    if ($bugs->count() > 0) {
        Mail::to(\App\Models\User::first()->email)
            ->send(new BugsOccurred($bugs));
    }

    $this->info('🚀 Bugs checked successfully!');
})->everyFiveMinutes();

Artisan::command('check:clear', function () {
    $bugs = \App\Models\Bug::where('created_at', '<', now()->subYear(1))->get();
    $bugs->each->delete();

    $outages = \App\Models\Outage::where('created_at', '<', now()->subYear(1))->get();
    $outages->each->delete();

    $this->info('✅ Bugs and Outages cleaned successfully!');
})->dailyAt('04:00');
