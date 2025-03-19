<?php

namespace App\Services;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\IconColumn;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;

class AboutService
{
    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('標題')
                ->required()
                ->columnSpanFull()
                ->maxLength(255),

            QuillEditor::make('content')
                ->label('內容')
                ->required()
                ->columnSpanFull(),

            TextInput::make('sort')
                ->label('排序')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('是否啟用')
                ->label('啟用')
                ->inline(false)
                ->default(true),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label('標題')
                ->searchable()
                ->sortable(),

            TextColumn::make('sort')
                ->label('排序')
                ->sortable(),

            ToggleColumn::make('is_active')
                ->label('是否啟用'),

            TextColumn::make('created_at')
                ->label('建立時間')
                ->dateTime('Y-m-d H:i:s')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
                ->label('更新時間')
                ->dateTime('Y-m-d H:i:s')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('是否啟用'),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }
}
