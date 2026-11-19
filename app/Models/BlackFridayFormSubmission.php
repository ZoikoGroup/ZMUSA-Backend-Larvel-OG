<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackFridayFormSubmission extends Model
{
    use HasFactory;

    protected $table = 'black_friday_form_submissions';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'company',
        'phone',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
