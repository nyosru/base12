<?php

namespace App\Modules\Affiliate\Http\Requests;

use App\Modules\Affiliate\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;

class CreateRegApplicationRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email:dns|unique:' . Profile::TABLE_NAME,
            'text' => 'required|string',
            'is_tmf_customer' => 'nullable|accepted',
        ];
    }
}
