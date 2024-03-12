<?php

namespace App\Services;

use App\Models\Person;

class PersonService
{
    public function store($givenData): bool
    {
        // prepare and store person data first
        $personInfo = $this->prprPersonData($givenData);
        if (count($personInfo) == 0) return false;       // person name is empty

        $person = Person::updateOrCreate(
            ['name' => $personInfo['name']],
            $personInfo
        );

        if (!$person->id) return false;

        return true;
    }

    private function prprPersonData($providedData): array
    {
        if (empty($providedData['name'])) return [];
        $personData = [
            'user_id'           => !empty($providedData['user_id']) ? intval($providedData['user_id']) : null,
            'name'              => $providedData['name'],
            'father_name'       => !empty($providedData['father_name']) ? $this->removeLateFromName($providedData['father_name']) : null,
            'father_is_dead'    => (!empty($providedData['father_name']) && str_starts_with(strtolower($providedData['father_name']), 'late')) ? 1 : 0,
            'mother_name'       => !empty($providedData['mother_name']) ? $this->removeLateFromName($providedData['mother_name']) : null,
            'mother_is_dead'    => (!empty($providedData['mother_name']) && str_starts_with(strtolower($providedData['mother_name']), 'late')) ? 1 : 0,
            'dob'               => !empty($providedData['dob']) ? $providedData['dob'] : null,
            'blood_group'       => !empty($providedData['blood_group']) ? str_replace('Ve', '', $providedData['blood_group']) : null,
            'contact_no'        => $this->prprContactData($providedData),
            'email'             => !empty($providedData['email']) ? $providedData['email'] : null,
            'gender'            => !empty($providedData['gender']) && in_array(strtolower($providedData['gender']), ['male', 'female', 'other']) ? strtolower($providedData['gender']) : null,
            'present_address'   => !empty($providedData['present_address']) ? $providedData['present_address'] : null,
            'permanent_address' => !empty($providedData['permanent_address']) ? $providedData['permanent_address'] : null,
            'academic_info'     => $this->prprAcademicInfo($providedData),
            'professional_info' => $this->prprProfessionalInfo($providedData),
        ];

        $maritalData = $this->prprMaritalStatus($providedData);
        $familyData = $this->prprFamilyData($providedData);

        return array_merge($personData, $maritalData, $familyData);
    }

    private function removeLateFromName($givenName)
    {
        // Check if the $givenName starts with 'Late' (case-insensitive)
        if (stripos($givenName, 'Late') === 0) {
            // Replace 'Late' with an empty string at the start of the text
            $text = str_replace('Late', '', $givenName);
            // Trim the text to remove any leading spaces
            return ltrim($text);
        }
        return $givenName;
    }

    private function prprContactData($providedData): string
    {
        $contactInfo = [];
        if (!empty($providedData['contact_no'])) {
            if (is_array($providedData['contact_no'])) {
                $contactInfo = array_merge($contactInfo, $providedData['contact_no']);
            } else {
                $contactInfo[] = $providedData['contact_no'];
            }
        }
        if (!empty($providedData['alternative_no'])) {

            if (is_array($providedData['alternative_no'])) {
                $contactInfo = array_merge($contactInfo, $providedData['alternative_no']);
            } else {
                $contactInfo[] = $providedData['alternative_no'];
            }
        }
        return json_encode($contactInfo);
    }

    private function prprFamilyData($providedData): array
    {
        $data = [];
        $data['is_head_of_family'] = (array_key_exists('is_head_of_family', $providedData)) ? intval($providedData['is_head_of_family']) : 0;

        $data['family_head_user_id'] = 0;
        if ($data['is_head_of_family'] == 0) {
            $data['family_head_user_id'] = (array_key_exists('family_head_user_id', $providedData) && !empty($providedData['family_head_user_id'])) ? intval($providedData['family_head_user_id']) : 0;
        }

        return $data;
    }

    private function prprMaritalStatus($providedData): array
    {
        $configData = config('constants.MARITAL_STATUS');

        $data = [];

        /* For update purpose: first search by key */
        if (array_key_exists($providedData['marital_status'], $configData)) {
            $data['marital_status'] = intval($providedData['marital_status']);
        } else {
            /* For insert from excel: if key not found then search by text */
            $key = array_search(strtolower($providedData['marital_status']), $configData);
            $data['marital_status'] = $key;
        }

        $data['spouse_user_id'] = (array_key_exists('spouse_user_id', $providedData)) ? intval($providedData['spouse_user_id']) : 0;

        $data['spouse_user_name'] = null;
        if (array_key_exists('spouse_user_id', $providedData)) {
            $spouseData = Person::where('user_id', $providedData['spouse_user_id'])->first('name');
            if ($spouseData) {
                $data['spouse_user_name'] = $spouseData->name;
            }
        }

        return $data;
    }

    private function prprAcademicInfo($providedData): string
    {
        $academicInfo = [
            'degree_name'         => !empty($providedData['degree_name']) ? $providedData['degree_name'] : '',
            'subject_name'        => !empty($providedData['subject_name']) ? $providedData['subject_name'] : '',
            'institution_name'    => !empty($providedData['institution_name']) ? $providedData['institution_name'] : '',
            'institution_address' => !empty($providedData['institution_address']) ? $providedData['institution_address'] : '',
            'passing_year'        => !empty($providedData['passing_year']) ? $providedData['passing_year'] : '',
        ];
        return json_encode($academicInfo);
    }

    private function prprProfessionalInfo($providedData): string
    {
        $professionalInfo = [
            'profession'      => !empty($providedData['profession']) ? $providedData['profession'] : '',
            'job_title'       => !empty($providedData['job_title']) ? $providedData['job_title'] : '',
            'company_name'    => !empty($providedData['company_name']) ? $providedData['company_name'] : '',
            'company_address' => !empty($providedData['company_address']) ? $providedData['company_address'] : '',
        ];
        return json_encode($professionalInfo);
    }

    public function update($personId, $givenData)
    {
        // prepare and store person data first
        $personInfo = $this->prprPersonData($givenData);

        if (count($personInfo) == 0) return false;       // person name is empty

        return Person::where('id', $personId)->update($personInfo);
    }

    public function create($givenData)
    {
        // prepare and store person data first
        $personInfo = $this->prprPersonData($givenData);

        if (count($personInfo) == 0) return false;       // person name is empty

        return Person::insert($personInfo);
    }
}
