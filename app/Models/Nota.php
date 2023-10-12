<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Capitol;
use App\Models\Curs;
class Nota extends Model
{
    use HasFactory;

    public function capitol()
    {
        return $this->belongsTo(Capitol::class);
    }

    protected $table = 'note';
}
