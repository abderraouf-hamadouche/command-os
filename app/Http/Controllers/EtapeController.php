<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intervention;
use App\Models\Etape;

class EtapeController extends Controller
{
    //

    public function store(Request  $request)
    {

        $validated = $request->validate([
            'intervention_id' => 'required|integer|exists:interventions,id',
            'commande_id' => 'required|integer|exists:commands,id',
            'parametre_id' => 'required|integer|exists:parametres,id',
            'note' => 'required|string|max:150',
        ]);
        // Find the parent intervention
        $intervention = Intervention::findOrFail($validated['intervention_id']);
        // 2. Create the new step
        // Note: Make sure your Etape model has these fields in the $fillable array!
        $maxPosition = $intervention->etapes()->max('position');

        $etape = Etape::create([
            'intervention_id' => $intervention->id,
            'commande_id' => $validated['commande_id'],
            'parametre_id' => $validated['parametre_id'] ?? null,
            'note' => $validated['note'],
            'position'=>$maxPosition +1,
            // We'll handle position later to allow re-ordering
        ]);
        // If this is the very first step, link it to the intervention
        if ($intervention->etapes()->count() == 1) {
            $intervention->update(['first_step_id' => $etape->id]);
        }
         
        return redirect()->route('intervention.show', $intervention)->with('success', 'Step created successfully! Now.');
    }
    public function updateGraph(Request $request)
    {
        $validated = $request->validate([
            'intervention_id' => 'required|exists:interventions,id',
            'etapes' => 'required|array',
            'etapes.*.position'  => 'required|integer|min:1',
            'etapes.*.next_step_ok' => 'nullable|exists:etapes,id',
            'etapes.*.next_step_ko' => 'nullable|exists:etapes,id',
        ]);
        foreach ($validated['etapes'] as $etapeId => $links) {
            $etape = Etape::findOrFail($etapeId);
            $etape->update([
                'position'     => $links['position'] ?? null,
                'next_step_ok' => $links['next_step_ok'] ?? null,
                'next_step_ko' => $links['next_step_ko'] ?? null,
            ]);
        }
        
        $intervention = Intervention::findOrFail($validated['intervention_id']);
        $intervention->etapes()->orderBy('position')->get();
        return redirect()->route('intervention.show', $intervention)
                         ->with('success', 'Graph updated successfully!');
    }
}