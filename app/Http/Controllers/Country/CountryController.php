<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;

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
        return response()->json(Country::find($id));
    }

    /**
     * @desc    Save country
     *
     * @param   Request     $request
     * @return  Country     json response
     */
    public function countrySave(Request $request)
    {
        $country = Country::create($request->all());

        return response()->json($country, 201); // 201 => created
    }

    /**
     * @desc    Update country
     *
     * @param   Request $request    Update Request
     * @param   Country $country    Country Model
     * @return  Country json response
     */
    public function countryUpdate(Request $request, Country $country)
    {
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
        if (Country::where('id', $id)->exists()) {
            $country = Country::find($id);
            $country->delete();
    
            return response()->json([
              "message" => $country->name . " deleted"
            ], 202);
        }

        return response()->json([
          "message" => "Country not found"
        ], 404);
    }
}
