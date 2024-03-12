<?php

return [
    'SMS_API_URL' => env('SMS_API_URL'),
    'INSTITUTE_ID' => env('INSTITUTE_ID'),
    'MARITAL_STATUS' => [0 => 'unmarried', 1 => 'married', 2 => 'divorced', 3 => 'separate'],
    'TYPE_OF_AHMADI' => [1 => 'By Birth', 2 => 'By Bayat'],
    'ACADEMIC_INFO_LIST' => ['degree_name', 'subject_name', 'institution_name', 'institution_address', 'passing_year'],
    'PROFESSIONAL_INFO_LIST' => ['profession', 'job_title', 'company_name', 'company_address'],
    'QUESTION_TYPES' => [1 => 'taleem', 2 => 'tarbiyyat', 3 => 'isayyat'],
    'ANSWER_INPUT_TYPES' => [1 => 'radio', 2 => 'short_text', 3 => 'description'],
    'BLOOD_GROUPS' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
    'GENDERS' => ['male', 'female', 'other'],
    'ENQUIRIES_TEXT' => [
        'TALEEM' => [
            'najera_quran' => 'Najera Quran',
            'proof_of_imam_mahadi' => 'Proof of Imam Mahadi',
            'dead_of_isa_a' => 'Dead of Isa (A)',
            'reading_jamat_or_islami_books' => 'Reading Jamati/Islami Books',
        ],
        'TARBIYYAT' => [
            '5_waqt_namaj' => '5 Waqt Namaj',
            'quran_recitation' => 'Quran Recitation Regularly',
            'live_khudba' => 'Live Khudba',
            'seeing_ss_program' => 'Live SS Program',
        ],
    ]
];
