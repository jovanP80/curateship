<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Post\Entities\Post;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;

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
        $limit     = $request->input('limit') ? $request->input('limit') : 25;
        $sort      = $request->input('sort') ? $request->input('sort') : 'id';
        $order     = $request->input('order') ? $request->input('order') : 'desc';

        $posts = $this->posts->where('is_published',1);

        // if search query is not null
        if ($q != null) {
            $posts = $posts->where('posts.title', 'LIKE', '%' . $q . '%')
                ->orWhere ( 'posts.body', 'LIKE', '%' . $q . '%' )
                ->orWhere ( 'posts.slug', 'LIKE', '%' . $q . '%' );
        }

        $posts = $posts->paginate($limit);

        // echo '<pre>';
        // print_r($posts->toArray());
        // echo '</pre>';
        // die;
        
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
        // validate data
        $validateData = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'seo'       => ['required', 'string', 'max:255', 'unique:posts,slug'],
            //'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            //'password' => ['required', 'string', 'max:255'],
        ]);
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
        return view('post::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        echo 'test';die;
    }
}
