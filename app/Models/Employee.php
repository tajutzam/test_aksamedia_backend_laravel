<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['id'];

    protected $hidden =[
        'created_at' , 'updated_at'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }


}
