<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\InviteCaptain;
use App\Notifications\InvitePlayer;
use App\Notifications\RegisterPlayers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tournaments() {
        return $this->hasMany(Tournament::class);
    }

    public function player(){
        return $this->hasOne(Player::class);
    }

    public static function isValid(string $token)
    {
        $current=date('Y-m-d H:i:s');
        return User::where("invite_token",$token)
                    ->where("expires_at",">=",$current)
                    ->first();
    }

    public static function addUser(Request $request)
    {
        $token=hash('sha256',"$request->email". round(microtime(true)*1000).strrev("$request->email").rand());

        $user =User::create([
            'email'=>$request->email,
            'role'=>'player',
            'invite_token'=>$token,
            'expires_at'=>Carbon::now()->addDays(30)
        ]);
        // dd($user);
        Notification::route('mail',$request->email)->notify(new InvitePlayer($token));

        return $user;
    }

    public static function registerCaptain($captainsEmail,int $tournamentId, int $teamId)
    {
        $token=hash('sha256',"$captainsEmail". round(microtime(true)*1000).strrev("$captainsEmail").rand());

        $user =User::create([
            'email'=>$captainsEmail,
            'role'=>'player',
            'invite_token'=>$token,
            'expires_at'=>Carbon::now()->addDays(30)
        ]);
        // dd($user);

        Notification::route('mail',$captainsEmail)->notify(new InviteCaptain($token,$tournamentId,$teamId));

        return $user;
    }

    public function addCaptain(int $tournamentId, int $teamId, int $playerId) {
        // dd($request);

        $team = Team::find($teamId);
        $team->players()->attach($playerId, ['tournament_id' => $tournamentId]);

        $player=Player::find($playerId);
        $captainsEmail=$player->user->email;
        $token=hash('sha256',"$captainsEmail". round(microtime(true)*1000).strrev("$captainsEmail").rand());

        $player->user->update([
            'invite_token'=>$token,
            'expires_at'=>Carbon::now()->addDays(30)
        ]);

        sleep(10);
        Notification::route('mail',$captainsEmail)->notify(new RegisterPlayers($teamId,$tournamentId,$token));

        return 1;
    }

    public function scopeSearch($query, $searchParam) {
        if(isset($searchParam)) {
            $query->where('first_name', 'like', "%$searchParam%");
        }
        // dd($searchParam);
        return $query;
    }

    public function scopeLimit_by($query, $start, $length) {
        if($length != -1) {
            $query->offset($start)->limit($length);
        }
        return $query;
    }

    public function scopeNotverified($query){
        return $query->latest('updated_at')->where('email_verified_at','!=',null);
    }

    public function isAdmin() {
        return $this->role === "admin";
    }

    public function isOwner(Tournament $tournament) {
        return $this->id === $tournament->organizer_id;
    }

}
