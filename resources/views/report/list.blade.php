@extends('layouts.app')
@section('title', 'Report')

@push('admin_custom_css')@endpush

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-4">
                <div class="col-md-12 col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Report List</h5>

                        <div class="divider my-0">
                            <div class="divider-text">
                                <i class="mdi mdi-star-outline"></i>
                            </div>
                        </div>

                        @if(count($reportList) > 0)
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="report_list" class="form-label">Please Select report</label>
                                    <select id="report_list" class="form-select">
                                        <option>-- Select one --</option>
                                        @foreach($reportList as $key=>$report)
                                            <option value="{{ \App\Libraries\Encryption::encodeId($report->id) }}">{{ $report->report_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <p class="text-center">No available report!! Please contact with system admin.</p>
                        @endif

                        {{-- display report details here --}}
                        <div id="reportDetailsArea" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('admin_custom_scripts')
    <script>
        $(document).ready(function () {
            $('#report_list').change(function () {
                let reportId = $(this).val();
                if (!reportId) {
                    alert('Please select a report first');
                    return false;
                }

                $('#reportDetailsArea').show().html('Report Details fetching...');

                $.ajax({
                    url: "{{ route('report.details') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        report_id: reportId
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.responseCode == 1) {
                            $('#reportDetailsArea').html(response.html);
                        } else {
                            $('#reportDetailsArea').html(response.msg);
                        }
                    },
                    error: function (response) {
                        $('#reportDetailsArea').html('Something went wrong!');
                    }
                });
            });

            /* ### subscriber_of_pakkhik starts */
            $(document).on('click', '#status', function () {
                if ($(this).is(':checked')) {
                    $(this).val(1);
                    $(document).find('#status_lbl').text('In-active');
                } else {
                    $(this).val(0);
                    $(document).find('#status_lbl').text('Active');
                }
            });

            $(document).on('click', '#update_report', function () {
                let btn = $(this);
                btn.prop('disabled', true);

                let report_id = $(document).find('#report_list').val();
                let report_title = $(document).find('#report_title').val();
                let query = $(document).find('#query').val();
                let status = $(document).find('#status').val();
                let type = $(document).find('#type').val();

                if (!report_id) {
                    alert('Please select a report first');
                    return false;
                }
                $('#msg').removeClass('alert-success')
                    .removeClass('alert-danger')
                    .removeClass('alert-info')
                    .addClass('alert-info')
                    .html('Report update in progress...');

                $.ajax({
                    url: "{{ route('report.update') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        report_id: report_id,
                        report_title: report_title,
                        query: query,
                        status: status,
                        type: type,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.responseCode == 1) {
                            $('#msg').removeClass('alert-info').addClass('alert-success');
                        } else {
                            $('#msg').removeClass('alert-info').addClass('alert-danger');
                        }
                        $('#msg').show().html(response.msg);
                        btn.prop('disabled', false);
                    },
                    error: function (response) {
                        btn.prop('disabled', false);
                        $('#msg').show().html('Something went wrong!');
                    }
                });

            });
        });
    </script>
@endpush
