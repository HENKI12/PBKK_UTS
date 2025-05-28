<?php

namespace App\Http\Controllers;

use App\Models\Enrollment2;
use Illuminate\Http\Request;

class Enrollment2Controller extends Controller
{
    public function index()
    {
        $enrollments = Enrollment2::with(['student', 'course'])->get();
        return response()->json($enrollments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|string|unique:enrollment2s',
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'grade' => 'required|string',
            'attendance' => 'required|string',
            'status' => 'required|string',
        ]);

        $enrollment = Enrollment2::create($request->all());
        return response()->json($enrollment, 201);
    }

    public function show($id)
    {
        $enrollment = Enrollment2::with(['student', 'course'])->findOrFail($id);
        return response()->json($enrollment);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment2::findOrFail($id);

        $request->validate([
            'student_id' => 'sometimes|exists:students,student_id',
            'course_id' => 'sometimes|exists:courses,course_id',
            'grade' => 'sometimes|string',
            'attendance' => 'sometimes|string',
            'status' => 'sometimes|string',
        ]);

        $enrollment->update($request->all());
        return response()->json($enrollment);
    }

    public function destroy($id)
    {
        Enrollment2::destroy($id);
        return response()->json(['message' => 'Enrollment deleted']);
    }
}
