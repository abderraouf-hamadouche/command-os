<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParametreController extends Controller
{
    //

    /**
     * Show the form for editing the specified parameter.
     *
     * @param  \App\Models\Command  $command
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Command $command, Parametre $parametre)
    {
        // Returns the edit view, passing both the command and the parameter
        return view('parametre.edit', compact('command', 'parametre'));
    }

    /**
     * Update the specified parameter in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Command  $command
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Command $command, Parametre $parametre)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:150'],
            'type' => ['required', Rule::in(['flag', 'option', 'arg'])],
            'description' => ['nullable', 'string'],
            'argument' => ['nullable', 'string', 'max:150'],
            'suffix' => ['nullable', 'string', 'max:150'],
        ]);

        $parametre->update($validated);

        // Redirect back to the command's show page with a success message
        return redirect()->route('command.show', $command)->with('success', 'Parameter updated successfully!');
    }

    /**
     * Remove the specified parameter from storage.
     *
     * @param  \App\Models\Command  $command
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Command $command, Parametre $parametre)
    {
        // Detach the parameter from the command (from the pivot table)
        $command->parametres()->detach($parametre->id);

        // Optionally, you could delete the parameter if it's not used by other commands.
        // For now, we will just detach it.
        // $parametre->delete();

        // Redirect back to the command's show page with a success message
        return redirect()->route('command.show', $command)->with('success', 'Parameter deleted successfully!');
    }
}
