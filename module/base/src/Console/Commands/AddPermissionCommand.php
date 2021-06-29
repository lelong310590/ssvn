<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/6/2018
 * Time: 1:31 AM
 */

namespace Base\Console\Commands;

use Illuminate\Console\Command;

class AddPermissionCommand extends Command
{
    protected $signature = 'admin-permission';

    protected $description = 'Add full permission for Administrator';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->addPermission();
    }

    public function addPermission()
    {
        acl_role_permission();

        $this->info('full permission was added for Administrator');
    }
}