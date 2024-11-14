<?php

namespace App\Http\Controllers;

use App\Models\WeddingCard;
use App\Services\WeddingTemplates\TemplateRegistry;

class WeddingCardController extends Controller
{
    public function show($slug)
    {
        $card = WeddingCard::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Sử dụng TemplateRegistry để lấy và render template
        $template = TemplateRegistry::getTemplate($card->template_id, $card);

        if (!$template) {
            abort(404, 'Template not found');
        }

        return $template->render();
    }
}
