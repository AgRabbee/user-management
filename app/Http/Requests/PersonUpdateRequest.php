<?php

namespace App\Http\Requests;

use App\Libraries\Encryption;
use App\Models\Person;
use App\Rules\MobileNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ahmadi_id = Encryption::decodeId($this->route('id'));
        return [
            'user_id'                  => [
                'required',
                Rule::unique(Person::class, 'user_id')->ignore($ahmadi_id),
            ],
            'name'                     => ['required', 'string'],
            'father_name'              => ['nullable', 'string'],
            'mother_name'              => ['nullable', 'string'],
            'dob'                      => ['nullable', 'date'],
            'blood_group'              => ['nullable', 'string'],
            'contact_no'               => ['nullable', 'array'],
            'contact_no.*'             => ['nullable', new MobileNumberRule()],
            'email'                    => ['nullable', 'string'],
            'gender'                   => ['nullable', 'string', 'max:10'],
            'marital_status'           => ['nullable', 'integer', 'between:0,3'],
            'spouse_user_id'           => ['nullable', 'string'],
            'spouse_user_name'         => ['nullable', 'string'],
            'present_address'          => ['nullable', 'string'],
            'permanent_address'        => ['nullable', 'string'],
            'is_head_of_family'        => ['nullable', 'integer', 'between:0,1'],
            'family_head_user_id'      => ['nullable', 'string'],
            'degree_name'              => ['nullable', 'string'],
            'subject_name'             => ['nullable', 'string'],
            'institution_name'         => ['nullable', 'string'],
            'institution_address'      => ['nullable', 'string'],
            'passing_year'             => ['nullable', 'string'],
            'profession'               => ['nullable', 'string'],
            'job_title'                => ['nullable', 'string'],
            'company_name'             => ['nullable', 'string'],
            'company_address'          => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'                 => 'The user ID is required.',
            'user_id.unique'                   => 'The user ID has already been taken.',
            'name.required'                    => 'The name field is required.',
            'name.string'                      => 'The name must be a string.',
            'father_name.string'               => 'The father name must be a string.',
            'mother_name.string'               => 'The mother name must be a string.',
            'dob.date'                         => 'The date of birth must be a valid date. Example: 2024-01-25',
            'blood_group.string'               => 'The blood group should be selected from the list.',
            'contact_no.string'                => 'The contact number must be a string.',
            'email.string'                     => 'The email must be a string.',
            'gender.string'                    => 'The gender must be selected from the list.',
            'gender.max'                       => 'The gender must be selected from the list.',
            'marital_status.integer'           => 'The marital status must be selected from the list.',
            'marital_status.between'           => 'The marital status must be selected from the list.',
            'spouse_user_id.string'            => 'The spouse user ID must be a string.',
            'spouse_user_name.string'          => 'The spouse user name must be a string.',
            'present_address.string'           => 'The present address must be a string.',
            'permanent_address.string'         => 'The permanent address must be a string.',
            'is_head_of_family.integer'        => 'The head of family field must be selected from the options.',
            'is_head_of_family.between'        => 'The is head of family field must be selected from the options.',
            'family_head_user_id.string'       => 'The family head user ID must be a string.',
            'academic_info.string'     => 'The academic info must be a string.',
            'professional_info.string' => 'The professional info must be a string.',

            'degree_name'         => 'The degree name must be a string.',
            'subject_name'        => 'The subject name must be a string.',
            'institution_name'    => 'The institution name must be a string.',
            'institution_address' => 'The institution address must be a string.',
            'passing_year'        => 'The passing year must be a valid date. Example: 2024-01-25 or 2024.',
            'profession'          => 'The profession must be a string.',
            'job_title'           => 'The job title must be a string.',
            'company_name'        => 'The company name must be a string.',
            'company_address'     => 'The company address must be a string.',
        ];
    }
}
