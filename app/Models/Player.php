<?php

namespace App\Models;

use App\Http\Requests\UpdatePlayerRequest;
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
        static::created(function(Player $player){

            $playerSeasonStatExist=PlayerStat::where('player_id',$player->id)->where('tournament_type_id', TournamentType::SEASON_TYPE)->first();
            if(! $playerSeasonStatExist){
                PlayerStat::create([
                    'player_id'=>$player->id,
                    'tournament_type_id'=>TournamentType::SEASON_TYPE
                ]);
            }

            $playerTennisStatExist=PlayerStat::where('player_id',$player->id)->where('tournament_type_id', TournamentType::TENNIS_TYPE)->first();
            if(! $playerTennisStatExist){
                PlayerStat::create([
                    'player_id'=>$player->id,
                    'tournament_type_id'=>TournamentType::TENNIS_TYPE
                ]);
            }

        });

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

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function batsman()
    {
        return $this->belongsTo(Batsman::class, 'id', 'player_id');
    }

    public function bowler()
    {
        return $this->belongsTo(Bowler::class, 'id', 'player_id');
    }

    public function tournamentMatches()
    {
        return $this->belongsToMany(TournamentMatch::class, 'batsmen');
    }

    public static function isValid(string $token)
    {
        $current=date('Y-m-d H:i:s');
        return Player::where("token",$token)
                    ->where("expires_at",">=",$current)
                    ->first();
    }

    public static function addPlayer(Request $request,User $user)
    {

       Player::create([
            'slug' => strtolower($user->first_name) . "-" . strtolower($user->last_name),
            'dob'=>$request->dob,
            'state'=>$request->state,
            'specialization'=>$request->specialization,
            'batting_hand'=>$request->batting_hand,
            'balling_hand'=>$request->balling_hand,
            'balling_type'=>$request->balling_type,
            'jersey_number'=>$request->jersey_number,
            'fav_playing_spot'=>$request->fav_playing_spot,
            'user_id'=>$user->id
        ]);

        return 1;

    }

    public static function updatePlayer(Request $request,User $user)
    {

       $user->player->update([
            'slug' => strtolower($user->first_name) . "-" . strtolower($user->last_name),
            'dob'=>$request->dob,
            'state'=>$request->state,
            'specialization'=>$request->specialization,
            'batting_hand'=>$request->batting_hand,
            'balling_hand'=>$request->balling_hand,
            'balling_type'=>$request->balling_type,
            'jersey_number'=>$request->jersey_number,
            'fav_playing_spot'=>$request->fav_playing_spot,
        ]);

        return 1;

    }



    // SCOPE FUNCTIONS
    public function scopeSearch($query, $searchParam) {
        if(isset($searchParam)) {
            $query->whereHas('user', function($q) use($searchParam){
                $q->where('first_name', 'like', "%$searchParam%");
            });
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

    public function scopePlaying($query) {
        return $query->where('is_in_playing_eleven', true);
    }

    public function scopeNotout($query) {
        return $query->where('is_out', false);
    }

    public function scopeOut($query) {
        return $query->where('is_out', true);
    }
}
