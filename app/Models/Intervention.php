<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;
    protected $fillable = ["id","intervention","description","tags","created_by","created_at","updated_at"];
    public function param()
    {
        return $this->hasOne(Param::class, 'intervention_id', 'id_param');
    }
}
