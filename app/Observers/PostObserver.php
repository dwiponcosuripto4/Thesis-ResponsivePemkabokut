<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        // Jika hanya kolom 'views' yang berubah, jangan log aktivitas
        if ($post->wasChanged() && $post->getChanges() == ['views' => $post->views]) {
            return;
        }
        // ...kode log aktivitas Anda di sini...
    }
}
