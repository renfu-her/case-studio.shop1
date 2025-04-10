<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;
use App\Services\Service;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
use FilamentTiptapEditor\TiptapEditor;
use Awcodes\FilamentTiptapEditor\TiptapEditor as AwcodesTiptapEditor;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BaseService extends Service
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 創建基礎的文本輸入欄位
     */
    protected function createTextInput(
        string $name,
        string $label,
        bool $required = false,
        ?int $maxLength = null,
        ?string $placeholder = null
    ): Forms\Components\TextInput {
        return Forms\Components\TextInput::make($name)
            ->label($label)
            ->required($required)
            ->maxLength($maxLength)
            ->placeholder($placeholder);
    }

    /**
     * 創建基礎的數字輸入欄位
     */
    protected function createNumberInput(
        string $name,
        string $label,
        bool $required = false,
        ?int $minValue = null,
        ?int $maxValue = null,
        ?string $prefix = null,
        ?string $suffix = null,
        ?bool $default = false
    ): Forms\Components\TextInput {
        return Forms\Components\TextInput::make($name)
            ->label($label)
            ->required($required)
            ->numeric()
            ->minValue($minValue)
            ->maxValue($maxValue)
            ->prefix($prefix)
            ->suffix($suffix)
            ->default($default);
    }

    /**
     * 創建基礎的文本列
     */
    protected function createTextColumn(
        string $name,
        string $label,
        bool $searchable = false,
        bool $sortable = false,
        ?callable $formatStateUsing = null
    ): Tables\Columns\TextColumn {
        $column = Tables\Columns\TextColumn::make($name)
            ->label($label)
            ->searchable($searchable)
            ->sortable($sortable);

        if ($formatStateUsing) {
            $column->formatStateUsing($formatStateUsing);
        }

        return $column;
    }

    /**
     * 創建基礎的金額列
     */
    protected function createMoneyColumn(
        string $name,
        string $label,
        string $currency = 'TWD',
        bool $sortable = true
    ): Tables\Columns\TextColumn {
        return Tables\Columns\TextColumn::make($name)
            ->label($label)
            ->money($currency)
            ->sortable($sortable);
    }

    /**
     * 創建基礎的狀態切換
     */
    protected function createToggle(
        string $name,
        string $label,
        bool $default = true
    ): Forms\Components\Toggle {
        return Forms\Components\Toggle::make($name)
            ->label($label)
            ->default($default);
    }

    /**
     * 創建基礎的狀態圖標列
     */
    protected function createBooleanColumn(
        string $name,
        string $label,
        bool $sortable = true
    ): Tables\Columns\ToggleColumn {
        return Tables\Columns\ToggleColumn::make($name)
            ->label($label)
            ->sortable($sortable)
            ->alignCenter();
    }

    /**
     * 創建基礎的選擇欄位
     */
    protected function createSelect(
        string $name,
        string $label,
        array $options,
        bool $required = false,
        bool $searchable = false
    ): Forms\Components\Select {
        return Forms\Components\Select::make($name)
            ->label($label)
            ->options($options)
            ->required($required)
            ->searchable($searchable);
    }

    /**
     * 創建基礎的日期時間欄位
     */
    protected function createDateTimePicker(
        string $name,
        string $label,
        bool $required = false
    ): Forms\Components\DateTimePicker {
        return Forms\Components\DateTimePicker::make($name)
            ->label($label)
            ->required($required)
            ->displayFormat('Y-m-d H:i:s');
    }

    /**
     * 創建基礎的日期時間列
     */
    protected function createDateTimeColumn(
        string $name,
        string $label,
        bool $sortable = true
    ): Tables\Columns\TextColumn {
        return Tables\Columns\TextColumn::make($name)
            ->label($label)
            ->dateTime('Y-m-d H:i:s')
            ->sortable($sortable);
    }

    /**
     * 創建基礎的圖片上傳欄位
     */
    protected function createImageUpload(
        string $name,
        string $label,
        string $directory,
        ?string $placeholder = null,
        bool $columnSpanFull = true,
        array $acceptedFileTypes = ['image/jpeg', 'image/jpg', 'image/png'],
        ?callable $saveUploadedFileUsing = null,
        bool $required = false

    ): Forms\Components\FileUpload {
        $upload = Forms\Components\FileUpload::make($name)
            ->label($label)
            ->image()
            ->imageEditor()
            ->directory($directory)
            ->acceptedFileTypes($acceptedFileTypes);

        if ($placeholder) {
            $upload->placeholder($placeholder);
        }

        if ($required == true) {
            $upload->required();
        }

        if ($columnSpanFull) {
            $upload->columnSpanFull();
        }

        if ($saveUploadedFileUsing) {
            $upload->saveUploadedFileUsing($saveUploadedFileUsing);
        }

        return $upload;
    }

    /**
     * 創建基礎的圖片列
     */
    protected function createImageColumn(
        string $name,
        string $label
    ): Tables\Columns\ImageColumn {
        return Tables\Columns\ImageColumn::make($name)
            ->label($label);
    }

    /**
     * 創建基礎的富文本編輯器
     */
    protected function createTinyMceEditor(
        string $name,
        string $label,
        ?string $placeholder = null,
        bool $columnSpanFull = true
    ): QuillEditor {
        $editor = QuillEditor::make($name)
            ->label($label)
            ->placeholder($placeholder);

        if ($columnSpanFull) {
            $editor->columnSpanFull();
        }

        return $editor;
    }

    /**
     * 創建基礎的關聯選擇欄位
     */
    protected function createRelationSelect(
        string $name,
        string $label,
        string $relationship,
        string $titleColumn,
        bool $required = false,
        bool $searchable = false,
        bool $preload = false,
        ?callable $optionsUsing = null,
        ?array $createOptionForm = null
    ): Forms\Components\Select {
        $select = Forms\Components\Select::make($name)
            ->relationship($relationship, $titleColumn)
            ->label($label)
            ->required($required)
            ->searchable($searchable)
            ->preload($preload);

        if ($optionsUsing) {
            $select->options($optionsUsing);
        }

        if ($createOptionForm) {
            $select->createOptionForm($createOptionForm);
        }

        return $select;
    }

    /**
     * 創建基礎的 CKEditor 編輯器
     */
    protected function createCkeditor(
        string $name,
        string $label,
        bool $required = false,
        bool $columnSpanFull = true,
        ?string $placeholder = null,
        string $profile = 'default'
    ): TiptapEditor {
        $editor = TiptapEditor::make($name)
            ->label($label)
            ->required($required)
            ->profile($profile);

        if ($placeholder) {
            $editor->placeholder($placeholder);
        }

        if ($columnSpanFull) {
            $editor->columnSpanFull();
        }

        return $editor;
    }

    /**
     * 創建基礎的 TinyMCE 編輯器
     */
    protected function createTinyMceEditor(
        string $name,
        string $label,
        bool $required = false,
        bool $columnSpanFull = true,
        ?string $placeholder = null,
        string $profile = 'default',
        ?array $customConfigs = null
    ): TinyEditor {
        $editor = TinyEditor::make($name)
            ->label($label)
            ->required($required)
            ->columnSpanFull()
            ->maxHeight('200')
            ->profile($profile);

        if ($placeholder) {
            $editor->placeholder($placeholder);
        }

        if ($customConfigs) {
            $editor->customConfigs($customConfigs);
        }

        return $editor;
    }
}
