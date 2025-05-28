<?php

namespace App\Http\Controllers;

use App\Models\CourseLecturer;
use Illuminate\Http\Request;

class CourseLecturerController extends Controller
{
    public function index()
    {
        return response()->json(
            CourseLecturer::with(['course', 'lecturer'])->get()
        );
    }

    public function show($id)
    {
        $data = CourseLecturer::with(['course', 'lecturer'])->find($id);
        return $data
            ? response()->json($data)
            : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:course_lecturers,id',
            'course_id' => 'required|exists:courses,course_id',
            'lecturer_id' => 'required|exists:lecturers,lecturer_id',
            'role' => 'required|string',
        ]);

        $data = CourseLecturer::create($request->all());
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $data = CourseLecturer::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'course_id' => 'sometimes|exists:courses,course_id',
            'lecturer_id' => 'sometimes|exists:lecturers,lecturer_id',
            'role' => 'sometimes|string',
        ]);

        $data->update($request->all());
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = CourseLecturer::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
