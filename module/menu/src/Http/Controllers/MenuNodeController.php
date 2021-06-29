<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 12:05 PM
 */

namespace Menu\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Supports\FlashMessage;
use Menu\Http\Requests\MenuNodeValidate;
use Menu\Repositories\MenuNodeRepository;
use Post\Repositories\PostRepository;

class MenuNodeController extends BaseController
{
    protected $node;
    protected $post;

    public function __construct(MenuNodeRepository $menuNodeRepository, PostRepository $postRepository)
    {
        $this->node = $menuNodeRepository;
        $this->post = $postRepository;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $node = $this->node->find($id, [
            'type', 'name', 'url', 'index', 'menu'
        ]);

        $pages = $this->post->findWhere([
            'status' => 'active',
            'post_type' => 'page'
        ], ['name', 'id', 'slug']);

        return view('nqadmin-menu::menu-node.edit', [
            'node' => $node,
            'pages' => $pages
        ]);
    }

    public function postEdit($id, MenuNodeValidate $request)
    {
        $data = $request->only(['name', 'url', 'index', 'type']);
        try {
            $this->node->update($data, $id);
            return redirect()->route('nqadmin::menu.edit.get', ['id' => $request->get('menu')])
                ->with(FlashMessage::renderMessage('create'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }

}