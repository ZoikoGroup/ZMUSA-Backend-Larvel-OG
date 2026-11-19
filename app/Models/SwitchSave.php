<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchSave extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname', 'email', 'msisdn', 'simno', 'plan', 'cat',
        'ospno', 'osppass', 'addr1', 'addr2', 'city', 'state',
        'zip', 'concent', 'terms'
    ];
}
