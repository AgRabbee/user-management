<div id="header">
    <h3>Single User Details</h3>
    <p>Dhaka, Bangladesh</p>
</div>

{{-- personal info --}}
<div id="personal_info">
    <div class="section_header">
        <h5>Personal Information</h5>
    </div>
    <table class="info_table" border="1">
        <tr>
            <td>ID No</td>
            <td>{{ $person->user_id ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{ $person->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Father's Name</td>
            <td>{{ $person->father_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Mother's Name</td>
            <td>{{ $person->mother_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td>{{ $person->dob ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Blood Group</td>
            <td>{{ ucfirst($person->blood_group) }}</td>
        </tr>
        <tr>
            <td>Contact No</td>
            <td>{{ $person->contact_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td>{{ $person->email ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Marital Status</td>
            <td>{{ ucfirst($marital_statuses[$person->marital_status]) }}</td>
        </tr>
        <tr>
            <td>Spouse Name</td>
            <td>{{ $person->spouse->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Present Address</td>
            <td>{{ $person->present_address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Parmanent Address</td>
            <td>{{ $person->permanent_address ?? 'N/A' }}</td>
        </tr>
    </table>
</div>

{{-- academic info --}}
<div id="academic_info">
    <div class="section_header">
        <h5>Academic Information</h5>
    </div>
    <table class="info_table" border="1">
        <tr>
            <td>Highest Qualification</td>
            <td>{{ !empty($person->academic_info['degree_name']) ? $person->academic_info['degree_name'] : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Subject</td>
            <td>{{ !empty($person->academic_info['subject_name']) ? $person->academic_info['subject_name'] : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Name of the Institution</td>
            <td>{{ !empty($person->academic_info['institution_name']) ? $person->academic_info['institution_name'] : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Address of the Institution</td>
            <td>{{ !empty($person->academic_info['institution_address']) ? $person->academic_info['institution_address'] : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Passing Year</td>
            <td>{{ !empty($person->academic_info['passing_year']) ? $person->academic_info['passing_year'] : 'N/A' }}</td>
        </tr>
    </table>
</div>

{{-- professional info --}}
<div id="professional_info">
    <div class="section_header">
        <h5>Professional Information</h5>
    </div>
    <table class="info_table" border="1">
        <tr>
            <td>Highest Qualification</td>
            <td>{{ !empty($person->professional_info['profession']) ? $person->professional_info['profession'] : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Subject</td>
            <td>{{ !empty($person->professional_info['job_title']) ? $person->professional_info['job_title'] : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Name of the Institution</td>
            <td>{{ !empty($person->rofessional_info['company_name']) ? $person->professional_info['company_name'] : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Address of the Institution</td>
            <td>{{ !empty($person->professional_info['company_address']) ? $person->professional_info['company_address'] : 'N/A' }}</td>
        </tr>
    </table>
</div>

{{-- other info --}}
<div id="other_info">
    <div class="section_header">
        <h5>Other Information</h5>
    </div>
    <table class="info_table" border="1">
        <tr>
            <td>No of Family Members</td>
            <td>{{ count($person->familyMembersName($person->id))+1 }}</td>
        </tr>
        <tr>
            <td>Name of Family Members</td>
            <td>{{ count($person->familyMembersName($person->id)) > 0 ? implode(', ',$person->familyMembersName($person->id)) : 'N/A' }}</td>
        </tr>
    </table>
</div>

{{-- footer section --}}
<div id="footer">
    <table id="footer_table" border="0">
        <tr>
            <td>&nbsp;</td>
            <td>
                <p>Information Collected By</p>
                <br>
                <p>_____________________</p>
                <br>
            </td>
            <td>
                <p>Approved By</p>
                <br>
                <p>_____________________</p>
                <br>
            </td>
        </tr>
    </table>
</div>
