@extends('layouts.app')
@section('title', 'Person List')

@push('admin_custom_css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
@endpush

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-4">
                <!-- Welcome card -->
                <div class="col-md-12 col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Person List</h5>
                        <div class="divider my-0">
                            <div class="divider-text">
                                <i class="mdi mdi-star-outline"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('person.new') }}" class="btn btn-primary">Add New</a>
                            <!-- DataTable with Buttons -->
                            <div class="card-datatable text-nowrap table-responsive">
                                <table class="datatables-ajax table table-bordered dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Date Of Birth</th>
                                        <th>Contact No</th>
                                        <th>Gender</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('admin_custom_scripts')
    <!-- Page JS -->
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script>
        $(function () {
            var table = $('.datatables-ajax').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: "{{ route('person.index') }}",
                columns: [
                    {data: 'user_id', name: 'user_id', orderable: true, searchable: true},
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'dob', name: 'dob', orderable: false,},
                    {data: 'contact_no', name: 'contact_no', orderable: false, searchable: true},
                    {data: 'gender', name: 'gender', orderable: true, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        $(document).ready(function () {});
    </script>
@endpush
