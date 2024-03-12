<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-4">
            <!-- Welcome card -->
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <h5 class="card-header">Details of report: <strong>{{ $report->report_title }}</strong></h5>
                    <div class="divider my-0">
                        <div class="divider-text">
                            <i class="mdi mdi-star-outline"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="msg" class="alert" style="display: none;"></div>

                        {{-- report title --}}
                        <div class="form-group mb-3">
                            <label for="report_title">Report Title</label>
                            <input type="text" class="form-control" id="report_title" name="report_title" value="{{ $report->report_title }}">
                        </div>

                        {{-- report query --}}
                        {{--<div class="form-group mb-3">
                            <label for="query">Query</label>
                            <textarea class="form-control" id="query" name="query" col="5" row="5" placeholder="Report query">{{ $report->query }}</textarea>
                        </div>--}}

                        {{-- report type --}}
                        <div class="form-group mb-3">
                            <label for="type">Report Type</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ $report->type }}">
                        </div>

                        {{-- report status --}}
                        <div class="form-group mb-3">
                            <label class="col-sm-3 col-form-label" for="status">Report Status</label>
                            <div class="form-switch">
                                <input class="form-check-input" type="checkbox" id="status" value="{{ $report->status }}"
                                       name="status" {{ $report->status == 1 ? 'checked' : '' }} />
                                <label class="form-check-label" id="status_lbl" for="status">
                                    {{ $report->status == 1 ? 'In-active' : 'Active' }}</label>
                            </div>

                        </div>

                        {{-- submit button --}}
                        <div class="row text-center">
                            <div class="col-sm-12">
                                <a href="{{ url('/dashboard') }}" type="button" class="btn btn-outline-dark waves-effect">Close</a>
                                <button type="button" id="update_report" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
