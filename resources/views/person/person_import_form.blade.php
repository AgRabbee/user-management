@extends('layouts.app')
@section('title', 'Excel Import')

@push('admin_custom_css')
    <style>
        .file > input[type='file'] {
            display: none
        }

        .file > label {
            font-size: 1rem;
            font-weight: 300;
            cursor: pointer;
            outline: 0;
            user-select: none;
            border-color: rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);
            border-style: solid;
            border-radius: 4px;
            border-width: 1px;
            background-color: hsl(0, 0%, 100%);
            color: hsl(0, 0%, 29%);
            padding: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .file > label:hover {
            border-color: hsl(0, 0%, 21%);
        }

        .file > label:active {
            background-color: hsl(0, 0%, 96%);
        }

        .file > label > i {
            padding-right: 5px;
        }

        .multiselect-container > li > a > label {
            padding: 5px 5px 5px 10px !important;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 225px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
            border: 1px solid #ddd;
            margin: 15px 0px 10px 0px;
        }

        #sample_file_img {
            width: 60px;
            height: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
            text-align: center;
        }

        #sample_file_img img {
            width: 100%;
            height: 100%;
        }

        #sample_file_img:hover {
            border: 2px solid #333;
        }
    </style>
@endpush

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-4">
                <!-- Welcome card -->
                <div class="col-md-12 col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Import Person from Excel</h5>
                        <div class="divider my-0">
                            <div class="divider-text">
                                <i class="mdi mdi-star-outline"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('person.import') }}" id="importForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class='file'>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Choose your excel file <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file" id="formFile"
                                               accept=".xls, .xlsx, .csv, .gsheet"/>
                                        @error('file')
                                        <small class="m-0 mt-0 text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <small class="form-text text-muted">
                                            Before proceeding you may follow these instructions:
                                            <ul>
                                                <li>You need to upload an Excel (.xlsx) file.</li>
                                            </ul>
                                        </small>
                                        <div id="sample_file_img" class="mt-2 align-items-center">
                                            <a href="{{ asset('/samples/Sample.xlsx') }}">
                                                <span class="mdi mdi-48px mdi-file-download-outline"></span>
                                                <small class="text-light fw-medium">Sample</small>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Response message -->
                                    <div class="alert" style="display: none; color:red; padding: 0px;" id="responseMsg"></div>
                                </div>
                                <br>

                                <div class="demo-inline-spacing">
                                    <button type="submit" class="btn btn-primary" id="import_btn">
                                        <span class="tf-icons mdi mdi-database-import-outline me-1"></span>Import User
                                        Data
                                    </button>
                                    <div class="spinner-border spinner-border-sm text-primary" style="display: none;" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('admin_custom_scripts')
    <script>
        $(document).ready(function () {
            $('#importForm').submit(function () {
                $('#import_btn').prop('disabled', true);
                $('.spinner-border').show();
            });
        });
    </script>
@endpush
