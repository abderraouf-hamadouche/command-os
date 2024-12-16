<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    use HasFactory;
    
    protected $table = 'params';
    protected $fillable = ['id-command',"param","description"];
    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'intervention_id', 'id_param');
    }
}
