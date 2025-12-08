<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role';

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at', 'deleted_at',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public static function allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage)
    {
        return Role::select('role.*', 'role.id as id')

            ->where('role.name', 'like', $search)

            ->skip($skip)
            ->take($itemsPerPage)
            ->orderBy("role.$sortBy", $sort)
            ->get();
    }

    public static function counterPagination($search)
    {
        return Role::select('role.*', 'role.id as id')

            ->where('role.name', 'like', $search)

            ->count();
    }
}
