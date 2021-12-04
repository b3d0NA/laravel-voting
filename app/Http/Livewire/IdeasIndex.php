<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Routing\Route;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    use WithPagination;

    public $category;
    public $status;
    public $filter;
    public $search;

    protected $queryString = [
        "status",
        "category",
        "filter"
    ];

    protected $listeners = ["updatedCategoryFilter"];

    public function mount(){
        $this->category = "All";
        $this->status = "All";
    }

    public function updatedCategoryFilter($categoryUpdated){
        dump($this->category);
        $this->category = $categoryUpdated;
    }

    public function updatedFilter(){
        if($this->filter === "My Ideas"){
            if(!auth()->check()){
                return redirect()->route("login");
            }
        }
    }

    public function updatedSearch(){
        $this->resetPage();
    }


    public function render()
    {

        $categories = Category::all();
        $statuses = Status::pluck("id", "name");

        return view('livewire.ideas-index', [
            "ideas" => Idea::with("category", "status")
            ->when($this->status && $this->status !== "All", function ($query) use ($statuses){
                return $query->where("status_id", $statuses->get($this->status));
            })->when($this->category && $this->category !== "All", function ($query) use ($categories){
                return $query->where("category_id", $categories->pluck("id", "name")->get($this->category));
            })->when($this->filter && $this->filter === "Top Voted", function ($query){
                return $query->orderByDesc("votes_count");
            })->when($this->filter && $this->filter === "My Ideas", function ($query){
                return $query->where("user_id", auth()->id());
            })->when($this->filter && $this->filter === "Spam Ideas", function ($query){
                return $query->where("spam_reports", ">", 0)->latest('spam_reports');
            })->when(strlen($this->search) >= 3, function ($query){
                return $query->where("title", "like", "%".$this->search."%");
            })
            ->withCount("votes")
            ->withCount("comments")
            ->latest()
            ->simplePaginate(10),
            "statuses" => Status::all()            
        ]);
    }
}