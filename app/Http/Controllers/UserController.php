<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  public function createUser(Request $request)
{
  try {
      //Validated
      $validateUser = Validator::make($request->all(), [
          'firstName' => 'required',
          'lastName' => 'required',
          'phone' => 'required',
          'address' => 'required',
          'type' => 'required',
          'email' => 'required|email|unique:users,email',
          'password' => 'required'
      ]);

      if ($validateUser->fails()) {
          return response()->json([
              'status' => false,
              'message' => 'Validation error',
              'errors' => $validateUser->errors()
          ], 401);
      }

      $user = User::create([
          'firstName' => $request->firstName,
          'lastName' => $request->lastName,
          'phone' => $request->phone,
          'address' => $request->address,
          'type' => $request->type,
          'email' => $request->email,
          'password' => Hash::make($request->password)
      ]);

      // Fetch paginated list of users
      $users = User::paginate(10); // Adjust the pagination as needed
  $user=['token' => $user->createToken("API TOKEN")->plainTextToken,'user' =>$user];
      return response()->json([
          'status' => true,
          'message' => 'User Created Successfully',
        //  'token' => $user->createToken("API TOKEN")->plainTextToken,
          'data' => $user,
          'pagination' => [
          'current_page' => $users->currentPage(),
          'total_pages' => $users->lastPage(),
          'total_items' => $users->total(),
          'items_per_page' => $users->perPage(),
          'first_item' => $users->firstItem(),
          'last_item' => $users->lastItem(),
          'has_more_pages' => $users->hasMorePages(),
          'next_page_url' => $users->nextPageUrl(),
          'previous_page_url' => $users->previousPageUrl(),
      ],
      ], 200);

  } catch (\Throwable $th) {
      return response()->json([
          'status' => false,
          'message' => $th->getMessage()
      ], 500);
  }
}

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
              'email' => 'required|email',
              'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $users = User::paginate(10); // Adjust the pagination as needed
           $user=['token' => $user->createToken("API TOKEN")->plainTextToken,'user' =>$user];
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
            //   'token' => $user->createToken("API TOKEN")->plainTextToken,
                'data'=>  $user,
                'pagination' => [
                'current_page' => $users->currentPage(),
                'total_pages' => $users->lastPage(),
                'total_items' => $users->total(),
                'items_per_page' => $users->perPage(),
                'first_item' => $users->firstItem(),
                'last_item' => $users->lastItem(),
                'has_more_pages' => $users->hasMorePages(),
                'next_page_url' => $users->nextPageUrl(),
                'previous_page_url' => $users->previousPageUrl(),
            ],

            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
