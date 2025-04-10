<?php

namespace App\Filament\Resources\CustomerRightsResource\Pages;

use App\Filament\Resources\CustomerRightsResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use App\Models\CustomerRight;
use Illuminate\Support\HtmlString;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class EditReturnPolicy extends EditRecord
{
    protected static string $resource = CustomerRightsResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('標題')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Repeater::make('qa_items')
                    ->label('Q&A 項目')
                    ->schema([
                        Forms\Components\TextInput::make('question')
                            ->label('問題')
                            ->required(),
                        
                        TinyEditor::make('answer')
                            ->label('答案')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->defaultItems(3)
                    ->reorderable()
                    ->collapsible(),
                
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用')
                    ->default(true),
                
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('發布時間')
                    ->default(now()),
            ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 將 Q&A 項目轉換為 HTML 內容
        $content = '<div class="return-policy-qa">';
        
        foreach ($data['qa_items'] as $item) {
            $content .= '<div class="qa-item">';
            $content .= '<h3 class="question">' . $item['question'] . '</h3>';
            $content .= '<div class="answer">' . $item['answer'] . '</div>';
            $content .= '</div>';
        }
        
        $content .= '</div>';
        
        $data['content'] = $content;
        $data['type'] = 'return_policy';
        
        // 移除 qa_items 字段，因為它已經被轉換為 content
        unset($data['qa_items']);
        
        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // 從 HTML 內容中提取 Q&A 項目
        if (isset($data['content']) && strpos($data['content'], 'return-policy-qa') !== false) {
            $dom = new \DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($data['content'], 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new \DOMXPath($dom);
            
            $qaItems = [];
            $qaNodes = $xpath->query('//div[@class="qa-item"]');
            
            foreach ($qaNodes as $node) {
                $questionNode = $xpath->query('.//h3[@class="question"]', $node)->item(0);
                $answerNode = $xpath->query('.//div[@class="answer"]', $node)->item(0);
                
                if ($questionNode && $answerNode) {
                    $qaItems[] = [
                        'question' => $questionNode->textContent,
                        'answer' => $answerNode->textContent,
                    ];
                }
            }
            
            $data['qa_items'] = $qaItems;
        } else {
            $data['qa_items'] = [
                ['question' => '', 'answer' => ''],
                ['question' => '', 'answer' => ''],
                ['question' => '', 'answer' => ''],
            ];
        }
        
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 