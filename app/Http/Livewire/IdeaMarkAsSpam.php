<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Illuminate\Http\Response;
use Livewire\Component;

class IdeaMarkAsSpam extends Component
{
    public $idea;

    public function mount(Idea $idea){
        $this->idea = $idea;
    }

    public function markSpamIdea(){
        (auth()->guest()) && abort(Response::HTTP_FORBIDDEN);
        
        $this->idea->spam_reports++;
        $this->idea->save();

        $this->emit("ideaWasMarkedAsSpam", "Idea marked as spam succesfully!");
    }
    
    public function render()
    {
        return view('livewire.idea-mark-as-spam');
    }
}