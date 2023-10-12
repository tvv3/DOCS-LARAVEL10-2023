<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curs extends Model
{
    use HasFactory;

    public function capitole()
    {
        return $this->hasMany(Capitol::class);
    }

    public function note()
    {
        return $this->hasManyThrough(Nota::class, Capitol::class);
    }

    public function siteuri()
    {
        return $this->hasManyThrough(Site::class, Capitol::class);
    }

    protected $table = 'cursuri';
}
