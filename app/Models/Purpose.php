<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;
    protected $table = 'purpose';
    protected $fillable = [
        'title',
        'added_by',
        'org_id',
        'status',

    ];
}
