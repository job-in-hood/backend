<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->cvs;
    }

    public function store(StoreCvRequest $request)
    {
        $file = $request->file('cv');

        try {
            // Store file to storage
            $storagePath = $file->store('cv');

            return auth()->user()->cvs()->create([
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->extension(),
                'storage_path' => $storagePath
            ])->only(['id', 'original_name', 'extension', 'created_at']);
        } catch (\Exception $ex) {
            // An error has been occured
            return $ex->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cv $cv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cv $cv)
    {
        if (auth()->user()->is($cv->user)) {
            try {
                // Delete file from the storage
                $result = Storage::delete($cv->storage_path);

                // Delete the record
                ($result) ? $cv->delete() : abort(500);

                return response([], 200);
            } catch (\Exception $ex) {
                return response($ex->getMessage(), 500);
            }

        } else {
            abort(403);
        }
    }
}
