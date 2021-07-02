<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PlansController;
use App\Http\Controllers\Api\V1\PlanServicesController;
use App\Http\Controllers\Api\V1\EpisodesController;
use App\Http\Controllers\Api\V1\ServicesController;
use App\Http\Controllers\Api\V1\CompaniesController;
use App\Http\Controllers\Api\V1\EpisodeServicesController;
use App\Http\Controllers\Api\V1\PlanServiceLimitGroupsController;
use App\Http\Controllers\Api\V1\PoliciesController;
use App\Http\Controllers\Api\V1\ServiceLimitGroupCalculationTypesController;
use App\Http\Controllers\Api\V1\SubscribersController;
use App\Http\Controllers\Api\V1\ServiceTypesController;
use App\Http\Controllers\Api\V1\SubscriptionsController;
use App\Http\Controllers\Api\V1\ServiceLimitGroupsController;
use App\Http\Controllers\Api\V1\ServiceProvidersController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    //CRUD OPERATIONS
    Route::apiResource('/plans', PlansController::class);
    Route::apiResource('/services', ServicesController::class);
    Route::apiResource('/service-limit-groups', ServiceLimitGroupsController::class);
    Route::apiResource('/service-types', ServiceTypesController::class);
    Route::apiResource('/subscribers', SubscribersController::class);
    Route::apiResource('/companies', CompaniesController::class);
    Route::apiResource('/policies', PoliciesController::class);
    Route::apiResource('/service-providers', ServiceProvidersController::class);
    Route::apiResource('/service-limit-group-calculations', ServiceLimitGroupCalculationTypesController::class);
    Route::apiResource('/episodes', EpisodesController::class);

    //ADD, UPDATE AND REMOVE SERVICES FROM EPISODE
    Route::apiResource('/episode-services', EpisodeServicesController::class)->only(['store', 'update', 'destroy']);

    
    //ADD, UPDATE AND REMOVE SERVICES TO/FROM PLAN
    Route::post('/plans/{plan}/services/{service}/add', [PlanServicesController::class, "store"]);
    Route::patch('/plans/{plan}/services/{service}/update', [PlanServicesController::class, "update"]);
    Route::delete('/plans/{plan}/services/{service}/remove', [PlanServicesController::class, "delete"]);

    //ADD, UPDATE AND REMOVE SERVICE-LIMIT-GROUPS TO/FROM PLAN
    Route::post('/plans/{plan}/service-limit-groups/{serviceLimitGroup}/add', [PlanServiceLimitGroupsController::class, "store"]);
    Route::patch('/plans/{plan}/service-limit-groups/{service-limit-group}/update', [PlanServiceLimitGroupsController::class, "update"]);
    Route::delete('/plans/{plan}/service-limit-groups/{servicelimit-group}/remove', [PlanServiceLimitGroupsController::class, "delete"]);
    
    //APPROVE REJECT EPISODE CLAIMS
    /////
    ////

    
    //CREATE NEW SUBSCRIPTION, RENEW AND DELETE SUBSCRIPTION
    Route::apiResource('/subscriptions', SubscriptionsController::class)->only(['store', 'update', 'destroy']);
    
    //SEARCH SUBSCRIBERS BY THEIR ID
    Route::get('/subscribers/search/{identification}', [SubscribersController::class, 'search']);
    
    // Route::post('/episodes/{episode}/services/{service}/add', [EpisodeServicesController::class, "store"]);
    // Route::patch('/episodes/{episode}/services/{service}/update', [EpisodeServicesController::class, "update"]);
    // Route::delete('/episodes/{episode}/services/{service}/remove', [EpisodeServicesController::class, "delete"]);
    //---------
    //plan-service-limit-group
    //users
    //

    //----------

    //SUBSCRIBE TO A SERVICE AND DELETE SERVICE SUBSCRIPTION
    // Route::post('/subscribers/{subscriber}/services/{service}', [ServicesSubscriptionController::class, 'post']);
    
    
    //DELETE CURRENT ACTIVE SUBSCRIPTION
    // Route::patch('/subscribers/{subscriber}/plans/{plan}', [SubscriptionsController::class, 'unsubscribe']);

    // Route::post('subscribers/{subscriber}/plans/{plan}', [SubscriptionController::class, 'subscribe']);
    // Route::delete('subscribers/{subscriber}/plans/{plan}', [SubscriptionController::class, 'unsubscribe']);
    // Route::patch('subscribers/{subscriber}/plans/{plan}', [SubscriptionController::class, 'renewSubscription'])
        // ->missing(function(Request $request){
        //     if($request->wantsJson()){
        //         $response["status_code"] = Response::HTTP_NOT_FOUND;

        //         if(!$request->route('subscriber') instanceof Model){
        //             $response["message"] = "Selected subscriber not found";
        //         }

        //         else if(!$request->route('plan') instanceof Model){
        //             $response["message"] = "Selected plan not found";  
        //         }

        //         return response()->json($response, Response::HTTP_NOT_FOUND);
        //     }
        // });

    // Route::delete('/subscribers/{subscriber}/services/{service}', [ServicesSubscriptionController::class, 'removeServiceRequest']);

});
