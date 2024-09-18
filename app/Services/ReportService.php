<?php

namespace App\Services;

class ReportService
{
    public function columnList()
    {
        return [
            'persons.user_id' => 'User ID',
            'persons.name' => 'Name',
            'persons.father_name' => 'Father Name',
            'persons.mother_name' => 'Mother Name',
            'persons.dob' => 'DOB',
            'persons.blood_group' => 'Blood Group',
            'persons.contact_no' => 'Contact No',
            'persons.email' => 'Email',
            'persons.gender' => 'Gender',
            'persons.marital_status' => 'Marital Status',
            'persons.spouse_user_id' => 'Spouse User ID',
            'persons.present_address' => 'Present Address',
            'persons.permanent_address' => 'Permanent Address',

//            'persons.academic_info' => 'academic_info',
//            'persons.professional_info' => 'professional_info',
//            'persons.reference_person_id' => 'reference_person_id',
//            'custom.spouse_name' => 'Spouse Name',
//            'persons.is_head_of_family' => 'is_head_of_family',
//            'persons.family_head_user_id' => 'family_head_user_id',
        ];
    }

    public function modifyReportData($data, $export = false)
    {
        $configData = config('constants');
        foreach ($data as $key => $dt) {
            if (array_key_exists('persons.father_name', $dt) && array_key_exists('persons.father_is_dead', $dt) && $dt['persons.father_is_dead'] == 1) {
                $data[$key]['persons.father_name'] = 'Late ' . $dt['persons.father_name'];
            }

            if (array_key_exists('persons.mother_name', $dt) && array_key_exists('persons.mother_is_dead', $dt) && $dt['persons.mother_is_dead'] == 1) {
                $data[$key]['persons.mother_name'] = 'Late ' . $dt['persons.mother_name'];
            }

            if (array_key_exists('persons.contact_no', $dt) && !empty($dt['persons.contact_no'])) {
                $data[$key]['persons.contact_no'] = implode(', ', json_decode($dt['persons.contact_no'], true));
            }

            if (array_key_exists('persons.type_of_person', $dt)) {
                $data[$key]['persons.type_of_person'] = ucfirst($configData['TYPE_OF_PERSON'][$dt['persons.type_of_person']]);
            }

            if($export && array_key_exists('persons.father_is_dead', $dt)){
                unset($data[$key]['persons.father_is_dead']);
            }

            if($export && array_key_exists('persons.mother_is_dead', $dt)){
                unset($data[$key]['persons.mother_is_dead']);
            }

            if (array_key_exists('persons.marital_status', $dt)) {
                $data[$key]['persons.marital_status'] = ucfirst($configData['MARITAL_STATUS'][$dt['persons.marital_status']]);
            }

            if (array_key_exists('persons.gender', $dt)) {
                $data[$key]['persons.gender'] = ucfirst($dt['persons.gender']);
            }
        }

        return $data;
    }
}
