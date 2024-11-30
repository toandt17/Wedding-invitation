<?php

namespace App\Services\WeddingTemplates;

use Illuminate\View\View;

class Template3 extends WeddingTemplate
{
    public static function getTemplateId(): string
    {
        return 'template3';
    }

    public static function getName(): string
    {
        return 'Mẫu thiệp cưới hiện đại';
    }

    public function render(): View
    {
        return view('wedding-templates.template3', [
            'card' => $this->card
        ]);
    }
}
