<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $guarded = [];
    public function users(){
      
      return $this->belongsTo('App\Users', 'userId', 'id');
    }
}
