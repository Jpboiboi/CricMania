<?php

namespace App\Models;

use App\Notifications\InvitePlayer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory ,Notifiable;
    protected $guarded=['id'];

    public static function boot()
    {
        parent::boot();
        static::updated(function(Player $player){
            $playerExist=PlayerStat::where('player_id',$player->id)->first();

            if(! $playerExist){
                PlayerStat::create([
                    'player_id'=>$player->id,
                ]);
            }
        });

    }
    public function setFirstNameAttribute(string $first_name){//mutator, assigns the title and slug automatically when we try to assign title a value
        $this->attributes['first_name']=$first_name;
        // $this->attributes['last_name']=$last_name;
        $this->attributes['slug']=Str::slug($first_name);

    }

    public function setLastNameAttribute(string $last_name){//mutator, assigns the title and slug automatically when we try to assign title a value
        $this->attributes['last_name']=$last_name;
        // $this->attributes['last_name']=$last_name;
        $this->attributes['slug'] .= '-' . Str::slug($last_name);
    }

    public function playerstats()
    {
        return $this->hasMany(PlayerStat::class);
    }

    public function teams()  {
        return $this->belongsToMany(Team::class, 'player_team');
    }

    public function tournaments() {
        return $this->belongsToMany(Tournament::class, 'player_team');
    }

    public static function isValid(string $token)
    {
        $current=date('Y-m-d H:i:s');
        return Player::where("token",$token)
                    ->where("expires_at",">=",$current)
                    ->first();
    }

    public static function addPlayer(Request $request) {
        $token=hash('sha256',"$request->email". round(microtime(true)*1000).strrev("$request->email").rand());

        $player = Player::create([
            'email'=>$request->email,
            'token'=>$token,
            'expires_at'=>Carbon::now()->addDays(30)
        ]);

        Notification::route('mail',$request->email)->notify(new InvitePlayer($token));

        return $player;
    }

    // SCOPE FUNCTIONS
    public function scopeSearch($query, $searchParam) {
        if(isset($searchParam)) {
            $query->where('first_name', 'like', "%$searchParam%");
        }
        return $query;
    }

    public function scopeLimit_by($query, $start, $length) {
        if($length != -1) {
            $query->offset($start)->limit($length);
        }
        return $query;
    }

    public function scopeNotparticipated($query, $tournamentId) {
        $query->whereHas('teams', function($teamsQuery) use($tournamentId) {
            $playersInThisTournament = DB::table('player_team')->where('tournament_id', '=', $tournamentId)->pluck('player_id')->toArray();
            return $teamsQuery->whereNotIn('player_id', $playersInThisTournament);
        })->orWhereDoesntHave('teams');

    }
}
