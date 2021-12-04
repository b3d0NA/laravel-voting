<x-app-layout>
    <div class="ideas-section py-10">
        <livewire:idea-show :idea="$idea" :votesCount="$votesCount" />
        @can("update", $idea)
        <livewire:edit-idea :idea="$idea" />
        @endcan
        @can("delete", $idea)
        <livewire:delete-idea :idea="$idea" />
        @endcan
        <livewire:idea-mark-as-spam :idea="$idea" />

        <livewire:idea-comments :idea="$idea" />

        <livewire:edit-idea-comment />
        <livewire:delete-idea-comment />

        <x-success-notification />

    </div>
</x-app-layout>