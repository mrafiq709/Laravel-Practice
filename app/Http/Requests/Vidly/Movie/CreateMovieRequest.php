<?php

namespace App\Http\Requests\Vidly\Movie;

use App\Http\Requests\ApiRequest;

class CreateMovieRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:mongodb.movies',
            'stock' => 'required|numeric',
            'rate' => ['required','numeric', 'min:1','max:10', 'regex:/^\d+(\.\d{1,2})?$/'],
            'genre_id' => 'required|string',
        ];
    }
}
