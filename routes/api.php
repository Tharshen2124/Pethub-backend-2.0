<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\PetController;
use App\Http\Controllers\api\v1\NewsController;
use App\Http\Controllers\api\v1\PostController;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\AdminController;
use App\Http\Controllers\api\v1\ReportController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\AppointmentController;
use App\Http\Controllers\api\v1\ServiceProviderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    // User registration routes
    Route::post('/register', [UserController::class, 'register'])->middleware('guest');
    Route::post('/login', [UserController::class, 'login'])->middleware('guest');
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        
        // user logout route
        Route::post('/petowner/edit/{id}', [UserController::class, 'editPetOwner']);
        Route::post('/logout', [UserController::class, 'logout']);
        
        // user / service provider profile route
        Route::get('/profile', [UserController::class, 'profile']);

        // user pet routes
        Route::apiResource('/pets', PetController::class)->only([
           'index', 'store', 'destroy'
        ]);
        Route::post('/pets/{id}', [PetController::class, 'update']);

        // service provider "healthcare" and "boarders" routes
        Route::get('/healthcare', [ServiceProviderController::class, 'get_healthcare_facilties']);
        Route::get('/boarder', [ServiceProviderController::class, 'get_boarders']);
        Route::get('/healthcare/{spid}', [ServiceProviderController::class, 'moreInfo']);
        
        // user appointment routes
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::post('/appointments/payment_proof/{aptid}', [AppointmentController::class, 'update_with_proof']);
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::get('/appointments/{aptid}', [AppointmentController::class, 'show']);
        
        // service provider appointment routes
        Route::get('/service-provider/appointments/{spref}', [AppointmentController::class, 'sp_index']);
        Route::get('/service-provider/appointments/{spref}/{aptId}', [AppointmentController::class, 'sp_show']);
        Route::put('/service-provider/appointments/{spref}/{aptId}', [AppointmentController::class, 'update']);
        
        // user/service provider News routes
        Route::apiResource('/news', NewsController::class)->only([
            'index', 'show', 'store'
        ]);

        // user/service provider post routes
        Route::apiResource('/posts', PostController::class);

        // user/service provider comment routes
        Route::apiResource('/comments', CommentController::class)->only([
            'store', 'update', 'destroy'
        ]);

        // show all categories for forms route
        Route::get('/categories/post', [CategoryController::class, 'index_post']);
        Route::get('/categories/news', [CategoryController::class, 'index_news']);

        // user/service provider make report routes
        Route::post('/report', [ReportController::class, 'store']);

        // Admin routes
        Route::group(['prefix' => 'admin'], function() 
        {
            // admin service provider application routes
            Route::get('/sp_application', [AdminController::class, 'show_service_provider']);
            Route::get('/sp_application/{spid}', [AdminController::class, 'show_specifc_service_provider']);
            Route::put('/sp_application/{spid}', [AdminController::class, 'service_provider_application']);
            
            // admin news application routes
            Route::get('/news_application', [AdminController::class, 'show_news']);
            Route::get('/news_application/{nid}', [AdminController::class, 'show_specific_news']);
            Route::put('/news_application/{nid}', [AdminController::class, 'news_application']);
            
            // admin report routes
            Route::get('/report', [AdminController::class, 'show_reports']);
            Route::get('/report/{rid}', [AdminController::class, 'show_specific_report']);
            
            // admin user routes
            Route::get('/user', [AdminController::class, 'show_all_users']);
            Route::get('/user/{uid}', [AdminController::class, 'show_specific_user']);
            Route::delete('/user/{uid}', [AdminController::class, 'delete_user']);

            // category manipulation routes
            Route::apiResource('/category', CategoryController::class)->only([
                'store', 'update', 'destroy'
            ]);

        });
    });   
}); 
