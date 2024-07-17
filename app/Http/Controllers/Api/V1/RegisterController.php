<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\UserRegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
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
                'message'       => 'Failed to set user.'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Store a newly created resource in storage.
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

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
