<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\Vote;
use Illuminate\Http\Response;
use Livewire\Component;

class DeleteIdea extends Component
{
    public $idea;

    public function mount(Idea $idea){
        $this->idea = $idea;
    }

    public function deleteIdea(){
        (auth()->guest() || auth()->user()->cannot("delete", $this->idea)) && abort(Response::HTTP_FORBIDDEN);

        $this->idea->delete();
        return redirect()->route("idea.index");
    }

    public function render()
    {
        return view('livewire.delete-idea');
    }
}