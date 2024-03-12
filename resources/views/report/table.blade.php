<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-4">
            <!-- Welcome card -->
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="col-md-12 d-flex justify-content-between">
                        <h5 class="card-header">{{ $report_title }}</h5>

                        @if($data)
                        <button type="button" id="report_download" class="btn btn-outline-primary waves-effect btn-sm waves-light mt-2" style="height: 40px; margin-right: 6px;">
                            <span class="tf-icons mdi mdi-download-circle-outline me-1"></span>Download
                        </button>
                        @endif
                    </div>

                    <div class="divider my-0">
                        <div class="divider-text">
                            <i class="mdi mdi-star-outline"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable text-nowrap table-responsive">
                            <table class="datatables-ajax table table-bordered dataTable no-footer">
                                <thead>
                                <tr class="text-nowrap">
                                    <th>#</th>
                                    @foreach($tbl_columns as $column)
                                        <th>{{ $column }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                @if($data)
                                    @foreach($data as $index=>$ahmadi)
                                        <tr>
                                            <th scope="row">{{ $index+1 }}</th>
                                            @foreach($tbl_columns as $key=> $column)
                                                <td style="{{empty($ahmadi[$key]) ? 'background: #f4836fe3; color: #fff;' : ''}}">{{ !empty($ahmadi[$key]) ? $ahmadi[$key] : 'N/A'
                                                }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="5">No available Ahmadi.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        @if($data)
        $('.datatables-ajax').DataTable({});
        @endif
    });
</script>
