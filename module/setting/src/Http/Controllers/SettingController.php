<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:44 PM
 */

namespace Setting\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Supports\FlashMessage;
use Notify\Repositories\NotifyRepository;
use Setting\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Auth;
use Setting\Repositories\SaleRepository;

class SettingController extends BaseController
{
    protected $repository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->repository = $settingRepository;
    }

    public function getSetting()
    {
        return view('nqadmin-setting::backend.setting');
    }

    public function getIndex()
    {
        $data = $this->repository->findWhere([
            'name' => 'top_message'
        ])->first();

        return view('nqadmin-setting::backend.index', [
            'data' => $data
        ]);
    }

    public function postIndex(Request $request)
    {
        $res = $this->repository->updateOrCreate([
            'name' => 'top_message',
        ],
            [
                'content' => $request->mess,
                'author' => Auth::id(),
                'status' => $request->status
            ]);

        return redirect()->back()->with('Thành công!');
    }

    public function getSale(SaleRepository $saleRepository)
    {
        $sale = $saleRepository->orderBy('id', 'desc')->all();
        return view('nqadmin-setting::backend.sale', [
            'data' => $sale
        ]);
    }

    public function createSale()
    {
        return view('nqadmin-setting::backend.createsale', [

        ]);
    }

    public function postcreateSale(Request $request, SaleRepository $saleRepository, NotifyRepository $notifyRepository)
    {
        $request->validate([
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $res = $saleRepository->create([
            'author' => Auth::id(),
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            'price' => $request->price,
            'type' => 1,
            'status' => 'active',
            'name' => !empty($request->name) ? $request->name : 'Giảm giá Khóa đào tạotừ ' . number_format($request->min_price) . ' đến ' . number_format($request->max_price),
            'start_time' => date('Y-m-d H:i:s', strtotime($request->start_time)),
            'end_time' => date('Y-m-d H:i:s', strtotime($request->end_time))
        ]);
        //tao mới notify
        $res = $notifyRepository->create([
            'start_time' => date('Y-m-d H:i:s', strtotime($request->start_time)),
            'end_time' => date('Y-m-d H:i:s', strtotime($request->end_time)),
            'status' => 'active',
            'name' => !empty($request->name) ? $request->name : 'Giảm giá Khóa đào tạotừ ' . number_format($request->min_price) . ' đến ' . number_format($request->max_price),
            'content' => json_encode(['price' => $request->price])
        ]);
        return redirect()->route('nqadmin::setting.sale.get')->with('success', 'Tạo mới thành công!');
    }

    public function enableSale($id, SaleRepository $saleRepository)
    {
        $sale = $saleRepository->find($id);
        $saleRepository->update(['status' => $sale->status == 'active' ? 'disable' : 'active'], $id);
        return back()->with('Thành công');
    }

    public function seoIndex(SettingRepository $settingRepository)
    {
        $tagline = $settingRepository->findWhere(['name' => 'seo_tagline'], ['content'])->first();
        $title = $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
        $keyword = $settingRepository->findWhere(['name' => 'seo_keywords'], ['content'])->first();
        $description = $settingRepository->findWhere(['name' => 'seo_description'], ['content'])->first();
        return view('nqadmin-setting::backend.seo', [
            'seo_tagline' => $tagline,
            'seo_title' => $title,
            'seo_keywords' => $keyword,
            'seo_description' => $description
        ]);
    }

    /**
     * @param Request $request
     * @param SettingRepository $settingRepository
     * @return string
     */
    public function seoPost(Request $request, SettingRepository $settingRepository)
    {
        $tagline = $request->get('seo_tagline');
        $title = $request->get('seo_title');
        $keyword = $request->get('seo_keywords');
        $description = $request->get('seo_description');
        $author = Auth::id();
        try {
            $this->repository->updateOrCreate([
                'name' => 'seo_tagline',
            ], [
                'author' => $author,
                'content' => $tagline
            ]);

            $this->repository->updateOrCreate([
                'name' => 'seo_title',
            ], [
                'author' => $author,
                'content' => $title
            ]);

            $this->repository->updateOrCreate([
                'name' => 'seo_keywords',
            ], [
                'author' => $author,
                'content' => $keyword
            ]);

            $this->repository->updateOrCreate([
                'name' => 'seo_description',
            ], [
                'author' => $author,
                'content' => $description
            ]);

            return redirect()->back()->with(FlashMessage::returnMessage('edit'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}