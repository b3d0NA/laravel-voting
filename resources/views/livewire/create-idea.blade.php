<form wire:submit.prevent="createIdea" action="#" method="POST">
    <div class="idea-form b">
        <input wire:model.defer="title" type="text" name="title" placeholder="Idea title"
            class="rounded-xl transition duration-150 focus:border-gray-100 w-full border border-yellow-500 focus:ring focus:ring-yellow-500 focus:outline-none">
        @error("title")
        <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
            {{$message}}
        </div>
        @enderror
        <select wire:model.defer="category"
            class="w-full border transition duration-150 border-yellow-500 rounded-xl text-gray-500 my-3 focus:ring focus:ring-yellow-500 focus:border-gray-100"
            name="idea-show" id="idea-show">
            @foreach ($categories as $category)
            <option value="{{ $category->id}}">{{ $category->name}}</option>
            @endforeach
        </select>
        @error("category")
        <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
            {{$message}}
        </div>
        @enderror
        <textarea wire:model.defer="description" name="idea-description" rows="3" placeholder="Idea"
            class="w-full border transition duration-150 border-yellow-500 rounded-xl text-gray-500 my-3 focus:ring focus:ring-yellow-500 focus:border-gray-100"></textarea>
        @error("description")
        <div class="bg-red-500 text-white p-2 my-3 rounded-lg inline-block">
            {{$message}}
        </div>
        @enderror
        <input type="submit" value="Submit"
            class="px-4 py-2 bg-yellow-600 rounded-xl text-white cursor-pointer hover:bg-yellow-300 hover:text-gray-800">
    </div>

    @if(session("success_message"))
    <div x-data={isVisible:true} x-init="
            setTimeout(function (){
                isVisible=false;
            }, 3000)
        " x-show.transition.duration.1000ms="isVisible" class="my-8 bg-green-500 p-5 rounded-lg text-white">
        {{ session("success_message") }}
    </div>
    @endif
</form>