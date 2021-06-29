<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/27/2018
 * Time: 2:13 PM
 */

namespace Post\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Post\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Base\Supports\FlashMessage;

class CategoryController extends BaseController
{
    protected $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function getIndex(CategoryRepository $categoryRepository){
        $categories = $this->repository->orderBy('created_at', 'desc')->all();
        //parent
        $parents = $categoryRepository->findWhere([
            'parent'=>0
        ]);
        return view('nqadmin-post::backend.category.index', [
            'data' => $categories,
            'parents'=>$parents
        ]);
    }

    public function postIndex(Request $request,CategoryRepository $categoryRepository){
        $res = $categoryRepository->create($request->all());
        return redirect()->back()->with(FlashMessage::returnMessage('create'));
    }

    public function getEdit($id,CategoryRepository $categoryRepository){
        $cat = $categoryRepository->find($id);
        //parent
        $parents = $categoryRepository->findWhere([
            'parent'=>0,
            ['id','!=',$id]
        ]);
        return view('nqadmin-post::backend.category.edit', [
            'data' => $cat,
            'parents'=>$parents
        ]);
    }

    public function postEdit(Request $request,CategoryRepository $categoryRepository){
        $res = $categoryRepository->update($request->all(),$request->id);
        return redirect()->back();
    }

    public function delete($id, CategoryRepository $categoryRepository){
        $res = $categoryRepository->delete($id);
        if($res){
            return redirect()->back()->with(FlashMessage::returnMessage('delete'));
        }
    }

    public function changestatus($id, CategoryRepository $categoryRepository){
        $cat = $categoryRepository->find($id);
        $newstt = $cat->status=='active'?'disable':'active';
        $categoryRepository->update(['status'=>$newstt],$id);
        return redirect()->back();
    }
}