<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrases extends Model
{
    use HasFactory;
    function user(){
        return $this->hasOne(User::class, "id", "created_by");
    }
}
