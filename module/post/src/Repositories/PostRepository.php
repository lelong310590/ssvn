<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 5:07 PM
 */

namespace Post\Repositories;

use Post\Models\Post;
use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository
{
    public function model()
    {
        return Post::class;
    }

    /**
     * @return mixed
     */
    public function getAllPost($type)
    {
        $data = $this->with(['getAuthor' => function($q) {
            return $q->select('email', 'id')->first();
        }])->findWhere([
            'post_type' => $type
        ],['id', 'name', 'thumbnail', 'status', 'author', 'created_at']);

        return $data;
    }

    public function homeGetPost()
    {
        $post = $this->scopeQuery(function ($q) {
            return $q->orderBy('created_at', 'desc')->select('thumbnail', 'name', 'slug', 'excerpt', 'created_at')
                ->where([
                ['status', 'active'],
                ['post_type', 'post']
            ])->take(4);
        })->all();

        return $post;
    }

    public function blogGetPost()
    {
        $post = $this->scopeQuery(function ($q) {
            return $q->orderBy('created_at', 'desc')->select('thumbnail', 'name', 'slug', 'excerpt', 'created_at')
                ->where([
                    ['status', 'active'],
                    ['post_type', 'post']
                ]);
        })->paginate(9);

        return $post;
    }

    public function countPost()
    {
        return $this->findWhere([
            'post_type' => 'post',
            'status' => 'active'
        ])->count();
    }

    public function homeGetRelatedPost($id)
    {
        return $this->scopeQuery(function ($q) use ($id) {
            return $q->orderBy('updated_at', 'desc')
                ->select('id', 'name', 'thumbnail', 'slug', 'updated_at', 'excerpt')
                ->where('id', '!=', $id)
                ->where('status', 'active')
                ->where('post_type', 'post')
                ->limit(5);
        })->all();
    }
}