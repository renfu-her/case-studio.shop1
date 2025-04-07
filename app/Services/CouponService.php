<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Toggle;

class CouponService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getBasicSection(),
            $this->getDiscountSection(),
            $this->getTimeSection(),
            $this->getStatusToggle(),
        ];
    }

    private function getBasicSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('基本資訊')
            ->schema(components: [
                $this->getCodeInput(),
                $this->getNameInput(),
                $this->getDescriptionInput(),
            ]);
    }

    private function getDiscountSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('折扣設定')
            ->schema([
                $this->getDiscountTypeSelect(),
                $this->getDiscountValueInput(),
                $this->getMinimumSpendInput(),
            ]);
    }

    private function getTimeSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('使用期限')
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        $this->getStartAtPicker(),
                        $this->getEndAtPicker(),
                    ]),
            ]);
    }

    private function getCodeInput()
    {
        return $this->createTextInput(
            'code',
            '折價券代碼',
            true,
            50
        )
            ->unique(ignoreRecord: true)
            ->extraInputAttributes(['style' => 'text-transform: uppercase'])
            ->formatStateUsing(fn($state) => strtoupper($state))
            ->dehydrateStateUsing(fn($state) => strtoupper($state))
            ->placeholder('例如：SUMMER2024')
            ->helperText('只能使用英文字母和數字');
    }

    private function getNameInput()
    {
        return $this->createTextInput(
            'name',
            '折價券名稱',
            true,
            255
        );
    }

    private function getDescriptionInput()
    {
        return Forms\Components\Textarea::make('description')
            ->label('描述')
            ->rows(3);
    }

    private function getDiscountTypeSelect()
    {
        return $this->createSelect(
            'discount_type',
            '折扣類型',
            [
                'fixed' => '固定金額',
                'percentage' => '百分比',
            ],
            true
        );
    }

    private function getDiscountValueInput()
    {
        return Forms\Components\TextInput::make('discount_value')
            ->label('折扣值')
            ->required()
            ->numeric()
            ->minValue(0)
            ->suffix(fn($get) => $get('discount_type') === 'percentage' ? '%' : '元')
            ->afterStateUpdated(function ($state, $get, Forms\Set $set) {
                if ($get('discount_type') === 'percentage' && $state > 100) {
                    $set('discount_value', 100);
                }
            });
    }

    private function getMinimumSpendInput()
    {
        return $this->createNumberInput(
            'minimum_spend',
            '最低消費金額',
            true,
            0,
            null,
            null,
            '元'
        );
    }

    private function getStartAtPicker()
    {
        return $this->createDateTimePicker(
            'start_at',
            '開始時間',
            true
        );
    }

    private function getEndAtPicker()
    {
        return $this->createDateTimePicker(
            'end_at',
            '結束時間',
            true
        );
    }

    private function getStatusToggle()
    {
        return Toggle::make('is_active')
            ->label('啟用狀態')
            ->inline(false)
            ->default(true)
            ->columnSpanFull();
    }

    public function getTableColumns(): array
    {
        return [
            $this->getCodeColumn(),
            $this->getNameColumn(),
            $this->getDiscountColumn(),
            $this->getMinimumSpendColumn(),
            $this->getTimeColumn(),
            $this->getStatusColumn(),
        ];
    }

    private function getCodeColumn()
    {
        return $this->createTextColumn(
            'code',
            '折價券代碼',
            true,
            true
        );
    }

    private function getNameColumn()
    {
        return $this->createTextColumn(
            'name',
            '折價券名稱',
            true,
            true
        );
    }

    private function getDiscountColumn()
    {
        return $this->createTextColumn(
            'discount_value',
            '折扣值',
            false,
            true,
            fn($record) => $record->discount_type === 'percentage'
                ? "{$record->discount_value}%"
                : "{$record->discount_value}元"
        );
    }

    private function getMinimumSpendColumn()
    {
        return $this->createMoneyColumn(
            'minimum_spend',
            '最低消費'
        );
    }

    private function getTimeColumn()
    {
        return $this->createTextColumn(
            'start_at',
            '使用期限',
            false,
            true,
            fn($record) => $record->start_at->format('Y-m-d H:i') .
                ' ~ ' .
                $record->end_at->format('Y-m-d H:i')
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
            Tables\Filters\SelectFilter::make('discount_type')
                ->label('折扣類型')
                ->options([
                    'fixed' => '固定金額',
                    'percentage' => '百分比',
                ]),
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
