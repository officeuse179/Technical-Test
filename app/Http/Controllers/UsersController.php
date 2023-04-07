<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interest;
use App\Models\UserInterests;

class UsersController extends Controller
{ 
    // user profile
    public function userprofile($id)
    {
        // using joins
        $user = UserInterests::join('users', 'users.id', '=', 'user_interests.user_id')
            ->join('interests', 'interests.id', '=', 'user_interests.interest_id')
            ->where('users.id', $id)
            ->where('user_interests.status',1)
            ->select('users.*')
            ->groupBy('users.id')
            ->get();

        $response = [
            'success' => true,
            'data' => $user,
            'message' => 'User profile details'
        ];

        // return the success message
        return response()->json($response, 200);
    }
}
