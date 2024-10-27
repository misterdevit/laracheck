<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutageResource\Pages;
use App\Models\Outage;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class OutageResource extends Resource
{
    protected static ?string $model = Outage::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt-slash';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('site_id')
                    ->required(),
                Forms\Components\DateTimePicker::make('occurred_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('resolved_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('site.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color('gray'),
                \Filament\Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->boolean(),
                \Filament\Tables\Columns\TextColumn::make('occurred_at')
                    ->since()
                    ->sortable()
                    ->description(fn ($state) => Carbon::parse($state)->format('M d, Y - H:i:s')),
                \Filament\Tables\Columns\TextColumn::make('duration')
                    ->sortable()
                    ->weight(fn ($record) => $record->resolved_at ? 'normal' : 'bold')
                    ->color(fn ($record) => $record->resolved_at ? 'default' : 'danger')
                    ->description(fn ($record) => ($record->resolved_at) ? 'Resolved at: '.Carbon::parse($record->resolved_at)->format('M d, Y - H:i:s') : null),
            ])
            ->defaultSort('occurred_at', 'desc')
            ->filters([
                \Filament\Tables\Filters\Filter::make('in_outage')
                    ->toggle()
                    ->query(function ($query, $livewire) {
                        if ($livewire->tableFilters['in_outage']) {
                            $query->whereNull('resolved_at');
                        }

                        return $query;
                    }),
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
                \Filament\Tables\Filters\Filter::make('occurred_at')
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
                        if ($livewire->tableFilters['occurred_at']['from']) {
                            $query->where('occurred_at', '>=', $livewire->tableFilters['occurred_at']['from']);
                        }

                        if ($livewire->tableFilters['occurred_at']['to']) {
                            $query->where('occurred_at', '<=', $livewire->tableFilters['occurred_at']['to']);
                        }

                        return $query;
                    }),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutages::route('/'),
        ];
    }
}
