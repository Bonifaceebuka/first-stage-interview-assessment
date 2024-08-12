<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Traits\HttpResponseTrait;

class AuthController extends Controller
{
    // This Trait handles the formatting of the JSON response on the app
    use HttpResponseTrait;

    /*
        This method handles the login of a registered user on the app.
        It accepts FORM INPUT REQUEST as input and returns a JSON response 
    */
    public function login(LoginRequest $request)
    {
        $message = null;
        $status_code = null;

        try {
            // Checking if the user submitted email has been registered before the request 
            $user = User::where('email', $request->email)->first();

            // Checks if the $user OBJECT is null -> user was found or not
            if ($user != null) {

                if (Hash::check($request->password, $user->password)) {

                    $token_purose = 'login';
                    $token_time_span = 1;
                    $token_date = 'hours';

                    // Returns a JWT response with some of the user DATA
                    return $this->generate_jwt($token_purose, $token_time_span, $token_date, $user);
                } else {

                    $message = 'User details mismatch';
                    $status_code = 400;
                }
            } else {

                $message = 'User not found';
                $status_code = 404;
            }
            // returns a formatted JSON reponse
            return $this->http_response($message, $status_code);
        } catch (\Exception | \Illuminate\Database\QueryException $e) {

            $message =  $e->getMessage();
            $status_code = 500;
            // returns a formatted JSON reponse
            return $this->http_response($message, $status_code);
        }
    }

    /*
        This method handles the logout of a logged in user on the app.
        It accepts JWT via the header as input and returns a JSON response 
    */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            $message =  'Successfully logged out';
            $status_code = 200;
            return $this->http_response($message, $status_code);
        } catch (\Throwable $th) {
            $message =  'Unable to log you out';
            $status_code = 500;
        }

        // returns a formatted JSON reponse
        return $this->http_response($message, $status_code);
    }

    /*
        This method handles the registration of a new user on the app.
        It accepts FORM INPUT REQUEST as input and returns a JSON response 
    */
    public function signup(RegisterRequest $request)
    {
        $message = null;
        $status_code = null;
        $data = null;
        try {

            // Registering a new user to the DB

            $user = new User([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
            ]);

            $user->save();

            $message = "Your account was successfully created.";
            $status_code = 201;
            // Sending a formatted JSON reponse
        return $this->http_response($message, $status_code, $data);

        } catch (\Exception $e) {

            $message = $e->getMessage();
            $status_code = 500;
                    // Sending a formatted JSON reponse
        return $this->http_response($message, $status_code, $data);

        }
    }

    public function generate_jwt($token_purose, $token_time_span, $token_date, $user)
    {

        switch ($token_date) {
            case 'hours':
                $tokenResult = $user->createToken('access_token', ['*'], Carbon::now()->addHours($token_time_span));
                break;
            case 'weeks':
                $tokenResult = $user->createToken('access_token', ['*'], Carbon::now()->addWeeks($token_time_span));
                break;
            default:
                $tokenResult = $user->createToken('access_token', ['*'], Carbon::now()->addWeeks($token_time_span));
                break;
        }

        $token_data = [
            'result' => true,
            'purpose' => $token_purose,
            'user' => $user,
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
        ];

        return response()->json($token_data);
    }
}
