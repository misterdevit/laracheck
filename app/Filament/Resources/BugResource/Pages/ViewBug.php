<?php

namespace App\Filament\Resources\BugResource\Pages;

use App\Filament\Resources\BugResource;
use Filament\Resources\Pages\ViewRecord;

class ViewBug extends ViewRecord
{
    protected static string $resource = BugResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
