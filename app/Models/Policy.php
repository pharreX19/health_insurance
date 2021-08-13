<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Policy extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'policies';

    protected $fillable = [
        'name',
        "number_format"
    ];

    public function plans() : HasMany{
        return $this->hasMany(Plan::class);
    }

}
