<?php

namespace App\Models;

use App\Traits\Child;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receptionist extends User
{
    use HasFactory, Child;

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

}
