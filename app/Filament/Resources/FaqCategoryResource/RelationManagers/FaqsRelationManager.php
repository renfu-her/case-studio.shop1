<?php

namespace App\Filament\Resources\FaqCategoryResource\RelationManagers;

use App\Services\FaqService;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    protected static ?string $recordTitleAttribute = 'question';

    protected static ?string $title = '問題列表';

    public function form(Form $form): Form
    {
        return $form->schema(
            app(FaqService::class)->getRelationFormSchema()
        );
    }

    public function table(Table $table): Table
    {
        $service = app(FaqService::class);

        return $table
            ->columns($service->getRelationTableColumns())
            ->filters($service->getTableFilters())
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('新增問題'),
            ])
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
            ->defaultSort('sort', 'asc');
    }
}
