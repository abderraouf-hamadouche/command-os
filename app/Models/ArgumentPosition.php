<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArgumentPosition extends Model
{
    use HasFactory;
    protected $fillable = ['command_id', 'argument_id', 'position'];

    public function command()
    {
        return $this->belongsTo(Command::class);
    }

    public function argument()
    {
        return $this->belongsTo(Argument::class);
    }
}
