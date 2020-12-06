<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationLookupController extends Controller
{
    public function __invoke(Request $request)
    {
        $inputs = $request->json()->all();

        $term = Str::slug($inputs['term']);

        return strlen($term) < 3 ? [] : Location::select('id', 'display_name')->where('slug', 'like', '%' . $term . '%')->limit(10)->get();
    }
}
