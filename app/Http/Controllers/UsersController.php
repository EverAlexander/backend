<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Leolopez\Encrypt\Facades\Encrypt;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage ?? 10;
        $page = $request->page ?? 1;

        $sortBy = $request->sortBy[0] ?? 'id';
        $sort = (isset($request->sortDesc[0]) && $request->sortDesc[0]) ? 'desc' : 'asc';

        $search = $request->search ?? '';

        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        if ($itemsPerPage == -1) {
            $users = $query->orderBy($sortBy, $sort)->get();
        } else {
            $users = $query->orderBy($sortBy, $sort)
                ->skip(($page - 1) * $itemsPerPage)
                ->take($itemsPerPage)
                ->get();
        }

        // Formateamos y encriptamos id
        $users = $users->map(function ($user) {
            return $user->format();
        });

        $total = $query->count();

        return response()->json([
            "message" => "Registros obtenidos correctamente.",
            "data" => $users,
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
        $users = new User();

        $users->name = $request->name;
        $users->email = $request->email;
        $users->id = $request->id;
        $users->deleted_at = $request->deleted_at;

        $users->save();

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

        $modelos = User::where('id', $data['id'])->first();
        $modelos->role_id = $request->idRol;
        
        $modelos->deleted_at = $request->deleted_at;

        $modelos->save();

        return response()->json([
            "message" => "Registro modificado correctamente.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
