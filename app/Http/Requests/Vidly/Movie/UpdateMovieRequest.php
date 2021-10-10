<?php

namespace App\Http\Requests\Vidly\Movie;

use App\Http\Requests\ApiRequest;
use App\Models\Vidly\Movie;
use Illuminate\Validation\Rule;

/**
 * @property-read Movie $movie
 */
class UpdateMovieRequest extends ApiRequest
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
            'title' => [
                'string',
                Rule::unique('mongodb.movies', 'title')->ignore($this->movie),
            ],
            'stock' => 'numeric',
            'rate' => ['numeric', 'min:1','max:10', 'regex:/^\d+(\.\d{1,2})?$/'],
            'genre_id' => 'string',
        ];
    }
}
