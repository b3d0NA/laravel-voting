<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryFilter extends Component
{
    
    public function updateCategory($cat){
        if(Str::contains(url()->previous(), 'ideas')){
            session()->flash("updatedCategoryFilter", $cat);
            redirect()->route("idea.index");
        }
        $this->emit("updatedCategoryFilter", $cat);        
    }

    public function render()
    {
        return view('livewire.category-filter', [
            "categories" => Category::all(),
            "ideaCount" => Idea::count()
        ]);
    }
}