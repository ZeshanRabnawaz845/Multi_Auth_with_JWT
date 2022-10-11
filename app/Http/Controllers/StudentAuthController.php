<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//  Student Auth Controller

class StudentAuthController extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->guard('student_api')->attempt($credentials)) 
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('student_api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('student_api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('student_api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('student_api')->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:students',
            'password' => 'required|string|min:6',
            'address' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $student = Student::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'Student successfully registered',
            'user' => $student
        ], 201);
    }

    //  Update Student 

    public function update(Request $request,$student_id)
    {
        //
        $student= Student::find($student_id);
        $student->update($request->all());
        return $student;

    }

    // Student Delete

    public function delete(Request $request,$id )
    {

        $student= Student::find($id);
        $student->delete($request->all());
       //    return  $course;
          return response()->json([
        "success" => true,
        "message" => "Student Deleted successfully.",
        "data" =>  $student
         ]);
    
  }

    
}