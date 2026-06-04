<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;

class Intervention extends Model
{
    protected $fillable = [
        'titre',
        'probleme',
        'description',
        'first_step_id',
    ];

    // ── Relations ────────────────────────────────────────────

    /**
     * Toutes les étapes qui composent cette intervention.
     */
    public function etapes(): HasMany
    {
        return $this->hasMany(Etape::class)
                    ->orderBy('position');
    }

    /**
     * L'étape d'entrée du graphe (point de départ de l'intervention).
     */
    public function firstStep(): BelongsTo
    {
        return $this->belongsTo(Etape::class, 'first_step_id');
    }

    // ── Méthodes métier ──────────────────────────────────────

    /**
     * Retourne le graphe complet de l'intervention sous forme de tableau ordonné.
     * Parcourt les étapes en suivant next_step_ok jusqu'à la fin.
     *
     * Usage : $intervention->getGraphe()
     */
    public function getGraphe(): Collection
    {
        return $this->etapes()
                    ->with(['commande', 'parametre', 'nextStepOk', 'nextStepKo'])
                    ->get();
    }

    /**
     * Retourne uniquement les étapes qui ont un branchement conditionnel.
     * Utile pour afficher les points de décision dans l'UI.
     */
    public function getEtapesConditionnelles(): Collection
    {
        return $this->etapes()
                    ->whereNotNull('next_step_ko')
                    ->with(['commande', 'parametre'])
                    ->get();
    }

    /**
     * Compte le nombre total d'étapes de l'intervention.
     */
    public function getNombreEtapesAttribute(): int
    {
        return $this->etapes()->count();
    }
}