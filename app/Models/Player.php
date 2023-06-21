<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory;
    protected $guarded=['id'];
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
}
