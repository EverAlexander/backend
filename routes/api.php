<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
/** importar los controllers */
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(
    ['middleware' => ['api', 'throttle:api'], 'prefix' => 'auth'],
    function ($router) {
        Route::post('login', [AuthController::class, 'login']);
    }
);

Route::group(
    ['middleware' => ['api', 'auth:api'], 'prefix' => 'auth'],
    function ($router) {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('userInfo', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    }
);

Route::group(
    [
        'middleware' => ['api']
    ],
    function ($router) {
        //Lista de Crud 
        Route::resource('/role', RoleController::class);
        Route::resource('/users', UsersController::class);
        Route::resource('/marca', MarcaController::class);
        Route::resource('/modelo', ModeloController::class);
    }
);



//Route::group(
//    [
//        'middleware' => ['api']
//    ],
//    function ($router) {
//        /* colocar las rutas de la api*/
        /*Esta forma engloba varias rutas */
//        Route::resource('/department', DepartmentController::class);
        /* solo con la ruta de arriba se engloba estas 4 principales
        asi se evita estar teniendo tantas rutas, cuando solo es crud se puede
        utilizar el resource
        Route::get('/department', [DepartmentController::class, 'index']);
        Route::post('/department', [DepartmentController::class, 'store']);
        Route::put('/department/{id}', [DepartmentController::class, 'update']);
        Route::delete('/department/{id}', [DepartmentController::class, 'destroy']);
        */
        /*pero con esta otra tambien solo que va cada peticion por separado 
        Route::post('logout', [AuthController::class, 'logout']);
        */
        
//    }
//);

Route::get('/status', fn () => response()->json(["message" => "Active"]));
