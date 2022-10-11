<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//  Teacher Auth Controller

class TeacherAuthController extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->guard('teacher_api')->attempt($credentials)) {
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
        return response()->json(auth('teacher_api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('teacher_api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('teacher_api')->refresh());
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
            'expires_in' => auth()->guard('teacher_api')->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:teachers',
            'password' => 'required|string|min:6',
            'address' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Teacher::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'Teacher successfully registered',
            'user' => $user
        ], 201);
    }

    // Teacher Show

        public function index()
       {
        //
         $teacher = Teacher::all();
 
         return response()->json([
         "success" => true,
         "message" => "Teacher List",
         "data" =>  $teacher
        ]);
       }

    // //    Teacher Store

    // public function store(Request $request)
    // {
    //     // 
    //  $input = $request->all();
    //  $validator = Validator::make($input, [
    //     'name' => 'required|string|between:2,100',
    //     'email' => 'required|string|email|max:100|unique:teachers',
    //     'password' => 'required|string|min:6',
    //     'address' => 'required|string|min:6|max:50',
    //  ]);
 
    //   if($validator->fails()){
    //   return $this->sendError('Validation Error.', $validator->errors());       
    // }
 
    //  $teacher = Teacher::create($input);
    //  return response()->json([
    //  "success" => true,
    //  "message" => "Teacher created successfully.",
    //  "data" => $teacher
    //  ]);
    // }

    // // Teacher Show

    //  public function show($id)
    //   {
    //   $teacher = Teacher::find($id);
    //    if (is_null($teacher)) {
    //   return $this->sendError('Teacher not found.');
    //   }
    //      return response()->json([
    //       "success" => true,
    //        "message" => "Teacher retrieved successfully.",
    //        "data" => $teacher
    //      ]);
    //   }



    // //   Teacher Update 

    //   public function update(Request $request,Teacher $teacher)
    //   {
    //       // 
    //  $input = $request->all();
    //  $validator = Validator::make($input, [
    //     'name' => 'required|string|between:2,100',
    //     'email' => 'required|string|email|max:100|unique:teachers',
    //     'password' => 'required|string|min:6',
    //     'address' => 'required|string|min:6|max:50',
    //  ]);
   
    //  if($validator->fails())
    //     {
    //     return $this->sendError('Validation Error.', $validator->errors());       
    //     }
        
    //   $teacher->name = $input['name'];
    //   $teacher->email = $input['email'];
    //   $teacher->password = $input['password'];
    //   $teacher->address = $input['address'];
    //   $teacher->save();
      
    //   return response()->json([
    //   "success" => true,
    //   "message" => "Teacher updated successfully.",
    //   "data" => $teacher
    //   ]);
   
    // }

    // public function update(Request $request,Teacher $teacher)
    // {
    //     $teacher->update($request->only('name','email', 'password', 'address'));

    //     return response()->json([
    //         'message'=>'Teacher Update Successfully',
            
    //     ]);
// }

        public function update(Request $request,$id)
       {
        //
        $teacher= Teacher::find($id);
        $teacher->update($request->all());
        return  $teacher;
       }
    

    // Delete Teacher

    public function delete(Request $request,$id)
      {

        $teacher= Teacher::find($id);
        $teacher->delete($request->all());
    //    return  $course;
       return response()->json([
          "success" => true,
          "message" => "Teacher Deleted successfully.",
          "data" => $teacher
           ]);
    }

}