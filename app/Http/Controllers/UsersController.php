<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Player;
use App\Models\User;
use App\Notifications\InviteUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Exports\UsersExport;
use App\Exports\UsersFailureReport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateImportRequest;
use App\Imports\UsersImport;
use App\Notifications\ImportFailureReport;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only('export', 'import');
    }

    public function store(CreateUserRequest $request)
    {
        $token=hash('sha256',"$request->email". round(microtime(true)*1000).strrev("$request->email").rand());

        $user =User::create([
            'email'=>$request->email,
            'role'=>'player',
            'invite_token'=>$token,
            'expires_at'=>Carbon::now()->addDays(30)
        ]);
        // dd($user);
        Notification::route('mail',$request->email)->notify(new InviteUser($token));

        session()->flash('success','Mail sent successfully ,please check your inbox');
        return redirect()->back();
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $image_path=$request->file('image')->store('players');
        $password=hash('sha256',$request->password);
        $user->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'photo_path'=>$image_path,
            'password'=>$password,
            'email_verified_at'=>Carbon::now()
        ]);

        Player::addPlayer($request, $user);

        session()->flash('success','Details saved successfully');
        return redirect(route('frontend.index'));
    }

    public function validateUser()
    {
        // dd(request()->t);
        // dd(Player::isValid(request()->t));
        $user=User::isValid(request()->t);
        if($user){
            return view('frontend.users.register-user',compact('user'));
        }
        abort(401);
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
