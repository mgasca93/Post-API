<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\UserRegisterRequest;
use Illuminate\Support\Facades\Hash;

/**
* @OA\Info(title="API Post", version="1.0.0")
*
* @OA\SecurityScheme(type="http", securityScheme="bearerAuth", scheme="bearer", bearerFormat="JWT")
*
* @OA\Server(url="https://api.test/public/api/v1")
*/

class UserController extends Controller
{

    /**
     * @OA\Get(
     *      path="/users",
     *      summary="Get all user and paginate list",
     *      tags={"Users"},
     *      @OA\RequestBody(
     *          description="A JSON object containing user information",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Users retrieved successfully" 
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Failed to get user"
     *      )
     * )
     */
    public function index()
    {
        try{
            $users = User::paginate(10);

            return response()->json([
                'status' => 'success',
                'message' => 'Users retrieved successfully',
                'data' => $users
            ], Response::HTTP_OK);

        }catch( Exception $e ){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to get user'
            ], Response::HTTP_CONFLICT);
        }
    }

     /**
     * @OA\Post(
     *      path="/user/create",
     *      summary="Store a new user",
     *      tags={"Users"},
     *      operationId="addUser",
     *      @OA\RequestBody(
     *          description="A JSON object containing user information",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="first_name",
     *          description="The first name of user",
     *          required=true,
     *          in="query",
     *          example="Jhon",
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),   
     *      @OA\Parameter(
     *          name="last_name",
     *          description="The last name of user",
     *          required=true,
     *          in="query",
     *          example="Doe",
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ), 
     *      @OA\Parameter(
     *          name="email",
     *          description="E-mail by the user login",
     *          required=true,
     *          in="query",
     *          example="jhondoe@example.com",
     *          @OA\Schema(
     *              type="string",
     *          ),*          
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Password by the user login",
     *          required=true,
     *          in="query",
     *          example="12345678",
     *          @OA\Schema(
     *              type="string",
     *          ),*          
     *      ), 
     *      @OA\Parameter(
     *          name="password_confirmation",
     *          description="Confirm assword",
     *          required=true,
     *          in="query",
     *          example="12345678",
     *          @OA\Schema(
     *              type="string",
     *          ),*          
     *      ),     
     *      @OA\Response(
     *          response=201,
     *          description="User created with success" 
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Failed to set user"
     *      )
     * )
     */
    public function store(UserRegisterRequest $request)
    {
        try{
            
            $user = User::create([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'password'      => Hash::make( $request->password ),
            ]);

            return response()->json([
                'status'            => 'success',
                'message'           => 'User created with success',
                'data'              => $user,
            ], Response::HTTP_CREATED);

        }catch( Exception $e ){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to set user.'
            ], Response::HTTP_CONFLICT);
        }        
    }
}
