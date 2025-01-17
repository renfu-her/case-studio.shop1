<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = '網站管理';
    protected static ?string $navigationLabel = '活動訊息';
    protected static ?string $modelLabel = '活動訊息';
    protected static ?string $pluralModelLabel = '活動訊息';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('標題')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('image')
                    ->label('活動圖片')
                    ->image()
                    ->imageEditor()
                    ->directory('events')
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('1200')
                    ->imageResizeTargetHeight('630')
                    ->saveUploadedFileUsing(function ($file) {
                        $manager = new ImageManager(new Driver());
                        $image = $manager->read($file);

                        $image->cover(1200, 630);
                        $filename = Str::uuid()->toString() . '.webp';

                        if (!file_exists(storage_path('app/public/events'))) {
                            mkdir(storage_path('app/public/events'), 0755, true);
                        }

                        $image->toWebp(80)->save(storage_path('app/public/events/' . $filename));

                        return 'events/' . $filename;
                    }),

                QuillEditor::make('content')
                    ->label('活動內容')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('start_date')
                    ->label('開始日期')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_date')
                    ->label('結束日期')
                    ->required()
                    ->after('start_date'),

                Forms\Components\TextInput::make('sort')
                    ->label('排序')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_active')
                    ->label('啟用狀態')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('活動圖片'),

                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('開始日期')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('結束日期')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort')
                    ->label('排序')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用狀態')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('啟用狀態'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('編輯'),
                Tables\Actions\DeleteAction::make()->label('刪除'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('刪除所選'),
                ]),
            ])
            ->defaultSort('sort', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
