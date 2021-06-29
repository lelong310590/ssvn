<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 2:13 PM
 */

namespace Cart\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstallModuleProvider extends ServiceProvider
{
    protected $module = 'Cart';


    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    public function register()
    {

    }

    public function booted()
    {
        $permission = [
            [
                'name' => 'checkout_index',
                'display_name' => 'Xem danh sách đơn hàng',
                'description' => 'Xem danh sách các đơn hàng trong hệ thống'
            ],
            [
                'name' => 'checkout_create',
                'display_name' => 'Tạo đơn hàng mới thủ công',
                'description' => 'Tạo đơn hàng mới thủ công thay cho khách hàng'
            ],
            [
                'name' => 'checkout_edit',
                'display_name' => 'Cập nhật trạng thái thanh toán',
                'description' => 'Cập nhật trạng thái thanh toán'
            ],
        ];

        if (Schema::hasTable('permissions')) {
            acl_permission($this->module, $permission);
        }
    }
}