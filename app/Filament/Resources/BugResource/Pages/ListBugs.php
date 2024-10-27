<?php

namespace App\Filament\Resources\BugResource\Pages;

use App\Filament\Resources\BugResource;
use Filament\Resources\Pages\ListRecords;

class ListBugs extends ListRecords
{
    protected static string $resource = BugResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
