<?php

namespace App\Models;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "registration"
    ];

    public function subscribers() : HasMany{
        return $this->hasMany(Subscriber::class);
    }
}
