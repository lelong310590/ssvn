<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 12:03 PM
 */

namespace Menu\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Supports\FlashMessage;
use Menu\Http\Requests\MenuNodeValidate;
use Menu\Repositories\MenuNodeRepository;
use Menu\Repositories\MenuRepository;
use Post\Repositories\PostRepository;
use Rank\Repositories\RankServicesRepository;

class MenuController extends BaseController
{
    protected $menu;
    protected $menuNode;
    protected $post;

    public function __construct(MenuRepository $menuRepository, MenuNodeRepository $menuNodeRepository, PostRepository $postRepository)
    {
        $this->menu = $menuRepository;
        $this->menuNode = $menuNodeRepository;
        $this->post = $postRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $menu = $this->menu->all(['name', 'position', 'id']);
        return view('nqadmin-menu::menu.index', [
            'data' => $menu
        ]);
    }

    public function getCreate()
    {

    }

    public function postCreate()
    {

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id, RankServicesRepository $rankServicesRepository)
    {
        $menu = $this->menu->find($id, [
            'name', 'id'
        ]);

        $nodes = $this->menuNode->orderBy('index', 'asc')->orderBy('created_at', 'asc')
            ->findWhere([
            'menu' => $id
        ], ['name', 'index', 'url', 'id', 'type']);

        $pages = $this->post->findWhere([
            'status' => 'active',
            'post_type' => 'page'
        ], ['name', 'id', 'slug']);

        $rs = $rankServicesRepository->findWhere([
            'status' => 'active',
        ], ['name', 'id', 'slug']);

        return view('nqadmin-menu::menu.edit', [
            'nodes' => $nodes,
            'pages' => $pages,
            'menu' => $menu,
            'rs' => $rs
        ]);
    }

    /**
     * @param MenuNodeValidate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(MenuNodeValidate $request)
    {
        $data = $request->only(['menu', 'name', 'url', 'index', 'type']);
        try {
            $this->menuNode->create($data);
            return redirect()->back()->with(FlashMessage::renderMessage('create'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        return getDelete($id, $this->menuNode);
    }

}