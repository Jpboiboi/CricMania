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
use App\Imports\MainSheetImport;
use App\Imports\UsersImport;
use App\Jobs\ProcessVerifyEmail;
use App\Jobs\ProcessEmail;
use App\Jobs\ProcessInviteUserEmail;
use App\Notifications\ImportFailureReport;
use App\Notifications\VerifyEmailNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isEmpty;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only('export', 'import');
    }

    // Register form using 'register as player' btn
    public function validateUser()
    {
        $user=User::isValid(request()->t);
        if($user){
            return view('frontend.users.register-user',compact('user'));
        }
        abort(401);
    }

    // Store user email and send form through mail
    public function store(CreateUserRequest $request)
    {
        $token=hash('sha256',"$request->email". round(microtime(true)*1000).strrev("$request->email").rand());

        $user =User::create([
            'email'=>$request->email,
            'role'=>'player',
            'invite_token'=>$token,
            'expires_at'=>Carbon::now()->addDays(30)
        ]);

        dispatch(new ProcessInviteUserEmail($user))->onQueue('emails');
        session()->flash('success','Mail processed ,please check your inbox in sometime');
        return redirect()->back();
    }

    // Store user details and add user in player tables
    public function update(UpdateUserRequest $request, User $user)
    {
        $image_path=$request->file('image')->store('players');
        // $password=hash('sha256',$request->password);
        $password=Hash::make($request->password);
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


    public function export()
    {
        return Excel::download(new UsersExport, 'skeleton-file.xlsx');
    }

    public function import(CreateImportRequest $request)
    {
        $import = new UsersImport();
        $import->onlySheets('Worksheet');
        Excel::import($import, $request->file('file'));
        if(isEmpty($import->failures())) {;
            return Excel::download(new UsersFailureReport($import->failures()['Worksheet']), 'failure-report.xlsx');
            // return redirect('/')->with('error', 'Your file is Partially imported! Please check your mail for failure report');

        }
        return redirect('/')->with('success', 'All good!');
    }
    
    public function verify(string $token)
    {
        $user=User::where('verification_token',$token)->firstOrFail();
        $user->email_verified_at=Carbon::now();
        $user->verification_token=null;
        $user->save();
        session()->flash('success', 'Email verified successfully');
        return redirect(RouteServiceProvider::HOME);
    }
    public function resendVerification(User $user)
    {
        if(now() > $user->expires_at){
            $verificationToken= User::generateVerificationToken();
            $user->verification_token=$verificationToken;
            $user->expires_at=Carbon::now()->addDays(30);
            $user->save();
        }

        dispatch(new ProcessVerifyEmail($user))->onQueue('emails');
        session()->flash('success', 'Email sent successfully');
        return redirect(RouteServiceProvider::HOME);
    }

}
