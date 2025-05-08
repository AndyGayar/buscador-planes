<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    // Listar todos los planes
    public function index()
    {
        $plans = Plan::with(['creator', 'participants.user'])->get();
        return response()->json($plans);
    }

    // Mostrar detalles de un plan
    public function show($id)
    {
        $plan = Plan::with(['creator', 'participants.user'])->findOrFail($id);
        return response()->json($plan);
    }

    // Crear un nuevo plan
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'required|integer|min:1',
        ]);
        $data['user_id'] = Auth::id() ?? 1; // Por simplicidad, user_id=1 si no hay auth
        $plan = Plan::create($data);
        return response()->json($plan, 201);
    }
}
