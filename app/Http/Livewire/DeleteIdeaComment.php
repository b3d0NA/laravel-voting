<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class DeleteIdeaComment extends Component
{
    public $comment;

    protected $listeners = ["setDeleteComment"];


    public function setDeleteComment($commentId){
        $this->comment = Comment::findOrFail($commentId);

        $this->emit("deleteCommentWasPlaced");        
    }

    public function deleteComment()
    {
        (auth()->user()->cannot("delete", $this->comment) || auth()->guest()) && abort(403);

        $this->comment->delete();

        $this->emit("commentWasDeleted", "Comment was deleted!");
    }
    public function render()
    {
        return view('livewire.delete-idea-comment');
    }
}