<?php

namespace App\Modules\Affiliate\Http\Requests;


use App\Modules\Affiliate\Models\RegApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegApplicationStatusRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'status' => Rule::in([RegApplication::STATUS_APPROVED, RegApplication::STATUS_DECLINED]),
        ];
    }
}
