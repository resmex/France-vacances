<?php

namespace App\Http\Requests\Destinations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinationsRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'title'           => 'required',
            'description'     => 'required',
            'content'         => 'required',
            'category'        => 'required|integer',
            'image'           => 'nullable|image',
            // France Vacances property fields
            'property_type'   => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:150',
            'region'          => 'nullable|string|max:100',
            'price_per_night' => 'nullable|numeric|min:0',
            'bedrooms'        => 'nullable|integer|min:0',
            'bathrooms'       => 'nullable|integer|min:0',
            'max_guests'      => 'nullable|integer|min:1',
            'amenities'       => 'nullable|string',
            'featured'        => 'nullable|boolean',
            'rating_cached'   => 'nullable|numeric|min:0|max:5',
            'published_at'    => 'nullable|string',
            'pricing'         => 'nullable|string|max:255',
            'duration'        => 'nullable|string|max:255',
            'group_size'      => 'nullable|string|max:255',
            'tour_type'       => 'nullable|string|max:255',
        ];
    }
}
