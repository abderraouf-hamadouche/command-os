<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{   
    protected $table = 'process_step';
    protected $fillable = [
        'process_id',
        'command_id',
        'step_order',
        'comment',
        
    ];

    // Relationships
    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    public function command()
    {
        return $this->belongsTo(Command::class);
    }


}
