@extends('layouts.app')
@section('title', 'Person | Create')

@push('admin_custom_css')@endpush

@section('admin_content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-4">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <h5 class="card-header">
                        New Person
                    </h5>

                    <div class="divider my-0">
                        <div class="divider-text"><i class="mdi mdi-star-outline"></i></div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('person.store') }}">
                            @csrf

                            {{-- user id --}}
                            <div class="row">
                                {{-- user_id --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="user_id">User ID</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-identifier"></i></span>
                                            <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                                                   value="{{ old('user_id') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- name & email --}}
                            <div class="row">
                                {{-- name --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="name">Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- email --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label" for="email">Email</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                            <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- father's name --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="f_name">Father's Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                            <input type="text" class="form-control" id="f_name" name="father_name" value="{{ old('father_name') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- mother's name --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label" for="m_name">Mother's Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                            <input type="text" class="form-control" id="m_name" name="mother_name" value="{{ old('mother_name') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- contact no --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="contact">Contact No</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge mt-1">
                                            <span id="contact" class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                            <input type="text" id="contact_no" name="contact_no" value="{{ old('contact_no') }}" class="form-control phone-mask"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- date of birth --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label" for="dob">Date of Birth</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-calendar-blank-outline"></i></span>
                                            <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}"/>
                                        </div>
                                        <div class="form-text"> Example: 2024-01-05</div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider">
                                <div class="divider-text"><i class="mdi mdi-minus"></i></div>
                            </div>

                            {{-- present & permanent address --}}
                            <div class="row">
                                {{-- present address --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="present_address">Present Address</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            {{--<span class="input-group-text"><i class="mdi mdi-map-marker-outline"></i></span>--}}
                                            <textarea id="present_address" name="present_address" class="form-control">{{ old('present_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- Permanent Address --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label" for="permanent_address">Permanent Address</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            {{--<span class="input-group-text"><i class="mdi mdi-map-marker-outline"></i></span>--}}
                                            <textarea id="permanent_address" name="permanent_address" class="form-control">{{ old('permanent_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- blood group --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="blood_group">Blood Group</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <select id="blood_group" name="blood_group" class="form-select">
                                                <option value="">-- Select one --</option>
                                                @foreach($blood_groups as $group)
                                                    <option value="{{ strtolower($group) }}"
                                                        {{ strtolower(old('blood_group')) == strtolower($group) ? 'selected' : '' }}>{{ strtoupper($group) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Gender --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="gender">Gender</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <select id="gender" name="gender" class="form-select">
                                                <option value="">-- Select one --</option>
                                                @foreach($genders as $gender)
                                                    <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>
                                                        {{ ucfirst($gender) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- marital status --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="marital_status">Marital Status</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <select id="marital_status" name="marital_status" class="form-select">
                                                <option value="">-- Select one --</option>
                                                @foreach($marital_statuses as $statusIndex => $status)
                                                    <option value="{{ $statusIndex }}"
                                                        {{ old('marital_status') == $statusIndex ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- spouse user id & name --}}
                            <span id="spouse_area" style="display: none;">
                                    <div class="divider"><div class="divider-text">Spouse</div></div>

                                    <div class="row mb-3">
                                        {{-- spouse user_id --}}
                                        <div class="row col-md-6 col-sm-12">
                                            <label class="col-sm-3 col-form-label" for="spouse_user_id">Spouse User ID</label>
                                            <div class="col-sm-8" style="padding-left: 10px; padding-right: 2px;">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="mdi mdi-identifier"></i></span>
                                                    <input type="text" class="form-control" id="spouse_user_id" name="spouse_user_id" value="{{ old('spouse_user_id') }}"/>
                                                </div>
                                                <div class="form-text text-danger" id="srch_text" style="display: none;"> Searching ... </div>
                                            </div>

                                            <button type="button" id="user_id_srch" class="btn rounded-pill btn-icon btn-outline-primary">
                                                <span class="tf-icons mdi mdi-account-search-outline"></span>
                                            </button>
                                        </div>

                                        {{-- spouse name --}}
                                        <div class="row col-md-6 col-sm-12">
                                            <label class="col-sm-3 col-form-label" for="spouse_name">Spouse Name</label>
                                            <div class="col-sm-9" style="padding-left: 10px;">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                                    <input type="text" class="form-control" id="spouse_name" name="spouse_name" readonly value="{{ old('spouse_name') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </span>

                            <div class="divider">
                                <div class="divider-text">Family</div>
                            </div>

                            {{-- family_head radio --}}
                            <div class="row">
                                {{-- is head of family --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="head_of_family">Head Of Family</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge mt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input head_of_family_inp" type="radio" name="is_head_of_family"
                                                       {{ old('is_head_of_family') == 1 ? 'checked' : '' }} id="yes" value="1"/>
                                                <label class="form-check-label" for="yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input head_of_family_inp" type="radio" name="is_head_of_family"
                                                       {{ old('is_head_of_family') == 0 ? 'checked' : '' }} id="no" value="0"/>
                                                <label class="form-check-label" for="no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row col-md-6 col-sm-12 md:text-end float-end"></div>
                            </div>

                            {{-- family_head_area --}}
                            <div class="row" id="family_head_area" style="display: none;">
                                {{-- family head user_id --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label pt-0" for="family_head_user_id">Family Head User ID</label>
                                    <div class="col-sm-8" style="padding-left: 10px; padding-right: 2px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-identifier"></i></span>
                                            <input type="text" class="form-control" id="family_head_user_id" name="family_head_user_id"
                                                   value="{{ old('family_head_user_id') }}"/>
                                        </div>
                                        <div class="form-text text-danger" id="head_srch_text" style="display: none;">Searching ...</div>
                                    </div>
                                    <button type="button" id="head_user_id_srch" class="btn rounded-pill btn-icon btn-outline-primary">
                                        <span class="tf-icons mdi mdi-account-search-outline"></span>
                                    </button>
                                </div>

                                {{-- family head user name --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label pt-0" for="family_head">Family Head Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                            <input type="text" class="form-control" id="family_head" name="family_head" readonly value="{{ old('family_head') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider">
                                <div class="divider-text">Academy Info</div>
                            </div>

                            <div class="row">
                                {{-- Degree name --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="degree_name">Degree Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                            <input type="text" class="form-control" id="degree_name" name="degree_name" value="{{ old('degree_name') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- subject_name --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label" for="subject_name">Subject Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-certificate"></i></span>
                                            <input type="text" class="form-control" id="subject_name" name="subject_name" value="{{ old('subject_name')  }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- institution_name --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label pt-0" for="institution_name">Institution Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-domain"></i></span>
                                            <input type="text" class="form-control" id="institution_name" name="institution_name" value="{{ old('institution_name') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- institution_address --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label pt-0" for="institution_address">Institution Address</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-map-marker-outline"></i></span>
                                            <input type="text" class="form-control" id="institution_address" name="institution_address" value="{{ old('institution_address') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- passing_year --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label pt-0" for="passing_year">Passing Year</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-calendar-blank-outline"></i></span>
                                            <input type="text" class="form-control" id="passing_year" name="passing_year" value="{{ old('passing_year') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider">
                                <div class="divider-text">Professional Info</div>
                            </div>

                            <div class="row">
                                {{-- Profession --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="profession">Profession</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-account-tie"></i></span>
                                            <input type="text" class="form-control" id="profession" name="profession" value="{{ old('profession') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- job_title --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label" for="job_title">Job Title</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-certificate"></i></span>
                                            <input type="text" class="form-control" id="job_title" name="job_title" value="{{ old('job_title') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- company_name --}}
                                <div class="row col-md-6 col-sm-12">
                                    <label class="col-sm-3 col-form-label pt-0" for="company_name">Company Name</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-domain"></i></span>
                                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- company_address --}}
                                <div class="row col-md-6 col-sm-12 md:text-end float-end">
                                    <label class="col-sm-3 col-form-label pt-0" for="company_address">Company Address</label>
                                    <div class="col-sm-9" style="padding-left: 10px;">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="mdi mdi-map-marker-outline"></i></span>
                                            <input type="text" class="form-control" id="company_address" name="company_address" value="{{ old('company_address') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- submit button --}}
                            <div class="row text-center mt-3">
                                <div class="col-sm-12">
                                    <a href="{{ route('person.index') }}" type="button" class="btn btn-outline-dark waves-effect">Close</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('admin_custom_scripts')
    <script>
        $(document).ready(function () {
            /* ### marital status dropdown selection starts */
            $('#marital_status').change(function () {
                let selectedStatus = $(this).val();
                if (selectedStatus == 0) {
                    $('#spouse_area').hide();
                } else {
                    $('#spouse_area').show();
                }
            });
            /* marital status dropdown selection ends */

            /* ### head of family radio starts */
            $('.head_of_family_inp').change(function () {
                let selectedStatus = $("input:radio.head_of_family_inp:checked").val();
                if (selectedStatus == 1) {
                    $('#family_head_area').hide();
                } else {
                    $('#family_head_area').show();
                }
            });
            /* head of family radio ends */

            /* ### wasiyyat radio starts */
            $('.do_wasiyyat').change(function () {
                let selectedVal = $("input:radio.do_wasiyyat:checked").val();
                if (selectedVal == 0) {
                    $('#wasiyyat_no_inp').hide();
                } else {
                    $('#wasiyyat_no_inp').show();
                }
            });
            /* wasiyyat radio ends */

            $("#user_id_srch").click(function () {
                let spouse_user_id = $('#spouse_user_id').val();
                if (!spouse_user_id || spouse_user_id === 0) {
                    alert('Please enter your spouse user id.');
                    return;
                }
                $('#srch_text').show();
                try {
                    let userData = userSearchById(spouse_user_id);
                    userData
                        .then((name) => {
                            $('#spouse_name').val(name);
                            $('#srch_text').hide();
                        })
                        .catch(() => {
                            alert('Spouse not found.');
                            $('#srch_text').hide();
                            return false;
                        });
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while searching for the user.');
                    $('#srch_text').hide();
                }
            });

            $("#head_user_id_srch").click(function () {
                let family_head_user_id = $('#family_head_user_id').val();
                if (!family_head_user_id || family_head_user_id === 0) {
                    alert('Please enter head of your family user id.');
                    return;
                }
                $('#head_srch_text').show();
                try {
                    let userData = userSearchById(family_head_user_id);
                    userData
                        .then((name) => {
                            $('#family_head').val(name);
                            $('#head_srch_text').hide();
                        })
                        .catch(() => {
                            alert('Family head user not found.');
                            $('#head_srch_text').hide();
                            return false;
                        });
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while searching for the user.');
                    $('#head_srch_text').hide();
                }
            });

            /* ### waqf_e_nou radio starts */
            $('.is_waqf_e_nou_inp').change(function () {
                let selectedVal = $("input:radio.is_waqf_e_nou_inp:checked").val();
                if (selectedVal == 0) {
                    $('#waqf_e_nou_no_inp').hide();
                } else {
                    $('#waqf_e_nou_no_inp').show();
                }
            });
            /* waqf_e_nou radio ends */

            /* ### type of person radio starts */
            $('.type_of_person_inp').change(function () {
                let selectedVal = $("input:radio.type_of_person_inp:checked").val();
                if (selectedVal == 1) {
                    $('#year_of_bayat_inp').hide();
                } else {
                    $('#year_of_bayat_inp').show();
                }
            });
            /* type of person radio ends */


            /* ### subscriber_of_pakkhik starts */
            $('#subscriber_of_pakkhik').change(function () {
                if ($(this).is(':checked')) {
                    $(this).val(1);
                    $('#subscribe_lbl').text('Un-subscribe');
                } else {
                    $(this).val(0);
                    $('#subscribe_lbl').text('Subscribe');
                }
            });
            /* subscriber_of_pakkhik ends */


            $("#ref_user_id_srch").click(function () {
                let reference_person_id = $('#reference_person_id').val();
                if (!reference_person_id || reference_person_id === 0) {
                    alert('Please enter reference person user id.');
                    return;
                }
                $('#referrer_srch_text').show();
                try {
                    let userData = userSearchById(reference_person_id);
                    userData
                        .then((name) => {
                            $('#referred_by').val(name);
                            $('#referrer_srch_text').hide();
                        })
                        .catch(() => {
                            alert('Referrer Person not found.');
                            $('#referrer_srch_text').hide();
                            return false;
                        });
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while searching for the user.');
                    $('#referrer_srch_text').hide();
                }
            });
        });
    </script>

    <script>
        async function userSearchById(user_id) {
            try {
                const response = await $.ajax({
                    url: "{{ route('srch_user_by_id') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: user_id
                    },
                    dataType: 'json'
                });

                if (response.responseCode == 1) {
                    return response.data;
                } else {
                    return null;
                }
            } catch (error) {
                throw error;
            }
        }
    </script>
@endpush
