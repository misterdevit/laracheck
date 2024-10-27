<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BugResource\Pages;
use App\Models\Bug;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class BugResource extends Resource
{
    protected static ?string $model = Bug::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-bug-ant';

    protected static ?string $modelLabel = 'Bugs';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                \Filament\Infolists\Components\Section::make()
                    ->schema([
                        \Filament\Infolists\Components\Fieldset::make('Exception Information')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('id')
                                    ->prefix('#')
                                    ->size('xs')
                                    ->fontFamily('mono')
                                    ->copyable(),
                                \Filament\Infolists\Components\TextEntry::make('logged_at')
                                    ->size('xs')
                                    ->fontFamily('mono')
                                    ->date('M d, Y - H:i:s'),
                                \Filament\Infolists\Components\TextEntry::make('code')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        '500', 500 => 'danger',
                                        default => 'info',
                                    }),
                                \Filament\Infolists\Components\TextEntry::make('message')
                                    ->size('xs')
                                    ->fontFamily('mono')
                                    ->copyable(),
                                \Filament\Infolists\Components\TextEntry::make('method')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'GET' => 'success',
                                        'POST' => 'warning',
                                        'PUT' => 'info',
                                        'PATCH' => 'primary',
                                        'DELETE' => 'danger',
                                        default => 'gray',
                                    }),
                                \Filament\Infolists\Components\TextEntry::make('path')
                                    ->size('xs')
                                    ->fontFamily('mono')
                                    ->copyable()
                                    ->tooltip(function (\Filament\Infolists\Components\TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        return $state;
                                    })
                                    ->limit(50),
                                \Filament\Infolists\Components\TextEntry::make('file')
                                    ->size('xs')
                                    ->fontFamily('mono')
                                    ->copyable()
                                    ->tooltip(function (\Filament\Infolists\Components\TextEntry $component): ?string {
                                        $state = $component->getState();

                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                            return null;
                                        }

                                        return $state;
                                    })
                                    ->limit(50),
                                \Filament\Infolists\Components\TextEntry::make('line')
                                    ->size('xs')
                                    ->fontFamily('mono'),
                            ]),
                        \Filament\Infolists\Components\Fieldset::make('Environment Information')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('site.name')
                                    ->label('Site Name')
                                    ->badge()
                                    ->color('gray')
                                    ->tooltip(function (\Filament\Infolists\Components\TextEntry $component): ?string {
                                        $record = $component->getRecord();

                                        $info = \App\Models\Site::find($record->site_id);

                                        return $info->description.' ('.$info->url.')';
                                    }),
                                \Filament\Infolists\Components\TextEntry::make('env')
                                    ->label('Site Environment')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'local' => 'info',
                                        'staging' => 'warning',
                                        'production' => 'danger',
                                        default => 'gray',
                                    }),
                                \Filament\Infolists\Components\TextEntry::make('url')
                                    ->columnSpanFull(),
                            ]),
                        \Filament\Infolists\Components\Fieldset::make('User Information')
                            ->columns(2)
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('ip')
                                    ->fontFamily('mono')
                                    ->size('xs')
                                    ->weight('bold')
                                    ->url(fn ($record) => 'https://whatismyipaddress.com/ip/'.$record->ip, true)
                                    ->color('gray'),
                                \Filament\Infolists\Components\TextEntry::make('user')
                                    ->label('User ID (if logged in)')
                                    ->prefix('#')
                                    ->size('xs')
                                    ->fontFamily('mono')
                                    ->copyable(),
                                \Filament\Infolists\Components\TextEntry::make('user_agent')
                                    ->fontFamily('mono')
                                    ->size('xs')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')
                    ->prefix('#')
                    ->size('xs')
                    ->fontFamily('mono')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('logged_at')
                    ->dateTime()
                    ->since()
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('site.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color('gray'),
                \Filament\Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        '500', 500 => 'danger',
                        default => 'info',
                    }),
                \Filament\Tables\Columns\TextColumn::make('path')
                    ->description(fn ($record) => $record->method, 'above')
                    ->limit(38)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('file')
                    ->description(fn ($record) => 'Line: '.$record->line.' in file:', 'above')
                    ->limit(38)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('message')
                    ->size('xs')
                    ->fontFamily('mono')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('user')
                    ->searchable()
                    ->sortable()
                    ->prefix('#')
                    ->size('xs')
                    ->fontFamily('mono')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('ip')
                    ->searchable()
                    ->sortable()
                    ->size('xs')
                    ->fontFamily('mono')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('user_agent')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->defaultSort('logged_at', 'desc')
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('sites')
                    ->native(false)
                    ->options(fn () => \App\Models\Site::pluck('name', 'id')->toArray())
                    ->multiple()
                    ->query(function ($query, $livewire) {
                        if ($livewire->tableFilters['sites']['values']) {
                            foreach ($livewire->tableFilters['sites']['values'] as $site) {
                                $query->where('site_id', $site);
                            }
                        }

                        return $query;
                    }),
                \Filament\Tables\Filters\Filter::make('logged_at')
                    ->indicateUsing(fn ($data) => ($data['from'] || $data['to']) ? 'Date range: '.(($data['from']) ? 'from '.\Carbon\Carbon::parse($data['from'])->format('d/m/Y').' ' : '').(($data['to']) ? 'to '.\Carbon\Carbon::parse($data['to'])->format('d/m/Y') : '') : null)
                    ->form([
                        \Filament\Forms\Components\Fieldset::make('Date Range')
                            ->columns(1)
                            ->schema([
                                \Filament\Forms\Components\DatePicker::make('from'),
                                \Filament\Forms\Components\DatePicker::make('to'),
                            ]),
                    ])
                    ->query(function ($query, $livewire) {
                        if ($livewire->tableFilters['logged_at']['from']) {
                            $query->where('logged_at', '>=', $livewire->tableFilters['logged_at']['from']);
                        }

                        if ($livewire->tableFilters['logged_at']['to']) {
                            $query->where('logged_at', '<=', $livewire->tableFilters['logged_at']['to']);
                        }

                        return $query;
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBugs::route('/'),
            'view' => Pages\ViewBug::route('/{record}'),
        ];
    }
}
