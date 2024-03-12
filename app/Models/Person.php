<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'user_id',
        'name',
        'father_name',
        'father_is_dead',
        'mother_name',
        'mother_is_dead',
        'dob',
        'blood_group',
        'contact_no',
        'email',
        'gender',
        'marital_status',
        'spouse_user_id',
        'spouse_user_name',
        'present_address',
        'permanent_address',
        'is_head_of_family',
        'family_head_user_id',
        'do_wasiyyat',
        'academic_info',
        'professional_info',
    ];

    public function spouse()
    {
        return $this->hasOne(Person::class, 'user_id', 'spouse_user_id');
    }

    public function headOfFamily():HasOne
    {
        return $this->hasOne(Person::class, 'user_id', 'family_head_user_id');
    }

    public function familyMembers($person_id)
    {
        $personData = Person::where('id', $person_id)->first();

        if ($personData->is_head_of_family == 1) {    // if he/she is the head of the family
            if (empty($personData->user_id)) return [];
            $familyMembers = Person::where('family_head_user_id', $personData->user_id)
                ->whereNotIn('id', [$person_id])
                ->orderBy('dob', 'ASC')
                ->get(['name'])->toArray();
        } else {                                       // he/she is not the head of the family
            if (empty($personData->family_head_user_id)) return [];

            $familyMembers = Person::select('name', 'dob')
                ->where('family_head_user_id', '=', $personData->family_head_user_id)
                ->where('id', '!=', $personData->id)
                ->union(
                    Person::select('name', 'dob')
                        ->where('user_id', '=', $personData->family_head_user_id)
                )
                ->orderBy('dob', 'ASC')
                ->get()->toArray();
        }
        return $familyMembers;
    }

    public function familyMembersName($person_id): array
    {
        $familyMembersData = $this->familyMembers($person_id);
        if (empty($familyMembersData)) return [];
        $membersName = [];
        foreach ($familyMembersData as $member) {
            $membersName[] = str_replace(',', '', $member['name']);
        }
        return $membersName;
    }

    protected function dob(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                if (!empty($value)) {
                    return date('Y-m-d', strtotime($value));
                }
                return null;
            },
            set: function ($value) {
                if (!empty($value)) {
                    return date('Y-m-d', strtotime($value));
                }
                return null;
            },
        );
    }

    public function getFatherNameAttribute($value): string
    {
        return !empty($value) ? ($this->attributes['father_is_dead'] ? 'Late ' . $value : $value) : '';
    }

    /* public function setFatherNameAttribute($value)
    {
        $this->attributes['father_name'] = (stripos($value, 'Late') === 0) ? 'Late ' . $value : $value;
        $this->attributes['father_is_dead'] = (stripos($value, 'Late') === 0) ? 1 : 0;
    }*/

    public function getMotherNameAttribute($value): string
    {
        return !empty($value) ? ($this->attributes['mother_is_dead'] ? 'Late ' . $value : $value) : '';
    }

    /* public function setMotherNameAttribute($value)
    {
        $this->attributes['mother_name'] = (stripos($value, 'Late') === 0) ? 'Late ' . $value : $value;
        $this->attributes['mother_is_dead'] = (stripos($value, 'Late') === 0) ? 1 : 0;
    }*/

    public function getContactNoAttribute($value): string
    {
        return !empty($value) ? implode(', ', json_decode($value, true)) : '';
    }

    public function getAcademicInfoAttribute($value): array
    {
        return !empty($value) ? json_decode($value, true) : [];
    }

    public function getProfessionalInfoAttribute($value): array
    {
        return !empty($value) ? json_decode($value, true) : [];
    }
}
