<?php

namespace App\Http\Requests\Complains;

use Illuminate\Foundation\Http\FormRequest;

class ComplainRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'service_id' => 'required|numeric|exists:services,id',
            'id' => 'required|numeric|exists:service_requests,id',
            'message' => 'required|string',
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            // 'request_id' => 'required|integer|exists:service_requests,id',
            // 'accepted' => 'required|boolean',
            // 'pending' => 'required|boolean',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }
}
