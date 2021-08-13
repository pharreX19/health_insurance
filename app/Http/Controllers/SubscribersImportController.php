<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SubscriberImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\V1\AbstractController;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use Maatwebsite\Excel\Validators\ValidationException;

class SubscribersImportController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // dd(request()->all());
        // throw ValidationValidationException::withMessages([
        //     'error' => json_decode(request()->plan_id)
        // ]);
        

        if($request->hasFile('subscribers')){
            try{
                Excel::import(new SubscriberImport, $request->file('subscribers'));
                return $this->respondSuccess(null, 'Data imported Successfully', Response::HTTP_CREATED);
            }catch(ValidationException $ex){
                return  $this->respondError([
                    'message' => 'File upload failed',
                    'errors' => $ex->failures()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }else{
            throw ValidationValidationException::withMessages([
                'error' => [
                    'message' => 'No file named [\'subscribers\'] found to upload'
                ]
            ]);
        }
    }
}
