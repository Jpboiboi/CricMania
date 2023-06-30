<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Exports\UsersFailureReport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateImportRequest;
use App\Imports\UsersImport;
use App\Notifications\ImportFailureReport;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only('export', 'import');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'skeleton-file.xlsx');
    }

    public function import(CreateImportRequest $request)
    {
        $import = new UsersImport();
        Excel::import($import, $request->file('file')->store('files'));
        if($import->failures()->isNotEmpty()) {;
            // return Excel::download(new UsersFailureReport($import->failures()), 'failure-report.xlsx');
            $path = "import-failures/failure-report.xlsx";
            $failure_report = Excel::store(new UsersFailureReport($import->failures()), $path);
            Notification::route('mail',auth()->user()->email)->notify(new ImportFailureReport($path));
            // dd($failure_report);
            return redirect('/')->with('error', 'Your file is Partially imported! Please check your mail for failure report');

        }
        return redirect('/')->with('success', 'All good!');
    }

}
