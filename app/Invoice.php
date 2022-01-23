<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
    use SoftDeletes;
    protected $table="invoices";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function section(){
        return $this->belongsTo('App\sections');
    }
}
