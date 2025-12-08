<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'department';

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id', 'department_name', 'min_dpto', 'may_dpto', 'cod_dpto', 'deleted_at', 'created_at', 'updated_at', 
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public static function allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage)
    {
        return Department::select('department.*', 'department.id as id')
        
		->where('department.department_name', 'like', $search)
		->orWhere('department.min_dpto', 'like', $search)
		->orWhere('department.may_dpto', 'like', $search)
		->orWhere('department.cod_dpto', 'like', $search)

        ->skip($skip)
        ->take($itemsPerPage)
        ->orderBy("department.$sortBy", $sort)
        ->get();
    }

    public static function counterPagination($search)
    {
        return Department::select('department.*', 'department.id as id')
        
		->where('department.department_name', 'like', $search)
		->orWhere('department.min_dpto', 'like', $search)
		->orWhere('department.may_dpto', 'like', $search)
		->orWhere('department.cod_dpto', 'like', $search)

        ->count();
    }
}
