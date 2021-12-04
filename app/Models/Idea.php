<?php

namespace App\Models;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteDoesNotExistException;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    function category(){
        return $this->belongsTo(Category::class);
    }

    function status(){
        return $this->belongsTo(Status::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function votes(){
        return $this->belongsToMany(User::class, "votes");
    }

    function statusClasses(){
        $allStatuses = [
            "Open" => "bg-gray-200 text-gray-400",
            "Considering" => "bg-yellow-300 text-gray-600",
            "In Progress" => "bg-yellow-800 text-white",
            "Implemented" => "bg-green-500 text-white",
            "Closed" => "bg-red-500 text-white",
        ];

        return $allStatuses[$this->status->name];
    }

    function isVotedByUser(?User $user){
        if(!$user){
            return false;
        }
        return Vote::where("user_id", $user->id)
            ->where("idea_id", $this->id)
            ->exists();
    }

    function vote(User $user){
        if(!$this->isVotedByUser($user)){
            return Vote::create([
                "idea_id" => $this->id,
                "user_id" => $user->id,
            ]);
        }else{
            throw new DuplicateVoteException;
        }
        
    }

    function removeVote(User $user){
        $voteToRemove = Vote::where("idea_id", $this->id)
                        ->where("user_id", $user->id)
                        ->first();
        if($voteToRemove){
            $voteToRemove->delete();
        }else{
            throw new VoteDoesNotExistException;
        }
                    
    }
}