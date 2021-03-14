<?php

namespace App\Http\Controllers\Api;

use App\Events\JobCreated;
use App\Events\JobDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/job",
     *     summary="Create a new job",
     *     tags={"Job"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="company_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="job_type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="industry_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="location_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="publish_start",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="publish_end",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="salary_type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="salary_min",
     *                     type="float"
     *                 ),
     *                 @OA\Property(
     *                     property="salary_max",
     *                     type="float"
     *                 ),
     *                 @OA\Property(
     *                     property="currency_id",
     *                     type="integer"
     *                 ),
     *                 example={"title": "Senior PHP Developer", "location_id": 3, "job_type_id": 1, "company_id": 11, "industry_id": 1, "publish_start": "2020-05-31", "publish_end": "2020-06-30", "salary_type_id": 1, "salary_min": 50, "salary_max": 60, "currency_id": 1, "description": "Long Description" }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
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
    public function store(StoreJobRequest $request)
    {
        $job = new Job($request->validated());

        $job->user()->associate(auth()->user());

        $job->industry()->associate($request->industry_id);
        $job->company()->associate($request->company_id);
        $job->jobType()->associate($request->job_type_id);
        $job->location()->associate($request->location_id);
        $job->salaryType()->associate($request->salary_type_id);
        $job->currency()->associate($request->currency_id);

        $job->save();

        $job->slug = Str::slug($job->title . '-' . $job->id);
        $job->save();

        // Fire the event
        event(new JobCreated($job));

        return $job;
    }


    /**
     * @OA\Get(
     *     path="/api/job/{id}",
     *     summary="Show job by slug",
     *     tags={"Job"},
     *     @OA\Parameter(
     *         description="Slug of job title",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function show(Job $job)
    {
        if (!$job->published) {
            return response()->json(['message' => 'This content is not published yet'], 404);
        }
        return $job->load([
            'user',
            'company:name',
            'industry',
            'jobType',
            'location',
            'salaryType',
            'currency'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/job/{id}/edit",
     *     summary="Get information of job to editing by slug",
     *     tags={"Job"},
     *     @OA\Parameter(
     *         description="ID of job",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function edit(Job $job)
    {
        $this->authorize('edit-job', $job->company);

        return $job;
    }


    /**
     * @OA\Patch(
     *     path="/api/job/{id}",
     *     summary="Update the job",
     *     tags={"Job"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="job_type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="industry_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="location_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="publish_start",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="publish_end",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="salary_type_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="salary_min",
     *                     type="float"
     *                 ),
     *                 @OA\Property(
     *                     property="salary_max",
     *                     type="float"
     *                 ),
     *                 @OA\Property(
     *                     property="currency_id",
     *                     type="integer"
     *                 ),
     *                 example={"title": "Senior PHP Developer", "location_id": 3, "job_type_id": 1, "company_id": 11, "industry_id": 1, "publish_start": "2020-05-31", "publish_end": "2020-06-30", "salary_type_id": 1, "salary_min": 50, "salary_max": 60, "currency_id": 1, "description": "Long Description" }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
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
    public function update(UpdateJobRequest $request, Job $job)
    {
        $job->fill($request->validated());

        $job->industry()->associate($request->industry_id);
        $job->jobType()->associate($request->job_type_id);
        $job->location()->associate($request->location_id);
        $job->salaryType()->associate($request->salary_type_id);
        $job->currency()->associate($request->currency_id);
        $job->slug = Str::slug($request->title . '-' . $job->id);
        $job->save();

        return $job;
    }


    /**
     * @OA\Delete(
     *     path="/api/job/{id}",
     *     summary="Delete the job",
     *     tags={"Job"},
     *     @OA\Parameter(
     *         description="ID of the job",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
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
    public function destroy(Job $job)
    {
        $this->authorize('delete-job', $job->company);

        $job->delete();

        event(new JobDeleted($job));
    }
}
