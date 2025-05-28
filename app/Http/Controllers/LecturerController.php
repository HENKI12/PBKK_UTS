<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        return response()->json(Lecturer::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Jika lecturer_id tidak dikirim, buat otomatis
        if (empty($data['lecturer_id'])) {
            $last = Lecturer::orderBy('lecturer_id', 'desc')->first();
            $number = $last ? intval(substr($last->lecturer_id, 3)) + 1 : 1;
            $data['lecturer_id'] = 'LCT' . str_pad($number, 3, '0', STR_PAD_LEFT);
        }

        $validated = validator($data, [
            'lecturer_id' => 'required|string|unique:lecturers',
            'name' => 'required|string',
            'NIP' => 'required|string|unique:lecturers',
            'department' => 'required|string',
            'email' => 'required|email|unique:lecturers',
        ])->validate();

        $lecturer = Lecturer::create($validated);

        return response()->json($lecturer, 201);
    }

    public function show($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        return response()->json($lecturer);
    }

    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'NIP' => 'sometimes|required|string|unique:lecturers,NIP,' . $id . ',lecturer_id',
            'department' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:lecturers,email,' . $id . ',lecturer_id',
        ]);

        $lecturer->update($validated);

        return response()->json($lecturer);
    }

    public function destroy($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $lecturer->delete();

        return response()->json(['message' => 'Lecturer deleted']);
    }
}
