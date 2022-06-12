<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestRequest extends FormRequest
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
            'user_id' => 'required|numeric|exists:users,id',
            'pending' => 'required|boolean',
            'accepted' => 'required|boolean',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
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
            'id' => 'required|integer|exists:products,id',
            'experience' => 'required|numeric',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }
}
