<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(!$user = JWTAuth::parseToken()->authenticate()){
        //     return response()->json([
        //         'message' => 'User not found'
        //     ], 404);
        // }

        // return response()->json([
        //     'data' => $user_details
        // ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Retrieve records
        $name               = $request->input('name');
        $email              = $request->input('email');
        $password           = bcrypt($request->input('password'));

        // Validate

        // Create one instance of users
        $user               = new User();
        $user->name         = $name;
        $user->email        = $email;
        $user->password     = $password;    
        $user->save();
        
        return response()->json([
            'message' => 'User successfully added'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function assignRoles(Request $request){

        // // Get the roles
        // $role               = $request->input('role');

        // // Retrieve admin role
        // $adminRole          = Role::where('description', '=', $role)->first();

        // // Retrieve the user
        // $user               = User::find(1);

        // // Attach the role
        // $user->roles()->attach($adminRole->id);

        // return response()->json([
        //     'role' => 'New role successfully attached'
        // ], 201);

    }

    // Sign in method 
    public function signin(Request $request)
    {
        // Retrieve inputs from the request
        $email          = $request->input('email');
        $password       = $request->input('password');

        // Validate

        // Authenticate
        $credentials    = $request->only('email', 'password');
        try {
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'error' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e){
            return response()->json([
                'error' => 'Authentication failed'
            ], 500);
        }

        // Retrieve users
        $user           = User::where('email', $email)
                                ->with('roles')
                                ->first();

        return response()->json([
            'token' => $token,
            'user'  => $user
        ], 200);
    }
}
