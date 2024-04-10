<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'display_block_id' => 'required',
            'title' => 'nullable',
            'desc' => 'required',
        ]);

        Content::create($validate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);

        $content->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        $content->delete();
    }

    /**
     * Remove item with relative parent
     */
    public function destroyRelative(Content $content)
    {
        $content->displayBlock()->delete();
    }
}
