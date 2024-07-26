<?php
namespace App\Http\Traits;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HttpResponseTrait{

    public function http_response($message=null, $status_code=null, $data=null)
    {
          if($status_code < 100){
            $message = "Inavlid HTTP Status Code";
            $status_code = 500;
          }

          return response()->json([
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }
    
    public function failedFormValidationResponse($validator)
    {
        return new HttpResponseException(response([
          'status_code' => 400,
          'message' => $validator->errors()->toArray(),
          'data'=>null,
      ]), Response::HTTP_UNPROCESSABLE_ENTITY);
      
    }
}