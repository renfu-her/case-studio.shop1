<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;

class FaqCategoryService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getNameInput(),
            $this->getSortInput(),
            $this->getStatusToggle(),
        ];
    }

    private function getNameInput()
    {
        return $this->createTextInput(
            'name',
            '分類名稱',
            true,
            255
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
            $this->getNameColumn(),
            $this->getFaqsCountColumn(),
            $this->getSortColumn(),
            $this->getStatusColumn(),
        ];
    }

    private function getNameColumn()
    {
        return $this->createTextColumn(
            'name',
            '分類名稱',
            true,
            true
        );
    }

    private function getFaqsCountColumn()
    {
        return Tables\Columns\TextColumn::make('faqs_count')
            ->label('問題數量')
            ->counts('faqs')
            ->sortable();
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
}
