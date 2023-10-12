<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capitol extends Model
{
    use HasFactory;

    public function curs()
    {
        return $this->belongsTo(Curs::class);
    }

    public function note()
    {
        return $this->hasMany(Nota::class);
    }

    public function siteuri()
    {
        return $this->hasMany(Site::class);
    }

    protected $table = 'capitole';
    protected $fillable = ['curs_id','capitol','nrord'];
}
