<?php

namespace App\Http\Controllers;

use App\Events\CompanyCreated;
use App\Events\CompanyDeleted;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * @OA\Put(
     *     path="/api/company",
     *     summary="Create a new company",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="website",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="industry_id",
     *                     type="integer"
     *                 ),
     *                 example={"name": "Jobinhood", "description": "Very good company", "website" : "www.jobinhood.co.uk", "email": "test@jobinhood.co.uk", "industry_id": 1}
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
    public function store(Request $request)
    {
        $inputs = $request->json()->all();

        $validated = Validator::make($inputs,
            [
                'name' => 'required',
                'description' => 'nullable',
                'logo' => 'nullable',
                'website' => 'url',
                'industry_id' => ['required', 'exists:industries,id'],
                'email' => 'required', 'email'
            ])->validate();


        // Create Company record
        $company = Company::create($validated);

        // Build representation link
        $company->users()->attach(Auth::user());

        // Assign the admin role to the user for company
        $company->representations()->first()->assignRole('Company Administrator');

        event(new CompanyCreated($company));

        return $company;
    }

    /**
     * @OA\Get(
     *     path="/api/company/{id}",
     *     summary="Show company details by ID",
     *     @OA\Parameter(
     *         description="ID of company to return",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
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
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
    public function show(Company $company)
    {
        return $company;
    }


    /**
     * @OA\Patch(
     *     path="/api/company/{id}",
     *     summary="Update the company information",
     *
     *     @OA\Parameter(
     *         description="ID of company to return",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="website",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="industry_id",
     *                     type="integer"
     *                 ),
     *                 example={"name": "Jobinhood", "description": "Very good company", "website" : "www.jobinhood.co.uk", "email": "test@jobinhood.co.uk", "industry_id": 1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Invalid ID"
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $inputs = $request->json()->all();

        $validated = Validator::make($inputs,
            [
                'name' => 'required',
                'description' => 'nullable',
                'logo' => 'nullable',
                'website' => 'url',
                'industry_id' => ['required', 'exists:industries,id'],
                'email' => 'required', 'email'
            ])->validate();

        $company->update($validated);

        return $company;
    }

    /**
     * @OA\Delete(
     *     path="/api/company/{id}",
     *     summary="Delete the company information",
     *
     *     @OA\Parameter(
     *         description="ID of company to return",
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
     *         description="Updated"
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->users()->detach();

        $company->delete();

        event(new CompanyDeleted($company));

        return response()->json();
    }
}
