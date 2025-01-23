<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Argument extends Model
{
    use HasFactory;
    protected $table = 'argument';
    protected $fillable = ["name","description"];
    public function argumentPositions()
    {
        return $this->hasMany(ArgumentPosition::class);
    }
}
