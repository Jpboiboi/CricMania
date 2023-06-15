<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function playerstats()
    {
        return $this->hasMany(PlayerStat::class);
    }
}
