<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'movie_id',
        'start_time',
        'end_time'
    ];

    protected $dates = [
        'start_time',
        'end_time'
    ];

    public function Movies()
    {
        return $this->belongsTo(Movie::class);
    }
}
