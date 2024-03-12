<?php

namespace App\Http\Controllers;

use App\Models\DisplayBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DisplayBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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

    /**
     * Display the specified resource.
     */
    public function show(DisplayBlock $displayBlock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DisplayBlock $displayBlock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DisplayBlock $displayBlock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DisplayBlock $displayBlock)
    {
        //
    }
}
