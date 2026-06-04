<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etape extends Model
{
    protected $fillable = [
        'intervention_id',
        'commande_id',
        'parametre_id',
        'position',
        'note',
        'next_step_ok',
        'next_step_ko',
    ];

    // ── Relations ────────────────────────────────────────────

    /**
     * L'intervention à laquelle appartient cette étape.
     */
    public function intervention(): BelongsTo
    {
        return $this->belongsTo(Intervention::class);
    }

    /**
     * La commande racine utilisée dans cette étape (ex: docker, firewall-cmd).
     */
    public function command(): BelongsTo
    {
        return $this->belongsTo(Command::class, 'commande_id');
    }

    /**
     * Le paramètre pré-choisi pour cette étape (ex: logs --tail 100).
     * Nullable : certaines étapes n'ont pas de paramètre fixé.
     */
    public function parametre(): BelongsTo
    {
        return $this->belongsTo(Parametre::class, 'parametre_id');
    }

    /**
     * L'étape suivante si le résultat est OK (auto-référence).
     */
    public function nextStepOk(): BelongsTo
    {
        return $this->belongsTo(Etape::class, 'next_step_ok');
    }

    /**
     * L'étape suivante si le résultat est KO (auto-référence).
     */
    public function nextStepKo(): BelongsTo
    {
        return $this->belongsTo(Etape::class, 'next_step_ko');
    }

    // ── Méthodes métier ──────────────────────────────────────

    /**
     * Reconstitue la commande complète prête à copier-coller.
     * Retourne null si la commande ou le paramètre ne sont pas chargés.
     *
     * Résultat ex : "docker logs --tail 100 <container_name> --timestamps"
     */
    public function getCommandeComplete(): ?string
    {
        if (! $this->relationLoaded('commande') || ! $this->commande) {
            return null;
        }

        $parts = [$this->commande->name];

        if ($this->relationLoaded('parametre') && $this->parametre) {
            $parts[] = $this->parametre->nom;

            if ($this->parametre->argument) {
                $parts[] = $this->parametre->argument;
            }

            if ($this->parametre->suffix) {
                $parts[] = $this->parametre->suffix;
            }
        }

        return implode(' ', $parts);
    }

    /**
     * Indique si cette étape est un point de décision (branchement conditionnel).
     */
    public function isConditionnelle(): bool
    {
        return ! is_null($this->next_step_ko);
    }

    /**
     * Indique si cette étape est une fin de branche (aucun suivant).
     */
    public function isFinale(): bool
    {
        return is_null($this->next_step_ok) && is_null($this->next_step_ko);
    }
}