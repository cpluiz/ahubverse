<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastSuggestion extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_channel_user_id',
        'to_channel_name',
        'last_suggestion',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'from_channel_user_id' => 'integer',
        'last_suggestion' => 'datetime'
    ];
}
