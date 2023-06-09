<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function organizer() {
        return $this->belongsTo(User::class, 'organizer_id');
    }
}
