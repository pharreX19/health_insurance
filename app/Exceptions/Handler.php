<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception){
        
        if($request->wantsJson()){
            return $this->handleApiException($request, $exception);
        }
    }

    private function handleApiException($request, $exception){
        $exception = $this->prepareException($exception);

        if($exception instanceof HttpResponseException){
            $exception = $exception->getResponse();
        }
        
        if($exception instanceof AuthenticationException){
            $exception = $this->unauthenticated($request, $exception);
        }

        if($exception instanceof ValidationException){
            $exception = $this->invalidJson($request, $exception);
        }        
        return $this->customApiResponse($exception);
    }


    private function customApiResponse($exception){
        

        if(method_exists($exception, 'getStatusCode')){
            $statusCode = $exception->getStatusCode();

        }else{
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        switch($statusCode){
            case 401:
                $response['message'] = Response::$statusTexts[$statusCode];
                break;

            case 403:
                $response['message'] = Response::$statusTexts[$statusCode];
                break;

            case 404:
                $response['message'] = Response::$statusTexts[$statusCode];
                break;

            case 405: 
                $response['message'] = Response::$statusTexts[$statusCode];
                break;
            
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            
            default:
                $response['message'] = $statusCode == 500 ? 'Whoops, looks like something went wrong': $exception->getMessage();
        }


        if(!config('app.debug')){
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
        }

        $response['status'] = $statusCode;
        return response()->json($response, $statusCode);
    }


}
