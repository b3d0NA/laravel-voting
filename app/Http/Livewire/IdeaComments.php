<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;

class IdeaComments extends Component
{
    use WithPagination;
    public $idea;

    protected $listeners = ["commentWasPosted", "commentWasDeleted"];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function commentWasPosted(){
        $this->idea->refresh();
    }

    public function commentWasDeleted(){
        $this->idea->refresh();
    }
    
    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => Comment::with(["user"])->latest()->where("idea_id", $this->idea->id)->paginate()
        ]);
    }
}