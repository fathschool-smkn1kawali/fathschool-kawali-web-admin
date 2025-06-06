<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Carbon\Carbon;

class QuotesController extends Controller
{
    // Method to get the quote of the day
    public function getRandomQuote()
    {
        $quote = Quote::inRandomOrder();

        return response()->json([
            'quote' => $quote
        ]);
    }

    // Method to add a new quote
    public function addQuote(Request $request)
    {
        $request->validate([
            'quote' => 'required|string|max:255',
        ]);

        $quote = new Quote();
        $quote->quote = $request->quote;
        $quote->save();

        return response()->json([
            'message' => 'Quote added successfully!',
            'quote' => $quote
        ]);
    }
}
