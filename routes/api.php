<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\AuditsFormController;
use App\Http\Controllers\IconsController;
use App\Http\Controllers\AbilitesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\QtypesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\OptionSetsController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\NaceKodlariController;
use App\Http\Controllers\FirmsController;
use App\Http\Controllers\IlController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QuizController;
use App\Http\Resources\UserResource;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user(); 
    return response()->json(new UserResource(User::findOrFail($user->id)));
});


Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    //return $user->createToken($request->device_name)->plainTextToken;
    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json(['token' => $token], 200);
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    
Route::apiResource('audit_forms',AuditsFormController::class);
Route::resource('audit_forms.sections', SectionController::class)->shallow();
Route::apiResource('icons',IconsController::class);
Route::apiResource('questiontypes',QtypesController::class);
Route::get('getAllPermissionsAttribute', [AbilitesController::class, 'getAllPermissionsAttribute']);
Route::post('addSections', [SectionController::class, 'addSections']);
Route::resource('sections.questions', QuestionsController::class)->shallow();;
Route::post('addQuestion', [QuestionsController::class, 'addQuestion']);
Route::apiResource('optionsets',OptionSetsController::class);
Route::resource('optionsets.options', OptionsController::class)->shallow();
Route::get('firma_form_data',[FirmsController::class, 'formsData']);
Route::get('ana_firmalar',[FirmsController::class, 'getAnaFirmalar']);
Route::get('getFirmsAllData',[FirmsController::class, 'getFirmsAllData']);
Route::apiResource('lokasyonlar',FirmsController::class);
Route::get('il',[IlController::class, 'index']);
Route::resource('roles',RoleController::class);
Route::resource('users',UserController::class);
Route::get('getAllRoles',[RoleController::class, 'getAllRoles']);
Route::apiResource('firmalar',FirmsController::class);
Route::get('il',[IlController::class, 'index']);
Route::resource('audits.forms', QuizController::class);
Route::apiResource('audits',AuditsController::class);
Route::apiResource('nace_kodlari',NaceKodlariController::class);


//sadece süper adminin ulaşabileceği
Route::group(['middleware' => ['role:Super Admin']], function () {
    Route::apiResource('customers',CustomerController::class);
});

Route::get('getAllCustomersWithoutPage',[CustomerController::class,'getAllCustomersWithoutPage']);
Route::get('getAllAuditForms',[AuditsFormController::class, 'getAllAuditForms']);


});

