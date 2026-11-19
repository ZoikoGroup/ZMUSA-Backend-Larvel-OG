<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = strtolower($request->query('query', ''));
        $limit = $request->query('count', 20);

        if (!$query) {
            return response()->json([
                'message' => 'Query is required.'
            ], 400);
        }

        $results = collect([]);

        // ======================================
        // 1️⃣ SEARCH IN PLANS — all columns
        // ======================================
        $planColumns = Schema::getColumnListing('plans');

        $plansQuery = Plan::query();
        

        $planColumns = array_diff($planColumns, ['meta_description', 'meta_title']);

        $words = explode(' ', strtolower(trim($query)));

$plansQuery->where(function ($mainQuery) use ($planColumns, $words) {

    foreach ($words as $word) {

        $mainQuery->where(function ($subQuery) use ($planColumns, $word) {

            // LIKE search in all columns
            foreach ($planColumns as $col) {
                $subQuery->orWhereRaw("LOWER(`$col`) LIKE ?", ["%{$word}%"]);
            }

            // Soundex search for title
            $subQuery->orWhereRaw("SOUNDEX(title) = SOUNDEX(?)", [$word]);

        });

    }

});

        $plans = $plansQuery->get()->map(function ($row) use ($query) {
            return [
                'type' => 'plan',
                'title' => $row->title,
                'short_description' => $row->short_description,
                'url' => "https://zoikomobile.com/plans/" . $row->slug,
                'image' => $row->featured_image ? asset('storage/' . $row->featured_image) : null,

                // fuzzy scoring in PHP
                'score' => $this->score($row->title, $query)
            ];
        });


        // ======================================
        // 2️⃣ SEARCH IN PRODUCTS — all columns
        // ======================================
        $productColumns = Schema::getColumnListing('products');

        $productsQuery = Product::query();

        foreach ($productColumns as $col) {
            $productsQuery->orWhereRaw("LOWER(`$col`) LIKE ?", ["%{$query}%"]);
        }

        $productsQuery->orWhereRaw("SOUNDEX(name) = SOUNDEX(?)", [$query]);

        $products = $productsQuery->get()->map(function ($row) use ($query) {
            return [
                'type' => 'product',
                'title' => $row->name,
                'short_description' => $row->short_description ?? '',
                'url' => "https://zoikomobile.com/products/" . $row->slug,
                'image' => $row->image_url ? asset('storage/' . $row->image_url) : null,

                // fuzzy scoring
                'score' => $this->score($row->name, $query)
            ];
        });

        // combine
        $results = $plans->merge($products);

        // sort by fuzzy score DESC
        $results = $results->sortByDesc('score')->take($limit)->values();

        return response()->json([
            "query" => $query,
            "count" => $results->count(),
            "results" => $results
        ]);
    }

    // ======================================
    // 3️⃣ FUZZY LEVENSHTEIN SCORING IN PHP
    // ======================================
    private function score($text, $query)
    {
        $text = strtolower($text);
        $lev = levenshtein($text, $query);

        // Base score: closer distance = higher score
        $score = max(0, 100 - ($lev * 10));

        // Extra boost for LIKE matches
        if (str_contains($text, $query)) {
            $score += 50;
        }

        return $score;
    }
}
