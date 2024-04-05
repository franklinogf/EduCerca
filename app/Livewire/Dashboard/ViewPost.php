<?php

namespace App\Livewire\Dashboard;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ViewPost extends Component
{
    use Toast, WithPagination;

    public Post $post;

    #[Validate('required|min:5')]
    public $content = '';

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->setPaginationPage();
    }
    #[Computed]
    public function user()
    {
        return auth()->user();
    }

    #[Computed]
    public function comments()
    {
        return $this->post->comments()->oldest()->paginate(5);
    }

    #[On('comment-deleted')]
    public function setPaginationPage()
    {
        $this->setPage($this->comments()->lastPage());
    }

    public function makeComment()
    {
        $this->validate();

        $this->user->comments()->create([
            'post_id' => $this->post->id,
            'content' => $this->content
        ]);

        $this->setPaginationPage();

        $this->success(
            'Comentario creado!',
            timeout: 5000,
            position: 'toast-bottom'
        );

        $this->reset('content');
    }

    public function render()
    {
        $signedInAs = Auth::getDefaultDriver();
        return view('livewire.dashboard.post')->layout("components.layouts.{$signedInAs}-dashboard");
    }
}
