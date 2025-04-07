<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Toggle;

class FreeShippingService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getMinAmountInput(),
            $this->getStartAtPicker(),
            $this->getEndAtPicker(),
            Toggle::make('is_active')
                ->label('啟用狀態')
                ->inline(false)
                ->default(true)
                ->columnSpanFull(),
        ];
    }

    private function getMinAmountInput()
    {
        return $this->createNumberInput(
            'min_amount',
            '最低訂單金額',
            true,
            0,
            null,
            'NT$'
        );
    }

    private function getStartAtPicker()
    {
        return $this->createDateTimePicker(
            'start_at',
            '開始時間'
        );
    }

    private function getEndAtPicker()
    {
        return $this->createDateTimePicker(
            'end_at',
            '結束時間'
        );
    }

    public function getTableColumns(): array
    {
        return [
            $this->getMinAmountColumn(),
            $this->getStartAtColumn(),
            $this->getEndAtColumn(),
            $this->getStatusColumn(),
            $this->getCreatedAtColumn(),
        ];
    }

    private function getMinAmountColumn()
    {
        return $this->createMoneyColumn(
            'min_amount',
            '最低訂單金額'
        );
    }

    private function getStartAtColumn()
    {
        return $this->createDateTimeColumn(
            'start_at',
            '開始時間'
        );
    }

    private function getEndAtColumn()
    {
        return $this->createDateTimeColumn(
            'end_at',
            '結束時間'
        );
    }

    private function getStatusColumn()
    {
        return $this->createBooleanColumn(
            'is_active',
            '啟用狀態'
        );
    }

    private function getCreatedAtColumn()
    {
        return $this->createDateTimeColumn(
            'created_at',
            '建立時間'
        );
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('is_active')
                ->label('僅顯示啟用')
                ->query(fn($query) => $query->where('is_active', true)),
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
