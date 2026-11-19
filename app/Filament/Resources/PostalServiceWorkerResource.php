<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostalServiceWorkerResource\Pages;
use App\Models\PostalServiceWorker;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;

class PostalServiceWorkerResource extends Resource
{
    protected static ?string $model = PostalServiceWorker::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Postal Service Workers';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('data.fname')->label('Full Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('data.email')->label('Email')->sortable(),
                Tables\Columns\TextColumn::make('data.phone')->label('Phone'),
                Tables\Columns\TextColumn::make('data.plan')->label('Plan Type'),
                Tables\Columns\TextColumn::make('data.cat')->label('Category'),
                Tables\Columns\TextColumn::make('created_at')->label('Submitted On')->dateTime('M d, Y H:i'),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist->schema([
            Section::make('Basic Details')
                ->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('data.fname')->label('Full Name'),
                        TextEntry::make('data.email')->label('Email'),
                        TextEntry::make('data.dob')->label('Date of Birth'),
                    ]),
                    Grid::make(3)->schema([
                        TextEntry::make('data.countrycode')->label('Country Code'),
                        TextEntry::make('data.phone')->label('Phone'),
                        TextEntry::make('data.statusproof')->label('Proof File Name'),
                    ]),
                ]),

            Section::make('Selected Plan')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('data.plan')->label('Plan Type'),
                        TextEntry::make('data.cat')->label('Plan Name'),
                    ]),
                ]),

            Section::make('Family / Friends')
                ->schema([
                    RepeatableEntry::make('data.familyFriends')
                        ->schema([
                            Grid::make(2)->schema([
                                TextEntry::make('famname')->label('Full Name'),
                                TextEntry::make('famemail')->label('Email'),
                            ]),
                        ]),
                ]),

            Section::make('Uploaded ID / Proof')
                ->schema([
                    ImageEntry::make('file_path')
                        ->label('Uploaded File Preview')
                        ->height(200)
                        ->visible(fn($record) => $record->file_path)
                        ->disk('public'),

                    // ✅ Wrap Action inside Actions component
                    Actions::make([
                        Action::make('download_file')
                            ->label('Download File')
                            ->button()
                            ->icon('heroicon-o-arrow-down-tray')
                            ->color('primary')
                            ->visible(fn($record) => $record->file_path)
                            ->url(fn($record) => asset('storage/' . $record->file_path), shouldOpenInNewTab: false),
                    ]),
                ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostalServiceWorkers::route('/'),
            'view' => Pages\ViewPostalServiceWorker::route('/{record}'),
        ];
    }
}
