<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @desc    Country Class
 */
class CountryController extends Controller
{
    /**
     * @desc    Get all country list
     *
     * @return  Country json response
     */
    public function country()
    {
        return response()->json(Country::get(), 200); // 200 => ok
    }

    /**
     * @desc    Get country by country id
     *
     * @param   int     $id     country id
     * @return  Country json    response
     */
    public function countryById($id)
    {
        $country  = Country::find($id);
        if (is_null($country)) {
            return response()->json(["message" => "Not found  !"], 404);
        }
        return response()->json($country, 200);
    }

    /**
     * @desc    Save country
     *
     * @param   Request     $request
     * @return  Country     json response
     */
    public function countrySave(Request $request)
    {
        $rules = [
            "name"      =>  "required|min:3",
            "flag_url"  =>  "required|min:5",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $country = Country::create($request->all());

        return response()->json($country, 201); // 201 => created
    }

    /**
     * @desc    Update country
     *
     * @param   Request $request    Update Request
     * @param   int $id    Country id
     * @return  Country json response
     */
    public function countryUpdate(Request $request, $id)
    {
        $country  = Country::find($id);
        if (is_null($country)) {
            return response()->json(["message" => "Not found  !"], 404);
        }

        $country->update($request->all());
        return response()->json($country, 200); // 200 => ok
    }

    /**
     * @desc    Delete Country
     *
     * @param   int $id Country id
     * @return  json
     */
    public function countryDelete($id)
    {
        $country  = Country::find($id);
        if (is_null($country)) {
            return response()->json(["message" => "Not found  !"], 404);
        }

        $country->delete();
    
        return response()->json([
            "message" => $country->name . " deleted"
        ], 202);
    }
}
