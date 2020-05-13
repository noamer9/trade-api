<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = [

        'user_id', 'city_id','team_a', 'team_b', 'date_of_match', 'created_at',
         'updated_at'

    ];




    public function place()
    {
        return $this->belongsTo('App\Place');
    }

        /**
     * Get the article that owns the comments.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

            /**
     * Get the article that owns the comments.
     */

}
