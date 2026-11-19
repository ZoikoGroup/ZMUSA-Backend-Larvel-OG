<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MilitaryDiscountFormResource\Pages;
use App\Models\MilitaryDiscountForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class MilitaryDiscountFormResource extends Resource
{
    protected static ?string $model = MilitaryDiscountForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Military Veterans Form';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Applicant Information')
                ->schema([
                    Forms\Components\TextInput::make('fname')->required(),
                    Forms\Components\TextInput::make('email')->email()->required(),
                    Forms\Components\TextInput::make('countrycode'),
                    Forms\Components\TextInput::make('phone')->required(),

                    Forms\Components\FileUpload::make('statusproof')
                        ->directory('military_proofs')
                        ->downloadable()
                        ->previewable(),

                    Forms\Components\TextInput::make('plan'),
                    Forms\Components\TextInput::make('cat'),

                    Forms\Components\Toggle::make('concent')->required(),
                    Forms\Components\Toggle::make('terms')->required(),

                    Forms\Components\Toggle::make('email_sent')
                        ->label('Email Sent')
                        ->disabled()
                        ->helperText('Automatically updated after email sending'),
                ])->columns(2),

            Forms\Components\Section::make('Family Members')
                ->schema([
                    Forms\Components\Repeater::make('family')
                        ->schema([
                            Forms\Components\TextInput::make('famname'),
                            Forms\Components\TextInput::make('famemail')->email(),
                            Forms\Components\TextInput::make('famphone'),
                            Forms\Components\TextInput::make('famrelation'),
                        ])
                        ->columns(2)
                        ->grid(2),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('fname')
                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\BadgeColumn::make('email_sent')
                    ->label('Email Status')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ])
                    ->formatStateUsing(fn ($state) => $state ? 'Sent' : 'Not Sent'),

                Tables\Columns\IconColumn::make('concent')->boolean(),
                Tables\Columns\IconColumn::make('terms')->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')

            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                // ⭐ RESEND EMAIL BUTTON
                Tables\Actions\Action::make('resendEmail')
                    ->label('Resend Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->visible(fn ($record) => !$record->email_sent)
                    ->action(function ($record) {

                        try {
                            // Applicant email
                            Mail::raw(
                                "Dear {$record->fname},\n\nThank you for submitting your Military & Veterans Discount form.\nWe will review your details and get back to you soon.\n\n- Zoiko Mobile Team",
                                function ($message) use ($record) {
                                    $message->to($record->email)
                                        ->subject('Your Military Discount Form Submission');
                                }
                            );

                            // Admin email
                            Mail::raw(
                                "New Military & Veterans Discount Application:\n\nName: {$record->fname}\nEmail: {$record->email}\nPhone: {$record->phone}",
                                function ($message) {
                                    $message->to(config('mail.admin_address', 'support@zoikomobile.com'))
                                        ->subject('New Military Discount Form Submission');
                                }
                            );

                            $record->update(['email_sent' => true]);

                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Email failed!')
                                ->danger()
                                ->send();
                            return;
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Email sent successfully!')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMilitaryDiscountForms::route('/'),
            'create' => Pages\CreateMilitaryDiscountForm::route('/create'),
            'edit' => Pages\EditMilitaryDiscountForm::route('/{record}/edit'),
        ];
    }
}