<?php
/**
 * File AuthController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AuthResource;

use App\User;


/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules['username'] = 'required';
        $rules['password'] = 'required';

        $validator = Validator::make(request()->all(), $rules);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        $user = User::where('username', $request->username)->where('password', $request->password)->first();

        if (!Auth::loginUsingId($user->id)) {
            return response()->json('login_error', Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        return response()->json(new AuthResource($user), Response::HTTP_OK);
    }

    public function user(Request $request)
    {
        return response()->json( new AuthResource($request->user()) );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return response()->json(true, Response::HTTP_OK);
    }
}
