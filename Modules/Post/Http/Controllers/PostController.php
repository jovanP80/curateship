<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Post\Entities\Post;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use Storage;


class PostController extends Controller
{

    protected $posts;

    public function __construct(
        Post $posts
    )
    {
        $this->posts = $posts;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $q         = $request->input('q');
        $limit     = $request->input('limit') ? $request->input('limit') : 1000;
        $sort      = $request->input('sort') ? $request->input('sort') : 'created_at';
        $order     = $request->input('order') ? $request->input('order') : 'desc';

        $posts = $this->posts->whereNull('deleted_at');

        // if search query is not null
        if ($q != null) {
            $posts = $posts->where('posts.title', 'LIKE', '%' . $q . '%')
                ->orWhere ( 'posts.body', 'LIKE', '%' . $q . '%' )
                ->orWhere ( 'posts.slug', 'LIKE', '%' . $q . '%' );
        }

        $posts = $posts->orderBy($sort, $order);

        $posts = $posts->paginate($limit);

        return view('post::index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('post::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        /*print_r($request->all());
        echo "<br><br>";
        print_r($_FILES);*/

        /*$posts = Post::find(31);
        $files = $request->file('file');
        
        foreach ($files as $file) {
            $posts->addMedia($file)->toMediaCollection('file');
        }*/
        
        /*$getPostMedia = Post::find(31);
        $getPostMedia = $getPostMedia->getMedia('file');

        foreach ($getPostMedia as $images) {
            print_r($images->getUrl('thumb'));
        }

        die;*/
        // validate data
        $validateData = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'seo'       => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'body'       => ['required'],
            'savetype'  => ['required', 'string']
        ]);

        $posts = new Post;
        $posts->title = $request->title;
        $posts->body  = $request->body;
        $posts->slug  = $request->seo;

        $posts->is_draft        = (isset($request->savetype) && $request->savetype == 'save') ? 1 : 0;
        $posts->is_published    = (isset($request->savetype) && $request->savetype == 'publish') ? 1 : 0;
        $posts->is_archived     = 0;
        $posts->created_by      = Auth::id();
        $posts->updated_by      = Auth::id();
        $saved = $posts->save();


        $files = $request->file('file');

        if($saved && !empty($files)) {
            $post = Post::find($posts->id);
            foreach ($files as $file) {
                $post->addMedia($file)->toMediaCollection('post');
            }
        }

        $response = [
            'status'  => 'success',
            'message' => 'Post has been created.',
            'clear'   => true,
        ];

        if (!$saved) {
            $response = [
                'status'  => 'error',
                'message' => 'Failed to add post. Please try again.',
            ];
        }

        return response()->json($response);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('post::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $post = $this->posts->find($id);

        return response()->json(compact('post'));
        // return view('post::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $responseMessage = 'Post has been updated.';
        $post = Post::find($id);

        if (!$post) {
            return redirect('admin/posts')->with('responseMessage', 'Post not found.');
        }

        $validateData = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'seo'       => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'body'       => ['required'],
            'savetype'  => ['required', 'string']
        ]);

        $post->title = $request->title;
        $post->body  = $request->body;
        $post->slug  = $request->seo;

        $post->is_draft        = (isset($request->savetype) && $request->savetype == 'save') ? 1 : 0;
        $post->is_published    = (isset($request->savetype) && $request->savetype == 'publish') ? 1 : 0;
        $post->is_archived     = 0;
        $post->created_by      = Auth::id();
        $post->updated_by      = Auth::id();
        $saved = $post->save();

        $response = [
            'status'  => 'success',
            'message' => 'Post has been updated.',
            'clear'   => true,
        ];

        if (!$saved) {
            $response = [
                'status'  => 'error',
                'message' => 'Failed to add post. Please try again.',
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $responseMessage = 'Something went wrong. Please try again.';

        // if user not found
        if (!$post) {
            return redirect('admin/posts')->with('responseMessage', 'Post not found.');
        }
        
        $deleted = $post->delete();

        if($deleted) {
            $responseMessage = "Post has been successfully deleted.";
        } else {
            $responseMessage = "Failed to delete post. Please try again.";
        }

        return redirect('admin/posts')->with('responseMessage', $responseMessage);
    }
}
