<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organization_vms extends Model
{
    use HasFactory;
    protected $table = 'organization_vms'; 
    protected $fillable = [
        'name',
        'email',
        'contact',
        'location',
        'address',
        'contact_person_name',
        'contact_person_email',
        'contact_person_mobile',
        'designation',
        'org_url',
        'logo',
        'satus',
    ];

}
