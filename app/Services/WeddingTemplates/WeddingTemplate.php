<?php

namespace App\Services\WeddingTemplates;

use Illuminate\View\View;

abstract class WeddingTemplate
{
    protected $card;

    public function __construct($card)
    {
        $this->card = $card;
    }

    abstract public function render(): View;

    abstract public static function getTemplateId(): string;

    abstract public static function getName(): string;
}
