<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Group as Groups;
use App\NewUser;
use App\Place;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Place as PlaceResource;

class Group extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'user_id' => new UserResource(NewUser::find($this->user_id)),
            'city_id' => new PlaceResource(Place::find($this->city_id)),
            'team_a' => $this->team_a,
            'team_b' => $this->team_b,
            'date_of_match' => $this->date_of_match,
            'created_at' => $this->created_at,
            'updated_at' => $this->created_at,

            // 'subComments' =>  ArticleComment::collection(CommentArticle::find($this->id)->related),

        ];
    }
}
