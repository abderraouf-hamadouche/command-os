<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intervention;
use App\Models\Command;

class InterventionsController extends Controller
{
    //


    public function index()
    {
        $interventions = Intervention::latest()->paginate(10);
        return view('intervention.index', compact('interventions'));
    }
    public function store(Request  $request)
    {

        $validated = $request->validate([
            'titre' => 'required|string|max:150',
            'probleme' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
               $maxPosition = $intervention->etapes()->max('position');

        $intervention = Intervention::create($validated);
        return redirect()->route('intervention.show', $intervention)->with('success', 'Intervention created successfully! Now, let\'s add the first step.');
    }
    public function create()
    {
        //show form to create a blog post
        return view('intervention.create');
    }
    public function show(Intervention $intervention)
    {   
        $intervention->load('etapes.command', 'etapes.parametre', 'etapes.nextStepOk', 'etapes.nextStepKo');
        $commands = Command::with('parametres')->orderBy('name')->get();
        return view('intervention.show', compact('intervention','commands'));
       // return $Interventioninter;
    

    }
    public function edit(Intervention $intervention)
    {
        // To be implemented later
        $intervention->load('etapes.command', 'etapes.parametre', 'etapes.nextStepOk', 'etapes.nextStepKo');
        $commands = Command::with('parametres')->orderBy('name')->get();
         return view('intervention.edit', compact('intervention','commands'));
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
    {
        // To be implemented later
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervention $intervention)
    {
        // To be implemented later
        // $intervention->delete();
        // return redirect()->route('intervention.index')->with('success', 'Intervention deleted.');
    }

}
