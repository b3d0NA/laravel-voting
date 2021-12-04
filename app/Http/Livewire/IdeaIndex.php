<?php

namespace App\Http\Livewire;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteDoesNotExistException;
use App\Models\Idea;
use App\Models\Status;
use Livewire\Component;

class IdeaIndex extends Component
{
    public $idea;
    public $hasVoted;
    public $votesCount;
    public $commentsCount;

    public function mount(Idea $idea){
        $this->idea = $idea;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
        $this->votesCount = $idea->votes_count;
        $this->commentsCount = $idea->comments_count;
    }
    
    public function render()
    {
        return view('livewire.idea-index');
    }
    public function vote()
    {
        if(! auth()->check()){
            return redirect()->route("login");
        }

        if($this->hasVoted){
            try{
                $this->idea->removeVote(auth()->user());
            }catch(VoteDoesNotExistException $e){
                // Do nothig
            }
            $this->votesCount--;
            $this->hasVoted = false;
        }else{
            try{
                $this->idea->vote(auth()->user());
            }catch(DuplicateVoteException $e){
                //Do nothing
            }
            $this->votesCount++;
            $this->hasVoted = true;
        }
    }
}