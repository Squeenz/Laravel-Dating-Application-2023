<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slugName): Response
    {
        $pages = Page::all(['slug', 'page_name']);

        $page = Page::where('slug', $slugName)->firstOrFail();

        $layout = $page->layout;

        $displayBlocks = $layout->displayBlocks()->with('contents')->get();

        return Inertia::render('Page', [
            'pages' => $pages,
            'displayBlocks' => $displayBlocks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = Page::all();

        return Inertia::render('Staff/Pages/Create', [
            'pages' => $pages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page_name' => 'required',
            'slug' => 'required|regex:/^[a-z0-9-]+$/|unique:pages,slug',
        ]);

        $page = Page::create($validated);

        $layoutData = [
            'page_id' => $page->id,
        ];

        $page->layout()->create($layoutData);

        return redirect(route('staff.dashboard.pages'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorize('update', $page);

        $validated = $request->validate([
            'page_name' => 'required',
            'slug' => 'required|regex:/^[a-z0-9-]+$/|unique:pages,slug',
        ]);

        $page->update($validated);

        return redirect(route('staff.dashboard.pages'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        $this->authorize('delete', $page);

        $page->delete();

        return redirect(route('staff.dashboard.pages'));
    }
}
