<?php

namespace App\Http\Controllers;
 
use App\Models\Teacher;
use Illuminate\Http\Request;
use Validator;
 
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
 
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // 
 $input = $request->all();
 $validator = Validator::make($input, [
 'name' => 'required',
 'address' => 'required'
 ]);
 
 if($validator->fails()){
 return $this->sendError('Validation Error.', $validator->errors());       
 }
 
 $teacher = Teacher::create($input);
 return response()->json([
 "success" => true,
 "message" => "Teacher created successfully.",
 "data" => $teacher
 ]);
    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher $student
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
  $teacher = Teacher::find($id);
 if (is_null($teacher)) {
 return $this->sendError('Teacher not found.');
 }
 return response()->json([
 "success" => true,
 "message" => "Teacher retrieved successfully.",
 "data" => $teacher
 ]);
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Teacher $teacher)
    {
        // 
 $input = $request->all();
 $validator = Validator::make($input, [
    'name' => 'required',
    'address' => 'required'
 ]);
 
 if($validator->fails()){
 return $this->sendError('Validation Error.', $validator->errors());       
 }
 
 $teacher->name = $input['name'];
 $teacher->address = $input['address'];
 $teacher->save();
 
 return response()->json([
 "success" => true,
 "message" => "Teacher updated successfully.",
 "data" => $teacher
 ]);
 
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
 $teacher->delete();
 return response()->json([
 "success" => true,
 "message" => "Teacher deleted successfully.",
 "data" => $teacher
 ]);
    }
}
?>