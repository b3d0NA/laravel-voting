<div class="categories-section">
    <div class="text-gray-500 category">
        <ul>
            <li wire:click="$emit('updatedCategoryFilter', 'All')"
                class="flex justify-between p-3 rounded-md cursor-pointer hover:bg-yellow-400 hover:text-white">
                <button class="inline">All Categories</button>
                <span>{{ $ideaCount }}</span>
            </li>
            @foreach ($categories as $category)
            <li class="flex justify-between p-3 rounded-md cursor-pointer category-li hover:bg-yellow-400 hover:text-white"
                wire:click="updateCategory('{{$category->name}}')">
                <button class="inline category-url">{{ $category->name }}</button>
                <span>{{ $category->ideas->count() }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>