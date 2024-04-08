<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function departments()
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }

    public function designations()
    {
        return $this->belongsTo(Designation::class, 'designations_id');
    }
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        'name',
        'email',
        'gender',
        'phone_number',
        'address',
        'country',
        'city',
        'state',
        'date_of_birth',
        'role',
        'image',
        'departments_id',
        'designations_id',
        'satus',

    ];
}
