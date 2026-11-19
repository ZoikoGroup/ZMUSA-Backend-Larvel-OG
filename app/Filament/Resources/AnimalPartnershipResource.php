<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnimalPartnershipResource\Pages;
use App\Models\AnimalPartnership;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class AnimalPartnershipResource extends Resource
{
    protected static ?string $model = AnimalPartnership::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Animal Management';
    protected static ?string $navigationLabel = 'Animal Partnerships';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([

                // LEFT COLUMN
                Forms\Components\Section::make('Organization Details')
                    ->schema([
                        Forms\Components\TextInput::make('orgname')
                            ->label('Organization Name')
                            ->required(),
                        Forms\Components\TextInput::make('orgtype')->label('Organization Type'),
                        Forms\Components\TextInput::make('focus')->label('Focus Area'),
                        Forms\Components\TextInput::make('website')->label('Website (Text Only)'),
                        Forms\Components\Textarea::make('mission')->label('Mission Statement')->rows(3),
                        Forms\Components\TextInput::make('street')->label('Street'),
                        Forms\Components\TextInput::make('city')->label('City'),
                        Forms\Components\TextInput::make('state')->label('State'),
                        Forms\Components\TextInput::make('zipcode')->label('Zip Code'),
                    ]),

                // RIGHT COLUMN
                Forms\Components\Section::make('Contact Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Contact Name'),
                        Forms\Components\TextInput::make('role')->label('Role / Position'),
                        Forms\Components\TextInput::make('email')->label('Email'),
                        Forms\Components\TextInput::make('countrycode')->label('Country Code'),
                        Forms\Components\TextInput::make('phone')->label('Phone Number'),
                        Forms\Components\TextInput::make('prefcontact')->label('Preferred Contact Method'),
                    ]),
            ]),

            Forms\Components\Section::make('Participation Options')
                ->description('Choose partnership options applicable to your organization.')
                ->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Toggle::make('discount')->label('Discount'),
                        Forms\Components\Toggle::make('support')->label('Support'),
                        Forms\Components\Toggle::make('campaign')->label('Campaign'),
                        Forms\Components\Toggle::make('donation')->label('Donation'),
                        Forms\Components\Toggle::make('volunteer')->label('Volunteer'),
                        
                    ]),
                    Forms\Components\Textarea::make('other')
                        ->label('Other')
                        ->rows(3),
                    Forms\Components\Textarea::make('supportmission')
                        ->label('Support Mission')
                        ->rows(3),
                ]),

            Forms\Components\Section::make('Additional Information')
                ->schema([
                    Forms\Components\FileUpload::make('statusproof')
                        ->label('Status Proof')
                        ->disk('public')
                        ->directory('statusproofs')
                        ->maxSize(5120)
                        ->enableDownload(),
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Toggle::make('concent')->label('Consent'),
                        Forms\Components\Toggle::make('terms')->label('Terms Accepted'),
                        Forms\Components\Toggle::make('updates')->label('Receive Updates'),
                    ]),
                ]),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('orgname')->label('Organization')->searchable(),
                Tables\Columns\TextColumn::make('orgtype')->label('Type'),
                Tables\Columns\TextColumn::make('focus')->label('Focus'),
                Tables\Columns\TextColumn::make('city')->label('City'),
                Tables\Columns\TextColumn::make('name')->label('Contact Person'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('phone')->label('Phone'),
                Tables\Columns\IconColumn::make('discount')->boolean()->label('Discount'),
                Tables\Columns\IconColumn::make('support')->boolean()->label('Support'),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime('d M Y'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnimalPartnerships::route('/'),
            'create' => Pages\CreateAnimalPartnership::route('/create'),
            'view' => Pages\ViewAnimalPartnership::route('/{record}'),
            'edit' => Pages\EditAnimalPartnership::route('/{record}/edit'),
        ];
    }
}
