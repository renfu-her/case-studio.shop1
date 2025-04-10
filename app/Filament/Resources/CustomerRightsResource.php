<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerRightsResource\Pages;
use App\Models\CustomerRight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CustomerRightsResource extends Resource
{
    protected static ?string $model = CustomerRight::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = '顧客權益管理';

    protected static ?string $navigationLabel = '顧客權益文章';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('文章類型')
                    ->options([
                        'privacy_policy' => '隱私權政策',
                        'terms_of_service' => '服務條款',
                        'return_policy' => '退換貨說明',
                    ])
                    ->required()
                    ->disabled(fn ($record) => $record && $record->type === 'return_policy'),
                
                Forms\Components\TextInput::make('title')
                    ->label('標題')
                    ->required()
                    ->maxLength(255),
                
                TinyEditor::make('content')
                    ->label('內容')
                    ->required()
                    ->columnSpanFull()
                    ->visible(fn ($record) => !$record || $record->type !== 'return_policy'),
                
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用')
                    ->default(true),
                
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('發布時間')
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('文章類型')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'privacy_policy' => '隱私權政策',
                        'terms_of_service' => '服務條款',
                        'return_policy' => '退換貨說明',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->label('發布時間')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新時間')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('文章類型')
                    ->options([
                        'privacy_policy' => '隱私權政策',
                        'terms_of_service' => '服務條款',
                        'return_policy' => '退換貨說明',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('啟用狀態'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (CustomerRight $record): string => 
                        $record->type === 'return_policy' 
                            ? route('filament.admin.resources.customer-rights.edit-return-policy', ['record' => $record])
                            : route('filament.admin.resources.customer-rights.edit', ['record' => $record])
                    ),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerRights::route('/'),
            'create' => Pages\CreateCustomerRight::route('/create'),
            'edit' => Pages\EditCustomerRight::route('/{record}/edit'),
            'edit-return-policy' => Pages\EditReturnPolicy::route('/{record}/edit-return-policy'),
        ];
    }
} 