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

    // SCOPE FUNCTIONS
    public function scopeSearch($query, $searchParam) {
        if(isset($searchParam)) {
            $query->where('name', 'like', "%$searchParam%");
        }
        return $query;
    }

    public function scopeLimit_by($query, $start, $length) {
        if($length != -1) {
            $query->offset($start)->limit($length);
        }
        return $query;
    }
}
