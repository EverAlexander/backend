<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Leolopez\Encrypt\Facades\Encrypt;

class Modelo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'modelo';

    protected $data = ['deleted_at'];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'id', 'nombre_modelo','descripcion_modelo', 'created_at', 'updated_at', 'deleted_at',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca_fk');
    }

    public static function allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage)
    {
        return Modelo::select('modelo.*', 'modelo.id as idModelo')

            ->where('modelo.nombre_modelo', 'like', $search)

            ->skip($skip)
            ->take($itemsPerPage)
            ->orderBy("modelo.$sortBy", $sort)
            ->get();
    }

    public static function counterPagination($search)
    {
        return Modelo::select('modelo.*', 'modelo.id as idModelo')

            ->where('modelo.nombre_modelo', 'like', $search)

            ->count();
    }
    
    public function format()
    {
        return [
            'id' => Encrypt::encryptValue($this->id) ?? null,
            'idModelo' => $this->idModelo,
            'nombre' => $this?->nombre_modelo,
            'descripcion' => $this?->descripcion_modelo,
            'marca' => $this?->marca?->nombre_marca,
            'idMarca' => $this?->id_marca_fk,
            'created_at' => $this?->created_at
        ];
    }


}
