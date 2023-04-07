<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserInterests;
use Illuminate\Support\Facades\Hash;

use Validator;

class AuthController extends Controller
{
    // user register
    public function register(Request $request)
    {
        $users = User::all(); 

        // if user greater than 12 did not register more than 12
        if (count($users)>12) {
            $response = [
                'success' => false,
                'message' => 'Only 12 users are allowed to register'
            ];

            return response()->json($response, 400);
        }

        // validate the fields
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^\w+[-\.\w]*@(?!(?:outlook|myemail|yahoo)\.com$)\w+[-\.\w]*?\.\w{2,4}$/'
            ],
            'password' => 'required',
            'confirmpassword' => 'required|same:password',
            'address' => 'required',
            'dob' => 'required',
            "interests.*"  => "required|string|distinct|min:1"
        ]);

        // if any field validation is false
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            // return the error message
            return response()->json($response, 400);
        }

        // call user modal
        $user = new User;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->address = $request->input('address');
        $user->dob = date("Y-m-d", strtotime($request->input('dob')));
        // save in database
        if ($user->save()) {
            // get inserted id
            $last_inserted_id = $user->id;

            $interests = $request->input('interests[]');
            foreach ($interests as $key => $value) {
                $userinterests = new UserInterests;
                $userinterests->user_id = $last_inserted_id;
                $userinterests->interest_id = $value;
                // save in database
                $userinterests->save();
            }

            // create token
            $success['token'] = $user->createToken('my-app-token')->plainTextToken;
            $success['token_type'] = 'Bearer';
            $success['name'] = $user->first_name.' '.$user->last_name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User register successfully'
            ];

            // return the success message
            return response()->json($response, 200);
        }else {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. please try again.'
            ];

            // return the error message
            return response()->json($response, 400);
        }
    }

    // user login
    public function login(Request $request)
    {
        // validate the fields
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        // if any field validation is false
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            // return the error message
            return response()->json($response, 400);
        }

        // check the is availabe in database user tabel
        $user= User::where('email', $request->email)->first();

        // if user credentials not match
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'success' => false,
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
        
        // create token and return with user records
        $success['id'] = $user->id;
        $success['name'] = $user->first_name.' '.$user->last_name;
        $success['email'] = $user->email;
        $success['address'] = $user->address;
        $success['dob'] = $user->dob;
        $success['token'] = $user->createToken('my-app-token')->plainTextToken;
        $success['token_type'] = 'Bearer';
        
        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User login successfully'
        ];

        // return the success message
        return response()->json($response, 200);

    }
}
