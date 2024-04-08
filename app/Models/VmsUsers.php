<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmsUsers extends Model
{
    use HasFactory;
    protected $table = 'vms_users';
    protected $fillable = [
        'username',
        'password',
        'email',
        'mobile',
        'designation',
        'role',
        'org_id',
        'status',

    ];
}
