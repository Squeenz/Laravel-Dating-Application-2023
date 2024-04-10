<?php

namespace App\Http\Controllers;

use App\Models\DisplayBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DisplayBlockController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'layout_id' => 'required',
            'type' => 'required',
        ]);

        $block = DisplayBlock::create($validated);

        $content = [
            'display_block_id' => $block->id,
            'title' => $request->title,
            'desc' => $request->desc,
        ];

        $block->contents()->create($content);
    }
}
