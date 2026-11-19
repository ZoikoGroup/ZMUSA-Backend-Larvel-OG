<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalPartnership extends Model
{
    use HasFactory;

    protected $fillable = [
        'orgname', 'orgtype', 'focus', 'website', 'street', 'city', 'state', 'zipcode',
        'mission', 'name', 'role', 'email', 'countrycode', 'phone', 'prefcontact',
        'discount', 'support', 'campaign', 'donation', 'volunteer', 'other',
        'supportmission', 'statusproof', 'concent', 'terms', 'updates',
    ];
}
