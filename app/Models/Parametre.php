<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'type',
        'description',
        'argument',
        'suffix',
    ];

    /**
     * The commands that belong to the parametre.
     */
    public function commands()
    {
        return $this->belongsToMany(Command::class, 'commande_parametre');
    }
}
