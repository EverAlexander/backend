<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Leolopez\Encrypt\Facades\Encrypt;

class RoleController extends Controller
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
            $itemsPerPage =  Role::count();
            $skip = 0;
        }

        $sortBy = (isset($request->sortBy[0])) ? $request->sortBy[0] : 'id';
        $sort = (isset($request->sortDesc[0])) ? "asc" : 'desc';

        $search = (isset($request->search)) ? "%$request->search%" : '%%';

        $roles = Role::allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage);
        $roles = Encrypt::encryptObject($roles, "id");

        $total = Role::counterPagination($search);

        return response()->json([
            "message" => "Registros obtenidos correctamente.",
            "data" => $roles,
            "total" => $total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    /*public function create()
    {
        
    }*/

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rol = new Role();

        $rol->name = $request->name;
        $rol->id = $request->id;
        $rol->deleted_at = $request->deleted_at;

        $rol->save();

        return response()->json([
            "message" => "Registro creado correctamente.",
        ]);
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *  @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $data = Encrypt::decryptArray($request->all(), 'id');

        $roles = Role::where('id', $data['id'])->first();
        $roles->name = $request->name;
        $roles->deleted_at = $request->deleted_at;

        $roles->save();

        return response()->json([
            "message" => "Registro modificado correctamente.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        Role::where('id', $request->id)->delete();

        return response()->json([
            "message" => "Registro eliminado correctamente.",
        ]);
    }
}
