<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class UserNotifications extends Component
{
    const NOTIFICATION_THRESHOLD = 20;
    public $notifications;
    public $isLoading;
    public $notificationCount;

    protected $listeners = ["getAllNotifications"];

    public function mount(){
        $this->notifications = collect([]);
        $this->isLoading = true;
        $this->getNotificationCount();
    }

    public function getNotificationCount(){
        $this->notificationCount = auth()->user()->unreadNotifications()->count();

        $this->notificationCount > self::NOTIFICATION_THRESHOLD && $this->notificationCount = self::NOTIFICATION_THRESHOLD."+";
    }
    
    public function getAllNotifications(){
        $this->notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->take(self::NOTIFICATION_THRESHOLD)
            ->get();

        $this->isLoading = false;
    }

    public function markAsRead(DatabaseNotification $notification){
        auth()->guest() && abort(403);
        
        $notification->markAsRead();
        
        $this->scrollToComment($notification);        
    }

    private function scrollToComment($notification){
        $idea = Idea::find($notification->data["idea_id"]);
        $comment = Comment::find($notification->data["comment_id"]);
        $commentsId = $idea->comments()->latest()->pluck("id");
        $indexOfComment = $commentsId->search($comment->id);

        $page = (int) ($indexOfComment / $comment->getPerPage()) + 1;
        
        session()->flash("scrollToComment", $comment->id);

        return redirect()->route("idea.show", [
            "idea" => $notification->data["idea_slug"],
            "page" => $page
        ]);
    }

    public function markAllAsRead(){
        auth()->user()->unreadNotifications->markAsRead();
        $this->getAllNotifications();
    }
    
    public function render()
    {
        return view('livewire.user-notifications');
    }
}