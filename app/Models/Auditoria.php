<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Audit extends Model
{
    protected $fillable = [
        'user_id','action','auditable_type','auditable_id',
        'description','ip_address','user_agent',
    ];

    public function auditable(): MorphTo {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}


