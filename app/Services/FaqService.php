<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;

class FaqService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getCategorySelect(),
            $this->getQuestionInput(),
            $this->getAnswerEditor(),
            $this->getSortInput(),
            $this->getStatusToggle(),
        ];
    }

    private function getCategorySelect()
    {
        return $this->createRelationSelect(
            'category_id',
            '問題分類',
            'category',
            'name',
            true,
            true,
            true,
            null,
            [
                $this->createTextInput('name', '分類名稱', true, 255),
                $this->createNumberInput('sort', '排序', false, 0),
                $this->createToggle('is_active', '啟用狀態'),
            ]
        );
    }

    private function getQuestionInput()
    {
        return Forms\Components\Textarea::make('question')
            ->label('問題')
            ->required()
            ->rows(3)
            ->columnSpanFull();
    }

    private function getAnswerEditor()
    {
        return $this->createQuillEditor(
            'answer',
            '回答',
            '請輸入回答內容...'
        );
    }

    private function getSortInput()
    {
        return $this->createNumberInput(
            'sort',
            '排序',
            false,
            0
        )->default(0);
    }

    private function getStatusToggle()
    {
        return $this->createToggle(
            'is_active',
            '啟用狀態'
        );
    }

    public function getTableColumns(): array
    {
        return [
            $this->getCategoryColumn(),
            $this->getQuestionColumn(),
            $this->getSortColumn(),
            $this->getStatusColumn(),
        ];
    }

    private function getCategoryColumn()
    {
        return $this->createTextColumn(
            'category.name',
            '分類',
            false,
            true
        );
    }

    private function getQuestionColumn()
    {
        return $this->createTextColumn(
            'question',
            '問題',
            true,
            false
        )->limit(50);
    }

    private function getSortColumn()
    {
        return $this->createTextColumn(
            'sort',
            '排序',
            false,
            true
        );
    }

    private function getStatusColumn()
    {
        return $this->createBooleanColumn(
            'is_active',
            '啟用狀態'
        );
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('category_id')
                ->relationship('category', 'name')
                ->label('分類')
                ->placeholder('全部')
                ->multiple(false)
                ->searchable(),
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('啟用狀態'),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->label('編輯'),
            Tables\Actions\DeleteAction::make()
                ->label('刪除'),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('刪除所選'),
            ]),
        ];
    }

    /**
     * 獲取關聯表單架構
     */
    public function getRelationFormSchema(): array
    {
        return [
            $this->getQuestionInput(),
            $this->getAnswerEditor(),
            $this->getSortInput(),
            $this->getStatusToggle(),
        ];
    }

    /**
     * 獲取關聯表格列
     */
    public function getRelationTableColumns(): array
    {
        return [
            $this->getQuestionColumn(),
            $this->getSortColumn(),
            $this->getStatusColumn(),
        ];
    }
}
