<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 4:49 PM
 */

namespace Post\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\Request;
use Post\Http\Requests\PostCreateValidate;
use Post\Http\Requests\PostEditValidate;
use Post\Repositories\PostRepository;
use Base\Supports\FlashMessage;

class PostController extends BaseController
{
    protected $post;

    public function __construct(PostRepository $postRepository)
    {
        $this->post = $postRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        return view('nqadmin-post::list');
    }

    public function getIndex(Request $request)
    {
        $type = $request->get('type');
        $post = $this->post->getAllPost($type);
        return view('nqadmin-post::index', [
            'data' => $post
        ]);
    }

    public function getCreate()
    {
        return view('nqadmin-post::create');
    }

    /**
     * @param PostCreateValidate $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function postCreate(PostCreateValidate $request)
    {
        $data = $request->except('_token');
        try {
            $post = $this->post->create($data);
            if ($request->has('continue_edit')) {
                return redirect()->route('nqadmin::post.edit.get', [
                    'id' => $post->id,
                    'type' => $request->get('post_type')
                ])->with(FlashMessage::returnMessage('create'));
            }

            return redirect()->route('nqadmin::post.index.get', ['type' => $request->get('post_type')])->with(FlashMessage::returnMessage('create'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $post = $this->post->find($id);
        return view('nqadmin-post::edit', [
            'post' => $post
        ]);
    }

    /**
     * @param $id
     * @param PostEditValidate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, PostEditValidate $request)
    {
        try {
            $data = $request->except('_token');
            dd($data);
            $this->post->update($data, $id);
            return redirect()->back()->with(FlashMessage::returnMessage('edit'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        return getDelete($id, $this->post);
    }
}