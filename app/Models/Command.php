<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Command extends Model
{
    use HasFactory;
    protected $table = 'commands_tables';
    protected $fillable = ['command','description','tags', 'param','pdescription'];
    protected $casts = [
        'tags' => 'array', // Automatically casts to an array
    ];
}
