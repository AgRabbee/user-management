<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Libraries\Encryption;
use App\Models\Report;
use App\Services\ReportService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $report)
    {
    }

    public function index()
    {
        $reportList = Report::where('status', 1)->get();
        $columnList = $this->report->columnList();

        return view('report.index', compact('reportList', 'columnList'));
    }

    public function generate(Request $request)
    {
        if (!$request->report_id) {
            return response()->json(['responseCode' => -1, 'msg' => 'Please select a report first.', 'html' => '']);
        }
        $columns = $this->generateColumnReplaceText($request->selectedItems);

        $columnList = $this->report->columnList();

        $pre_defined_columns = ['User ID', 'Name', 'Date Of Birth', 'Contact No',];
        $tbl_columns = empty($request->selectedItems) ? $pre_defined_columns : array_intersect_key($columnList, array_flip($request->selectedItems));

        try {
            $report_id = Encryption::decodeId($request->report_id);
            $reportObj = Report::where(['id' => $report_id, 'status' => 1])->first(['report_title', 'query', 'type']);

            if (!$reportObj) {
                return response()->json(['responseCode' => -1, 'msg' => 'Invalid report request.', 'html' => '']);
            }

            $query = str_replace('__columns__', $columns, $reportObj->query);

            if ($request->ajax()) {
                $data = DB::select($query);
                $dataArray = json_decode(json_encode($data), true);
                $data = $this->report->modifyReportData($dataArray);

                $report_title = $reportObj->report_title;
                $html = strval(view('report.table', compact('report_title', 'data', 'tbl_columns')));

                return response()->json(['responseCode' => 1, 'msg' => 'Report generated.', 'html' => $html]);
            }

            return response()->json(['responseCode' => -1, 'msg' => 'Invalid request.', 'html' => '']);
        } catch (Exception $e) {
            #dd($e->getMessage(), $e->getFile(), $e->getLine());
            return response()->json(['responseCode' => -1, 'msg' => 'Something went wrong.', 'html' => '']);
        }
    }

    public function list()
    {
        $reportList = Report::all();
        return view('report.list', compact('reportList'));
    }

    public function details(Request $request)
    {
        if (!$request->report_id) {
            return response()->json(['responseCode' => -1, 'msg' => 'Please select a report first', 'html' => '']);
        }

        try {
            $decryptedId = Encryption::decodeId($request->report_id);
            $report = Report::where('id', $decryptedId)->first();
            if (!$report) {
                return response()->json(['responseCode' => -1, 'msg' => 'Report not found', 'html' => '']);
            }
            $html = strval(view('report.details', compact('report')));

            return response()->json(['responseCode' => 1, 'msg' => 'Report found.', 'html' => $html]);
        } catch (Exception $e) {
            return response()->json(['responseCode' => -1, 'msg' => 'Something went wrong.', 'html' => '']);
        }
    }

    public function update(Request $request)
    {
        if (!$request['report_id']) {
            return response()->json(['responseCode' => -1, 'msg' => 'Please select a report first']);
        }
        if (empty($request['report_title'])) {
            return response()->json(['responseCode' => -1, 'msg' => 'Report title cannot be empty']);
        }
        /*if ($request['status'] == 1 && empty($request['query'])) {
            return response()->json(['responseCode' => -1, 'msg' => 'Report query cannot be empty']);
        }*/
        if (empty($request['type'])) {
            return response()->json(['responseCode' => -1, 'msg' => 'Report type need to be given']);
        }

        try {
            $decryptedId = Encryption::decodeId($request['report_id']);
            Report::where('id', $decryptedId)->update([
                'report_title' => $request['report_title'],
                //'query'        => !empty($request['query']) ? $request['query'] : '',
                'status'       => $request['status'],
                'type'         => $request['type'],
            ]);

            return response()->json(['responseCode' => 1, 'msg' => 'Report updated successfully.']);
        } catch (Exception $e) {
            #dd($e->getMessage(), $e->getFile(), $e->getLine());
            return response()->json(['responseCode' => -1, 'msg' => 'Something went wrong.']);
        }
    }

    private function generateColumnReplaceText($columnArr)
    {
        if (empty($columnArr)) return '*';

        if (in_array('persons.father_name', $columnArr)) {
            $columnArr[] = 'persons.father_is_dead';
        }
        if (in_array('persons.mother_name', $columnArr)) {
            $columnArr[] = 'persons.mother_is_dead';
        }
        return implode(', ', array_map(function ($column) {
            [$table, $field] = explode('.', $column);
            return "$column '$table.$field'";
        }, $columnArr));
    }

    public function exportReport(Request $request)
    {
        if (!$request->report_id) {
            return response()->json(['responseCode' => -1, 'msg' => 'Please select a report first.', 'html' => '']);
        }

        $columns = $this->generateColumnReplaceText($request->selectedItems);
        $columnList = $this->report->columnList();

        $pre_defined_columns = ['User ID', 'Name', 'Date Of Birth', 'Contact No',];
        $tbl_columns = empty($request->selectedItems) ? $pre_defined_columns : array_intersect_key($columnList, array_flip($request->selectedItems));

        try {
            $report_id = Encryption::decodeId($request->report_id);
            $reportObj = Report::where(['id' => $report_id, 'status' => '1'])->first(['report_title', 'query', 'type']);

            if (!$reportObj) {
                return response()->json(['responseCode' => -1, 'msg' => 'Invalid report request.', 'html' => '']);
            }

            $query = str_replace('__columns__', $columns, $reportObj->query);

            $data = DB::select($query);
            $dataArray = json_decode(json_encode($data), true);
            $data = $this->report->modifyReportData($dataArray, true);

            $report_title = $reportObj->report_title;
            $filename = 'report_' . $report_title . '_' . date('Y-m-d') . '.xlsx';

            // Store the Excel file
            $storagePath = 'reports';
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $filePath = $storagePath . '/' . $filename;
            Excel::store(new ReportExport($data, $tbl_columns), $filePath, 'real_public');

            // Perform the Excel download and return the filename
            return response()->json(['responseCode' => 1, 'msg' => 'Report generated.', 'filename' => $filename]);
        } catch (Exception $e) {
            #dd($e->getMessage(), $e->getFile(), $e->getLine());
            return response()->json(['responseCode' => -1, 'msg' => 'Something went wrong.', 'html' => '']);
        }
    }

    public function downloadReport(Request $request): BinaryFileResponse|JsonResponse
    {
        $filename = $request->input('filename');

        // Set the file path to the storage location where the Excel file is stored
        $filePath = public_path('reports/' . $filename);

        // Check if the file exists
        if (file_exists($filePath)) {
            // Set appropriate headers for the download
            return response()->download($filePath, $filename)->deleteFileAfterSend(true);
        } else {
            return response()->json(['responseCode' => -1, 'msg' => 'File not found.']);
        }
    }
}
