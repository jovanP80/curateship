<?php

namespace App\View\Components\Posts\Single;

use Illuminate\View\Component;

use Modules\Post\Entities\{Post, PostsMeta};

class SinglePost extends Component
{
    public $post;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $post = Post::where(
            [
                'id'        => $id,
                'status'    => 'published'
            ]
        )->first();

        if ($post) {
            $post['description'] = Post::parseContent($post['description']);
            $video_file          = PostsMeta::getMetaData( $post->id, 'video' );
            $video_extension     = empty( $video_file ) ? '' : substr($video_file, strrpos($video_file,".") + 1);
            $post['video']       = !empty( $video_file ) ? asset("storage/posts/original/{$video_file}") : '';
            $post['video_type']  = $video_extension == 'mp4' ? 'video/mp4' : ( $video_extension == 'webm' ? 'video/webm' : '' );
        }

        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.posts.single.single-post');
    }
}
