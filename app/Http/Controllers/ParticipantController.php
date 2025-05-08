<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    // Apuntarse a un plan
    public function store(Request $request, $planId)
    {
        $userId = Auth::id() ?? 1; // Por simplicidad, user_id=1 si no hay auth
        $plan = Plan::withCount('participants')->findOrFail($planId);
        // Restricción: no duplicados
        if (Participant::where('user_id', $userId)->where('plan_id', $planId)->exists()) {
            return response()->json(['error' => 'Ya estás apuntado a este plan.'], 422);
        }
        // Restricción: capacidad máxima
        if ($plan->participants_count >= $plan->max_participants) {
            return response()->json(['error' => 'El plan ya está completo.'], 422);
        }
        $participant = Participant::create([
            'user_id' => $userId,
            'plan_id' => $planId,
        ]);
        return response()->json($participant, 201);
    }
}
