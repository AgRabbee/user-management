<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Imports\PersonImportFromExcel;
use App\Libraries\CommonFunctions;
use App\Libraries\Encryption;
use App\Models\Person;
use App\Services\PersonService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PersonController extends Controller
{
    public function __construct(private readonly PersonService $person)
    {
    }

    public function importForm(): View
    {
        return view('person.person_import_form');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ], [
            'file.required' => 'The file field is required.',
            'file.mimes'    => 'The file must be a .xlsx or .xls file.',
        ]);

        try {
            $import = new PersonImportFromExcel();
            Excel::import($import, $request->file);

            $data = $import->getData();

            if (empty($data)) {
                return redirect()->back()->with('error', 'Data cannot be parsed.');
            }

            $data = collect($data)->filter(function ($row) {
                return !empty(array_filter($row));
            })->values()->all();

            DB::beginTransaction();
            foreach ($data as $datum) {
                $this->person->store($datum);
            }
            DB::commit();

            return redirect()->back()->with('success', 'Data inserted.');
        } catch (\Exception $e) {
            DB::rollback();
            #dd($e->getMessage(), $e->getFile(), $e->getLine());

            return redirect()->back()->with('error', 'Data cannot be inserted.');
        }
    }

    public function truncate(): string
    {
        try {
            Schema::disableForeignKeyConstraints();
            Person::truncate();
            Schema::enableForeignKeyConstraints();

            return 'Tables truncated.';
        } catch (Exception $e) {
            #dd($e->getMessage(), $e->getLine(), $e->getFile());

            return 'Tables cannot be truncated';
        }
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $personList = Person::orderBy('user_id')->get(['id', 'user_id', 'name', 'dob', 'contact_no', 'gender']);

                return Datatables::of($personList)
                    ->addIndexColumn()
                    ->editColumn('gender', function ($row) {
                        return ucfirst($row->gender);
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '<div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="' . url('/person/' . \App\Libraries\Encryption::encodeId($row['id'])
                                . '/edit') . '">
                                                <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" target="_blank" href="' . url('/person/' . \App\Libraries\Encryption::encodeId($row['id'])
                                . '/report') . '">
                                                <i class="mdi mdi-file-chart-outline me-1"></i> Report
                                            </a>
                                            <!--a class="dropdown-item" href="javascript:void(0);">
                                                <i class="mdi mdi-trash-can-outline me-1"></i> Delete
                                            </a-->
                                        </div>
                                    </div>';

                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('person.list');
        } catch (Exception $e) {
            #dd($e->getMessage(), $e->getFile(), $e->getLine());
            return redirect()->back()->with('error', 'Data cannot be fetched.');
        }
    }

    public function new()
    {
        $configData = config('constants');
        $blood_groups = $configData['BLOOD_GROUPS'];
        $marital_statuses = $configData['MARITAL_STATUS'];
        $genders = $configData['GENDERS'];

        return view('person.new', compact('blood_groups', 'marital_statuses', 'genders'));
    }

    public function store(PersonStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->person->create($request->validated());
            DB::commit();

            return redirect()->route('person.index')->with('success', 'Data stored successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            #dd($e->getMessage(), $e->getFile(), $e->getLine());

            return redirect()->back()->with('error', 'Data cannot be stored.');
        }
    }

    public function edit($encryptedId)
    {
        $user_id = Encryption::decodeId($encryptedId);
        $person = Person::with(['spouse', 'headOfFamily'])->where('id', $user_id)->first();

        $configData = config('constants');
        $blood_groups = $configData['BLOOD_GROUPS'];
        $marital_statuses = $configData['MARITAL_STATUS'];
        $genders = $configData['GENDERS'];

        return view('person.single', compact('person', 'blood_groups', 'marital_statuses', 'genders'));
    }

    public function personSrchById(Request $request)
    {
        if (!$request->user_id) {
            return response()->json(['responseCode' => -1, 'msg' => 'User not found.', 'data' => null]);
        }
        $person = Person::where('user_id', $request->user_id)->first(['name']);

        return response()->json(['responseCode' => 1, 'msg' => 'User found.', 'data' => $person->name]);
    }

    public function update(PersonUpdateRequest $request, $encryptedID)
    {
        $person_id = Encryption::decodeId($encryptedID);
        $requestedData = $request->validated();

        try {
            DB::beginTransaction();
            $this->person->update($person_id, $requestedData);
            DB::commit();

            return redirect()->route('person.index')->with('success', 'Data updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            #dd($e->getMessage(), $e->getFile(), $e->getLine());

            return redirect()->route('person.index')->with('error', 'Data cannot be updated.');
        }
    }

    public function singleReport($encryptedId)
    {
        $user_id = Encryption::decodeId($encryptedId);
        $person = Person::with(['spouse', 'headOfFamily'])->where('id', $user_id)->first();
        if (!$person) {
            return 'Invalid request. Go back to Home page.';
        }

        $configData = config('constants');
        $blood_groups = $configData['BLOOD_GROUPS'];
        $marital_statuses = $configData['MARITAL_STATUS'];
        $genders = $configData['GENDERS'];
        $person_types = $configData['TYPE_OF_PERSON'];
        $enquiries_texts = $configData['ENQUIRIES_TEXT'];

        $stylesheet = file_get_contents(public_path("css/single_report.css"));
        $html = strval(view('person.single_report', compact('person', 'blood_groups', 'marital_statuses', 'genders', 'person_types', 'enquiries_texts')));
        $title = $subject = $pdfFileSaveName = 'Report of ' . $person->name;
        CommonFunctions::pdfGeneration($title, $subject, $stylesheet, $html, $pdfFileSaveName, 'I', date('Y-m-d h:i A'));
    }
}
