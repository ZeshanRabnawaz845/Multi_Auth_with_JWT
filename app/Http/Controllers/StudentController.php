<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$students = Student::all();
		 
		return response()->json([
			"success" => true,
			"message" => "Student List",
			"data" => $students
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
		
		$student = Student::create($input);
		return response()->json([
			"success" => true,
			"message" => "Student created successfully.",
			"data" => $student
		]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$student = Student::find($id);
		if (is_null($student)) 
        {
			return $this->sendError('Student not found.');
		}
		return response()->json([
			"success" => true,
			"message" => "Student retrieved successfully.",
			"data" => $student
		]);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Student $student)
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
		
		$student->name = $input['name'];
		$student->address = $input['address'];
		$student->save();
		
		return response()->json([
			"success" => true,
			"message" => "Student updated successfully.",
			"data" => $student
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
		$student->delete();
		return response()->json([
			"success" => true,
			"message" => "Student deleted successfully.",
			"data" => $student
		]);
    }
}