<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Models\Site;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->rules('string|min:3')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('description')
                    ->rules('string|max:255')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->rules('url')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email')
                    ->label('Site outages email')
                    ->rules('email')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email_outage')
                    ->label('Automated site outage email')
                    ->rules('email')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email_resolved')
                    ->label('Automated site outage resolution email')
                    ->rules('email')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(fn ($record) => $record->description)
                    ->badge()
                    ->color(fn ($record) => $record->outages->whereNull('resolved_at')->first() ? 'danger' : 'success')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('site-id')
                    ->label('Site ID')
                    ->action(fn ($record) => $record->advance())
                    ->color('info')
                    ->icon('heroicon-o-code-bracket-square')
                    ->infolist(fn ($record) => [
                        \Filament\Infolists\Components\TextEntry::make('id')
                            ->label('This is the site ID to setup your application:')
                            ->size('xl')
                            ->fontFamily('mono')
                            ->copyable()
                            ->weight('bold')
                            ->color('gray'),
                    ])
                    ->modalSubmitAction(false),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSites::route('/'),
        ];
    }
}
