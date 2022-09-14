<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Symfony\Component\Console\Logger\ConsoleLogger;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    public function mount($post) //inicia cuando es instanciada, como los construcctores
    {
        $this->isLiked = $post->checkLikes(auth()->user());
        $this->likes = $post->likes->count(); 
    }

    public function like()
    {
        if ( $this->post->checkLikes(auth()->user() )){
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false;  //acutalizamos la variable para que se actualize en el fronend
            $this->likes--;
        } 
        else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
