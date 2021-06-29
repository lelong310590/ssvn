<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/2/2018
 * Time: 9:46 AM
 */

namespace Post\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiPostController extends BaseController
{
    public function getPost(Request $request)
    {
        $type = $request->get('post_type');
        $result = [];
        if (!empty($type)) {
            $result = DB::table('post')->orderBy('created_at', 'desc')
                ->select('id', 'name', 'slug')
                ->where('post_type', $type)
                ->get();
        } else {
            $result = DB::table('post')->orderBy('created_at', 'desc')
                ->select('id', 'name', 'slug')
                ->get();
        }

        return $result;
    }
}