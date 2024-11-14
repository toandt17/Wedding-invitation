<?php

namespace App\Services\WeddingTemplates;

class TemplateRegistry
{
    private static array $templates = [
        Template1::class,
        Template2::class,
    ];

    public static function getAllTemplates(): array
    {
        return collect(self::$templates)->mapWithKeys(function ($templateClass) {
            return [
                $templateClass::getTemplateId() => $templateClass::getName()
            ];
        })->toArray();
    }

    public static function getTemplate($templateId, $card): ?WeddingTemplate
    {
        foreach (self::$templates as $templateClass) {
            if ($templateClass::getTemplateId() === $templateId) {
                return new $templateClass($card);
            }
        }
        return null;
    }
}
