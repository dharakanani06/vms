<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $table = 'visitors';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'gender',
        'your_company',
        'national_identification_no',
        'address',
        'select_employee',
        'purpose_id',
        'visit_date',
        'visitor_comefrom',
        'status',

    ];
    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_id');

    }
    public function employees()
    {
        return $this->belongsTo(Employee::class,'select_employee');
    }
}
