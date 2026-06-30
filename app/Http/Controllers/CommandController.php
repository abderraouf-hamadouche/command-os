<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Tag;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commands = Command::with('tags')->latest()->paginate(10);
        return view('command.index', compact('commands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('command.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:commands,name',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'parametres' => 'nullable|array',
            'parametres.*.nom' => 'required_with:parametres|string|max:150',
            'parametres.*.type' => 'required_with:parametres|in:flag,option,arg',
            'parametres.*.description' => 'nullable|string',
            'parametres.*.argument' => 'nullable|string|max:150',
            'parametres.*.suffix' => 'nullable|string|max:150',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Create the Command
            $command = Command::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // 2. Handle Tags
            if ($request->filled('tags')) {
                $tagNames = array_unique(array_filter(explode(' ', $request->tags)));
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    $tag = Tag::firstOrCreate(['nom' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $command->tags()->sync($tagIds);
            }

            // 3. Handle Parametres
            if ($request->filled('parametres')) {
                $position = 1;
                foreach ($request->parametres as $paramData) {
                    $param = Parametre::create([
                        'nom' => $paramData['nom'],
                        'type' => $paramData['type'],
                        'description' => $paramData['description'] ?? '',
                        'argument' => $paramData['argument'] ?? null,
                        'suffix' => $paramData['suffix'] ?? null,
                    ]);
                    $command->parametres()->attach($param->id, ['position' => $position++]);
                }
            }

            return redirect()->route('command.show', $command)->with('success', 'Command created successfully!');
        });
    }

    /**
     * Edit the form for creating a new resource.
     */
    public function edit(Command $command)
    {
        return view('command.edit', compact('command'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Command $command)
    {
        // Eager load the relationships
        $command->load('tags', 'parametres');
        return view('command.show', compact('command'));
    }

    /**
     * Ajout D un  parametre a une command existante.
     */
    public function addParametres(Request $request, Command $command)
    {
        $request->validate([
            'parametres' => 'required|array|min:1',
            'parametres.*.nom' => 'required|string|max:150',
            'parametres.*.type' => 'required|in:flag,option,arg',
            'parametres.*.description' => 'nullable|string',
            'parametres.*.argument' => 'nullable|string|max:150',
            'parametres.*.suffix' => 'nullable|string|max:150',
        ]);
        return DB::transaction(function () use ($request, $command) {
            // Find the highest current position for this command's parameters
            $maxPosition = $command->parametres()->max('position') ?? 0;
            foreach ($request->parametres as $paramData) {
                $param = Parametre::create([
                    'nom' => $paramData['nom'],
                    'type' => $paramData['type'],
                    'description' => $paramData['description'] ?? '',
                    'argument' => $paramData['argument'] ?? null,
                    'suffix' => $paramData['suffix'] ?? null,
                ]);
                $command->parametres()->attach($param->id, ['position' => ++$maxPosition]);
            }
            return redirect()->route('command.show', $command)->with('success', 'New parameters added successfully!');
        });
    }

    /**
     * Search for commands on the fly.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            return response()->json([]); // Return empty array if no query
        }
        $commands = Command::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();
        return response()->json($commands);
    }


    /**
     * Parametre functions actions
     */


}
