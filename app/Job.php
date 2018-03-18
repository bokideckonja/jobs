<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * Jobs that are approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
