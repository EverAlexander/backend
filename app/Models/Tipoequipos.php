<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipoequipos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_equipo';
    protected $data = ['deleted_at'];
    protected $fillable = [
        'id', 'nombre_tipo_equipo','descripcion_tipo_equipo', 'created_at', 'updated_at', 'deleted_at',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public static function allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage)
    {
        return Tipoequipos::select('type.*', 'type.id as idType')

            ->where('type.nombre_tipo_equipo', 'like', $search)

            ->skip($skip)
            ->take($itemsPerPage)
            ->orderBy("type.$sortBy", $sort)
            ->get();
    }

    public static function counterPagination($search)
    {
        return Tipoequipos::select('type.*', 'type.id as idType')

            ->where('type.nombre_tipo_equipo', 'like', $search)

            ->count();
    }
}
