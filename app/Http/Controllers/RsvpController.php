<?php

namespace App\Http\Controllers;

use App\Models\WeddingCard;
use App\Models\WeddingRsvp;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function store(Request $request, $slug)
    {
        $card = WeddingCard::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'number_of_guests' => 'required|integer|min:1',
            'is_attending' => 'required|boolean',
            'message' => 'nullable|string'
        ]);

        $rsvp = new WeddingRsvp($validated);
        $rsvp->wedding_card_id = $card->id;
        $rsvp->save();

        return back()->with('success', 'Cảm ơn bạn đã xác nhận tham dự!');
    }
} 
