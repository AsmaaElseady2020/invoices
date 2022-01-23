<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productes extends Model
{
    protected $table="productes";

    protected $guarded = [];

    public function section(){
        return $this->belongsTo('App\sections');
    }

}
