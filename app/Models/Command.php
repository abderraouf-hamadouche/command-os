<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * The tags that belong to the command.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'commande_tag');
    }

    /**
     * The parametres that belong to the command.
     */
    public function parametres()
    {
        return $this->belongsToMany(Parametre::class, 'commande_parametre')
                    ->withPivot('position')
                    ->orderBy('pivot_position');
    }
}
