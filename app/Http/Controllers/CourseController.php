<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|string|unique:courses',
            'name' => 'required|string',
            'code' => 'required|string',
            'credits' => 'required|integer',
            'semester' => 'required|string',
        ]);

        $course = Course::create($validated);

        return response()->json($course, 201);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'code' => 'sometimes|required|string',
            'credits' => 'sometimes|required|integer',
            'semester' => 'sometimes|required|string',
        ]);

        $course->update($validated);

        return response()->json($course);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}
