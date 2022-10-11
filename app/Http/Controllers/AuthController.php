<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

// Admin Controller

class AuthController extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->guard('admin_api')->attempt($credentials)) {
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
        return response()->json(auth('admin_api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('admin_api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('admin_api')->refresh());
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
            'expires_in' => auth()->guard('admin_api')->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


     //  Admin Add Courses

     public function adminaddcourse(Request $request)
     {
        $course = new Course;
        $course->teacher_id=$request->teacher_id;
        $course->course_name=$request->course_name;
        $course->course_title=$request->course_title;
        $course->course_description=$request->course_description;
        $course->save();
    return response()->json([
        'message'=>'Course Create Successfully',
    ]);

     }

    //  public function adminupdatecourse(Request $request,Course $course )
    //  {
    //       // 
    //    $input = $request->all();
    //    $validator = Validator::make($input, [
    //     'teacher_name' => 'required',
    //     'teacher_no' => 'required',
    //      'teacher_address' => 'required'
    //    ]);
 
       
    //   $course->teacher_id = $input['teacher_id'];
    //   $course->course_name = $input['course_name'];
    //   $course->course_title = $input['course_title'];
    //   $course->course_description = $input['course_description'];
    //   $course->save();
 
    //  return response()->json([
    //  "success" => true,
    //  "message" => "Course Updated Successfully.",
    //   "data" => $course
    //   ]);
    // }


    // public function adminupdatecourse(Request $request, $id) 

    // {

    //     $course = Course::find($id);

    //     $course->teacher_id = $request->input('teacher_id');
    //     $course->course_name  = $request->input('course_name');
    //     $course->course_title  = $request->input('course_title');
    //     $course->course_description = $request->input('course_description');
    //     $course->save();

    //     return "Course Updated Successfully" .  $course->id;
    // }   


      //  Admin update Courses

    public function adminupdatecourse(Request $request)
    {
        //
        $course= Course::find($request->teacher_id);
        $course->update($request->all());
        return  $course;

    }


      //  Admin Delete Courses

      public function admindeletecourse(Request $request )
      {

    //   $course->delete($request->teacher_id);
    //   return response()->json([
    //   "success" => true,
    //   "message" => "Course Deleted successfully.",
    //   "data" => $course
    //    ]);

       $course= Course::find($request->teacher_id);
       $course->delete($request->all());
    //    return  $course;
       return response()->json([
          "success" => true,
          "message" => "Course Deleted successfully.",
          "data" => $course
           ]);
      
    }

    // public function admindeletecourse($id)
    // {
    //     //
    //     return Course::destroy($id);
    // }
 

}


