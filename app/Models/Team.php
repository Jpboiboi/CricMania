<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getImagePathAttribute() {
        return '/storage/'.$this->attributes['image_path'];
    }


    public function tournament(){
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }
}
