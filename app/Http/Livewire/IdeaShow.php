<?php

namespace App\Http\Livewire;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteDoesNotExistException;
use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votesCount;
    public $isVoted;

    protected $listeners = [
        "ideaStatusWasUpdated", 
        "ideaWasUpdated", 
        "ideaWasMarkedAsSpam", 
        "commentWasUpdated",
        "commentWasDeleted",
    ];

    public function mount(Idea $idea, $votesCount){
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->isVoted = $idea->isVotedByUser(auth()->user());
    }

    public function ideaStatusWasUpdated(){
        $this->idea->refresh();
    }

    public function ideaWasUpdated(){
        $this->idea->refresh();
    }

    public function commentWasUpdated(){
        $this->idea->refresh();
    }
    
    public function commentWasDeleted(){
        $this->idea->refresh();
    }

    public function ideaWasMarkedAsSpam()
    {
        $this->idea->refresh();
    }
    

    public function render()
    {
        return view('livewire.idea-show');
    }

    public function vote()
    {
        if(! auth()->check()){
            return redirect()->route("login");
        }

        if($this->isVoted){
            try{
                $this->idea->removeVote(auth()->user());
            }catch(VoteDoesNotExistException $e){
                // Do nothig
            }
            $this->votesCount--;
            $this->isVoted = false;
        }else{
            try{
                $this->idea->vote(auth()->user());
            }catch(DuplicateVoteException $e){
                //Do nothing
            }
            $this->votesCount++;
            $this->isVoted = true;
        }
    }
}