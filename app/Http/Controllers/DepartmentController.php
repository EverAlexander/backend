<?php

namespace App\Http\Controllers;

use App\Models\Department;

use Illuminate\Http\Request;
use Encrypt;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage ?? 10;
        $skip = ($request->page - 1) * $request->itemsPerPage;

        // Getting all the records
        if (($request->itemsPerPage == -1)) {
            $itemsPerPage =  Department::count();
            $skip = 0;
        }

        $sortBy = (isset($request->sortBy[0])) ? $request->sortBy[0] : 'id';
        $sort = (isset($request->sortDesc[0])) ? "asc" : 'desc';

        $search = (isset($request->search)) ? "%$request->search%" : '%%';

        $department = Department::allDataSearched($search, $sortBy, $sort, $skip, $itemsPerPage);
        $department = Encrypt::encryptObject($department, "id");

        $total = Department::counterPagination($search);

        return response()->json([
            "message"=>"Registros obtenidos correctamente.",
            "data" => $department,
            "total" => $total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $department = new Department;

		$department->department_name = $request->department_name;
		$department->min_dpto = $request->min_dpto;
		$department->may_dpto = $request->may_dpto;
		$department->cod_dpto = $request->cod_dpto;
		$department->deleted_at = $request->deleted_at;

        $department->save();

        return response()->json([
            "message"=>"Registro creado correctamente.",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Encrypt::decryptArray($request->all(), 'id');

        $department = Department::where('id', $data['id'])->first();
		$department->department_name = $request->department_name;
		$department->min_dpto = $request->min_dpto;
		$department->may_dpto = $request->may_dpto;
		$department->cod_dpto = $request->cod_dpto;
		$department->deleted_at = $request->deleted_at;

        $department->save();

        return response()->json([
            "message"=>"Registro modificado correctamente.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = Encrypt::decryptValue($request->id);

        Department::where('id', $id)->delete();

        return response()->json([
            "message"=>"Registro eliminado correctamente.",
        ]);
    }
}
