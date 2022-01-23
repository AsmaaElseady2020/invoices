<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
protected $table="sections";


    protected $fillable = [
        'section_name',
        'description',
        'Created_by',
    ];


public function productes(){
    return $this-> hasMany('App\productes');
}






}
