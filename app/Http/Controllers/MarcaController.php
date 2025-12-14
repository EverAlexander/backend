<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Leolopez\Encrypt\Facades\Encrypt;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage ?? 10;
        $skip = ($request->page - 1) * $request->itemsPerPage;

        // Getting all the records
        if (($request->itemsPerPage == -1)) {
            $itemsPerPage =  Marca::count();
            $skip = 0;
        }

        $sortBy = (isset($request->sortBy[0])) ? $request->sortBy[0] : 'id';
        $sort = (isset($request->sortDesc[0])) ? "asc" : 'desc';

        $search = (isset($request->search)) ? "%$request->search%" : '%%';

        $marcas = Marca::allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage);
        $marcas = Encrypt::encryptObject($marcas, "id");

        $total = Marca::counterPagination($search);

        return response()->json([
            "message" => "Registros obtenidos correctamente.",
            "data" => $marcas,
            "total" => $total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $marca = new Marca();

        $marca->nombre_marca = $request->nombre_marca;
        $marca->descripcion_marca = $request->descripcion_marca;
        $marca->id = $request->id;
        $marca->deleted_at = $request->deleted_at;
        $marca->save();

        return response()->json([
            "message" => "Registro creado correctamente.",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = Encrypt::decryptArray($request->all(), 'id');

        $marca = Marca::where('id', $data['id'])->first();
        $marca->nombre_marca = $request->nombre_marca;
        $marca->descripcion_marca = $request->descripcion_marca;
        $marca->deleted_at = $request->deleted_at;

        $marca->save();

        return response()->json([
            "message" => "Registro modificado correctamente.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = Encrypt::decryptValue($request->id);
        Marca::where('id', $id)->delete();

        return response()->json([
            "message"=>"Registro eliminado correctamente.",
        ]);
    }
}
