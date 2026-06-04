<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    /**
     * The commands that belong to the tag.
     */
    public function commands()
    {
        return $this->belongsToMany(Command::class, 'commande_tag');
    }
}
