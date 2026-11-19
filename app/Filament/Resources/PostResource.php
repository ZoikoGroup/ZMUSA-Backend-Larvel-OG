<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use FilamentTiptapEditor\TiptapEditor;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog Management';

    public static function form(Form $form): Form
    {
        return $form->schema([

            /* -------------------------------
                POST DETAILS
            --------------------------------*/
            Forms\Components\Section::make('Post Details')
                ->schema([

                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) =>
                            $set('slug', Str::slug($state))
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\FileUpload::make('cover_image')
                        ->label('Featured Image')
                        ->image()
                        ->directory('blog')
                        ->getUploadedFileNameForStorageUsing(
                            fn ($file, $get) =>
                                $get('slug') . '.' . $file->getClientOriginalExtension()
                        ),

                    Forms\Components\TextInput::make('alt_text')
                        ->label('Image Alt Text')
                        ->placeholder('Describe the image for SEO')
                        ->maxLength(255),

                    TiptapEditor::make('content')
    ->profile('default')
    ->columnSpanFull()
    ->required(),



                    Forms\Components\Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->default('draft')
                        ->required(),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->visible(fn ($get) => $get('status') === 'published'),

                ])
                ->columns(2),

            /* -------------------------------
                SEO SETTINGS
            --------------------------------*/
            Forms\Components\Section::make('SEO Settings')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(255),

                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(3),

                    Forms\Components\TagsInput::make('meta_keywords')
                        ->label('Meta Keywords'),

                    Forms\Components\TextInput::make('og_title')
                        ->label('OG Title')
                        ->maxLength(255),

                    Forms\Components\Textarea::make('og_description')
                        ->label('OG Description')
                        ->rows(3),

                    Forms\Components\FileUpload::make('og_image')
                        ->label('OG Image')
                        ->image()
                        ->directory('blog/og'),
                ])
                ->columns(2)
                ->collapsed(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->square()->size(50),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('published_at')->dateTime(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
