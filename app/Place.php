<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [

        'name',

    ];

    // public function articleComments()
    // {
    //     return $this->hasMany('App\ArticleComment')->where('relate_to', NULL);
    // }

    public function groups(){
        return $this-> hasMany('App\Group');
    }

}
