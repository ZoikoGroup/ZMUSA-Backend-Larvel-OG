<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentDiscountFormResource\Pages;
use App\Models\StudentDiscountForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class StudentDiscountFormResource extends Resource
{
    protected static ?string $model = StudentDiscountForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Student Discount Forms';
    protected static ?string $navigationGroup = 'Discount Forms';

    /* =====================================================
        FORM (READ ONLY - Admin should not edit submissions)
    ===================================================== */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Student Information')
                ->schema([
                    Forms\Components\TextInput::make('fname')->disabled(),
                    Forms\Components\TextInput::make('email')->disabled(),
                    Forms\Components\TextInput::make('countrycode')->disabled(),
                    Forms\Components\TextInput::make('phone')->disabled(),
                    Forms\Components\TextInput::make('school')->disabled(),
                    Forms\Components\DatePicker::make('yos')->disabled(),
                    Forms\Components\TextInput::make('keepnumber')->disabled(),
                    Forms\Components\TextInput::make('plan')->disabled(),
                    Forms\Components\TextInput::make('cat')->disabled(),
                ])->columns(2),

            Forms\Components\Section::make('Uploaded Proof')
                ->schema([
                    Forms\Components\FileUpload::make('statusproof')
                        ->downloadable()
                        ->disabled()
                        ->directory('student_ids'),
                ]),

            Forms\Components\Section::make('Consents')
                ->schema([
                    Forms\Components\Toggle::make('concent')->disabled(),
                    Forms\Components\Toggle::make('terms')->disabled(),
                    Forms\Components\Toggle::make('email_sent')
                        ->label('Email Sent Status')
                        ->disabled(),
                ]),
        ]);
    }

    /* =====================================================
        TABLE
    ===================================================== */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fname')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\TextColumn::make('school'),

                Tables\Columns\TextColumn::make('plan')
                    ->badge()
                    ->color('info'),

                /* ⭐ EMAIL STATUS BADGE */
                Tables\Columns\IconColumn::make('email_sent')
                    ->label('Email')
                    ->boolean(),

                Tables\Columns\TextColumn::make('statusproof')
                    ->label('Proof')
                    ->url(fn($record) => $record->statusproof 
                        ? asset('storage/' . $record->statusproof) 
                        : null, true)
                    ->formatStateUsing(fn($state) => $state ? 'Download' : 'N/A')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->label('Submitted'),
            ])
            ->defaultSort('id', 'desc')

            ->actions([
                Tables\Actions\ViewAction::make(),

                /* 🔥 RESEND EMAIL BUTTON */
                Tables\Actions\Action::make('resend_email')
                    ->label('Resend Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->visible(fn($record) => !$record->email_sent)
                    ->action(function ($record) {

                        try {
                            $data = $record->toArray();

                            Mail::send('emails.student_discount_admin', ['data' => $data], function ($message) use ($data) {
                                $message->to('support@zoikomobile.com')
                                    ->subject('🎓 Student Discount Application - Resent');
                            });

                            Mail::send('emails.student_discount_user', ['data' => $data], function ($message) use ($data) {
                                $message->to($data['email'])
                                    ->subject('🎓 Your Student Discount Application');
                            });

                            $record->update(['email_sent' => true]);

                            Notification::make()
                                ->title('Emails resent successfully!')
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Email sending failed!')
                                ->danger()
                                ->send();
                        }
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
            'index' => Pages\ListStudentDiscountForms::route('/'),
            'create' => Pages\CreateStudentDiscountForm::route('/create'),
            'edit' => Pages\EditStudentDiscountForm::route('/{record}/edit'),
        ];
    }
}