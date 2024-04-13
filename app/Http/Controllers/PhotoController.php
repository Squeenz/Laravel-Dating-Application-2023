<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Policies\PhotoPolicy;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;
use Inertia\Inertia;

class PhotoController extends Controller
{
    /**
     * Get the link to the img
     */
    public function getPrivatePhotos($fileName)
    {
        $filePath = '/photos/'. $fileName;

        if (Storage::disk('private')->exists($filePath))
        {
            return response()->file(storage_path("app/private/{$filePath}"));
        }
        else
        {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('viewAdd', Photo::class);

        return Inertia::render('Photos/Add', [
            'numberPhotos' => Photo::where('user_id', Auth::user()->id)->count(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Photo::class);

        $validated = $request->validate([
            'photo.*' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        //check if the files exisits in the request
        if ($request->hasFile('photo')) {
            //define files as the files from the request
            $files = $request->file('photo');

            //set the files to valid, by default the file will be valid
            $isValid = true;

            //loop through each file, and if the file is not valid change the isValid value to false and stop
            foreach ($files as $file) {
                if (!$file->isValid()) {
                    $isValid = false;
                    break;
                }
            }

            //if the file is true we store the items
            if ($isValid) {
                //for each file, we store it into storage/private/photos
                foreach ($files as $file) {
                    $file->store('photos', 'private');

                    $validated['user_id'] = Auth::user()->id;
                    $validated['photo'] = $file->hashName();

                    //using the photo model we create the new item in the database and we pass,
                    //auth id and the hashed file name
                    Photo::create($validated);
                }

                //then redirect the user to the dashboard
                return redirect(route('matchmaking'));
            }
        }
        else
        {
            // if no photos are uplaoded we return them to the same page
            return redirect(route('photos.create'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Return the photo manager view with user photos
     */
    public function remove(): Response
    {
        $this->authorize('viewRemove', Photo::class);

        return Inertia::render('Photos/Remove', [
            'userPhotos' => Auth::user()->photos,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo): RedirectResponse
    {
        $this->authorize('delete', $photo);

        //delete the image from the storage of the application
        $filePath = '/photos/'. $photo->photo;

        Storage::disk('private')->delete($filePath);

        //delete the record from the datbase using the model
        $photo->delete();

        return redirect(route('photos.remove'));
    }
}
