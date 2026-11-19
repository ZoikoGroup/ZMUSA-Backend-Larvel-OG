<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SwitchSaveResource\Pages;
use App\Models\SwitchSave;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class SwitchSaveResource extends Resource
{
    protected static ?string $model = SwitchSave::class;
    protected static ?string $navigationGroup = 'Switch & Save';
    protected static ?string $navigationLabel = 'Switch Form Submissions';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('fname')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\TextInput::make('msisdn')->required(),
            Forms\Components\TextInput::make('simno')->required(),
            Forms\Components\TextInput::make('plan')->required(),
            Forms\Components\TextInput::make('cat')->required(),
            Forms\Components\TextInput::make('ospno')->required(),
            Forms\Components\TextInput::make('osppass')->required(),
            Forms\Components\TextInput::make('addr1')->required(),
            Forms\Components\TextInput::make('addr2')->required(),
            Forms\Components\TextInput::make('city')->required(),
            Forms\Components\TextInput::make('state')->required(),
            Forms\Components\TextInput::make('zip')->required(),
            Forms\Components\Toggle::make('concent')->label('Consent'),
            Forms\Components\Toggle::make('terms')->label('Terms Accepted'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('fname')->searchable(),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('msisdn'),
            Tables\Columns\TextColumn::make('plan'),
            Tables\Columns\IconColumn::make('concent')->boolean(),
            Tables\Columns\IconColumn::make('terms')->boolean(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y h:i A'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSwitchSaves::route('/'),
            'create' => Pages\CreateSwitchSave::route('/create'),
            'edit'   => Pages\EditSwitchSave::route('/{record}/edit'),
        ];
    }
}
