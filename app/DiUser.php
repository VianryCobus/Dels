<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiUser extends Model
{
    protected $table = 'dashboard.di_users';

    public function delsuser(){
        return $this->hasMany(User::class);
    }
}
