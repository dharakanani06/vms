<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;
    protected $table = 'loginlogs'; 
    protected $fillable = [
        'user_id',
        'token',
        'org_id',
        'satus',
        'login_timedate',
        'logout_timedate',
    ];
}
