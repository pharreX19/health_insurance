<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    use HasFactory;

    public function plans() : BelongsToMany{
        return $this->belongsToMany(Plan::class, 'plan_subscriber');
    }

    public function services() : BelongsToMany{
        return $this->belongsToMany(Service::class);
    }

    public function company() : BelongsTo{
        return $this->belongsTo(Company::class);
    }
}
