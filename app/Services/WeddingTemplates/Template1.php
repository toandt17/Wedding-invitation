<?php

namespace App\Services\WeddingTemplates;

use Illuminate\View\View;

class Template1 extends WeddingTemplate
{
    public static function getTemplateId(): string
    {
        return 'template1';
    }

    public static function getName(): string
    {
        return 'Mẫu thiệp hoa hồng';
    }

    public function render(): View
    {
        return view('wedding-templates.template1', [
            'card' => $this->card
        ]);
    }
}
