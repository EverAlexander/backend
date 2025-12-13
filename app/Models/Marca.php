<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'marca';

    protected $data = ['deleted_at'];
    
    protected $fillable = [
        'id', 'nombre_marca','descripcion_marca', 'created_at', 'updated_at', 'deleted_at',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public static function allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage)
    {
        return Marca::select('marca.*', 'marca.id as idMarca')

            ->where('marca.nombre_marca', 'like', $search)

            ->skip($skip)
            ->take($itemsPerPage)
            ->orderBy("marca.$sortBy", $sort)
            ->get();
    }

    public static function counterPagination($search)
    {
        return Marca::select('marca.*', 'marca.id as idMarca')

            ->where('marca.nombre_marca', 'like', $search)

            ->count();
    }
}
