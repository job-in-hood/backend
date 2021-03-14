<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCvRequest;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cv",
     *     summary="Get the CV list of the current user",
     *     description="Use with bearer token",
     *     tags={"CV"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User CV list returned"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
    public function index()
    {
        return auth()->user()->cvs;
    }

    /**
     * @OA\Post(
     *     path="/api/cv",
     *     summary="Upload a new CV file",
     *     tags={"CV"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="cv",
     *                     type="file"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     security={
     *       {"api_key": {}}
     *     }
     * )
     */
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
     * @OA\Delete(
     *     path="/api/company/{uuid}",
     *     summary="Delete the CV file",
     *     tags={"CV"},
     *
     *     @OA\Parameter(
     *         description="UUID of CV",
     *         in="path",
     *         name="uuid",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           format="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Deleted"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Invalid ID"
     *     ),
     *     security={
     *       {"api_key": {}}
     *     }
     * )
     */

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
