<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use Livewire\Component;

class CreateIdea extends Component
{

    public $title;
    public $category = 1;
    public $description;

    protected $rules = [
        "title" => "required|min:5",
        "category" => "required|exists:categories,id",
        "description" => "required|min:5",
    ];
    
    public function render()
    {
        return view('livewire.create-idea', [
            "categories" => Category::all()
        ]);
    }

    public function createIdea(){
        $this->validate();
        
        if(auth()->check()){
            Idea::create([
                "user_id" => auth()->id(),
                "category_id" => $this->category,
                "status_id" => 1,
                "title" => $this->title,
                "description" => $this->description 
            ]);

            session()->flash("success_message", "Idea was posted succesfully!");

            return redirect()->route("idea.index");
        }

        abort(403);
    }
}