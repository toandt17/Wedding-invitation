<?php

namespace App\Services\WeddingTemplates;

use Illuminate\View\View;

class Template2 extends WeddingTemplate
{
    public static function getTemplateId(): string
    {
        return 'template2';
    }

    public static function getName(): string
    {
        return 'Mẫu thiệp Red & White Elegance';
    }

    public function render(): View
    {
        return view('wedding-templates.template2', [
            'card' => $this->card
        ]);
    }
} 
