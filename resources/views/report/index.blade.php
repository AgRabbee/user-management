@extends('layouts.app')
@section('title', 'Report')

@push('admin_custom_css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
@endpush

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-4">
                <div class="col-md-12 col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Report </h5>

                        <div class="divider my-0">
                            <div class="divider-text">
                                <i class="mdi mdi-star-outline"></i>
                            </div>
                        </div>

                        @if(count($reportList) > 0)
                            <div class="card-body">
                                @if(count($columnList) > 0)
                                    <div class="mb-3">
                                        <small class="text-light fw-medium d-block">Please select columns</small>
                                        @foreach($columnList as $list=>$listItem)
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input checkboxItem" name="selectedColumns[]" type="checkbox" id="{{$list}}" value="{{$list}}"/>
                                                <label class="form-check-label checkboxItem" for="{{$list}}">{{$listItem}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="reportSelect" class="form-label">Please Select report</label>
                                    <select id="reportSelect" class="form-select">
                                        <option value="">-- Select one --</option>
                                        @foreach($reportList as $key=>$report)
                                            <option value="{{ \App\Libraries\Encryption::encodeId($report->id) }}">{{ $report->report_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- submit button --}}
                                <div class="row text-center">
                                    <div class="col-sm-12">
                                        <a href="{{ url('/dashboard') }}" type="button" class="btn btn-outline-dark waves-effect">Close</a>
                                        <button type="button" id="report_view" class="btn btn-primary">View</button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center">No available report!! Please contact with system admin.</p>
                        @endif

                        <div id="reportDisplayArea" style="display: none;">
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
        $(document).ready(function () {
            $('#report_view').click(function () {
                let report_id = $('#reportSelect').val();

                if (!report_id) {
                    alert('Please select a report first');
                    return false;
                }

                let btn = $(this);
                btn.prop('disabled', true);

                const selectedItems = [];
                $('.checkboxItem:checked').each(function() {
                    selectedItems.push($(this).val());
                });

                $('#reportDisplayArea').show().html('Report generation in progress...');

                $.ajax({
                    url: "{{ route('report.generate') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        report_id: report_id,
                        selectedItems: selectedItems
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.responseCode == 1) {
                            $('#reportDisplayArea').html(response.html);
                            btn.prop('disabled', false);
                        } else {
                            $('#reportDisplayArea').html(response.msg);
                            btn.prop('disabled', false);
                        }
                    },
                    error: function (response) {
                        btn.prop('disabled', false);
                        $('#reportDisplayArea').html('Something went wrong!');
                    }
                });

            });

            $(document).on('click','#report_download',function(){
                let report_id = $('#reportSelect').val();

                if (!report_id) {
                    alert('Please select a report first');
                    return false;
                }

                let btn = $(this);
                let content = btn.html();
                btn.prop('disabled', true);

                const selectedItems = [];
                $('.checkboxItem:checked').each(function() {
                    selectedItems.push($(this).val());
                });

                btn.html(`<div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>`);

                $.ajax({
                    url: "{{ route('report.download') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        report_id: report_id,
                        selectedItems: selectedItems
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        if (response.responseCode == 1) {
                            window.location.href = "{{ route('download.report') }}" + "?filename=" + response.filename;
                            btn.html(content);
                            btn.prop('disabled', false);
                        } else {
                            btn.html(content);
                            btn.prop('disabled', false);
                        }
                    },
                    error: function (response) {
                        btn.prop('disabled', false);
                        btn.html(content);
                    }
                });
            });
        });
    </script>
@endpush
