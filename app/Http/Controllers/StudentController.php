<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Get all students
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    // Get a single student
    public function show($student_id)
    {
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json($student);
    }

    // Create new student (manual or auto student_id)
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|string|max:20|unique:students,student_id',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:students',
            'NIM' => 'required|string|max:50|unique:students',
            'major' => 'required|string',
            'enrollment_year' => 'required|date',
        ]);

        // Use provided student_id or generate one
        if ($request->filled('student_id')) {
            $studentId = $request->student_id;
        } else {
            $lastStudent = Student::where('student_id', 'like', 'STD' . date('Y') . '%')
                                  ->orderBy('student_id', 'desc')
                                  ->first();
            $nextNumber = $lastStudent ? ((int)substr($lastStudent->student_id, -4)) + 1 : 1;
            $studentId = 'STD' . date('Y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        // Create student
        $studentData = $request->all();
        $studentData['student_id'] = $studentId;

        $student = Student::create($studentData);

        return response()->json($student, 201);
    }

    // Update existing student
    public function update(Request $request, $student_id)
    {
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'email' => 'email|max:50|unique:students,email,' . $student_id . ',student_id',
            'NIM' => 'string|max:50|unique:students,NIM,' . $student_id . ',student_id',
            'name' => 'string|max:50',
            'major' => 'string',
            'enrollment_year' => 'date',
        ]);

        $student->update($request->all());
        return response()->json($student);
    }

    // Delete a student
    public function destroy($student_id)
    {
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();
        return response()->json(['message' => 'Student deleted']);
    }
}
