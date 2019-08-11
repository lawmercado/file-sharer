<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class File extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}