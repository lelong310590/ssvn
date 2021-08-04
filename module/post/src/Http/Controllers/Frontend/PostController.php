<?php
/**
 * PostController.php
 * Created by: trainheartnet
 * Created at: 11/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Post\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use Barryvdh\Debugbar\LaravelDebugbar;
use Illuminate\Http\Request;
use Post\Repositories\PostRepository;

class PostController extends BaseController
{
    public $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPost($slug)
    {
        $post = $this->postRepository->findWhere([
            'status' => 'active',
            'slug' => $slug
        ]);

        if ($post->count() == 0) {
            return abort(404);
        }

        $sidePost = $this->postRepository->scopeQuery(function ($q) {
            return $q->where('status', 'active');
        })->orderBy('order', 'asc')->get();

        return view('nqadmin-post::frontend.post', compact('post', 'sidePost'));
    }
}