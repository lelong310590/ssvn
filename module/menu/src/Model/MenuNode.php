<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 1:46 PM
 */

namespace Menu\Model;

use Illuminate\Database\Eloquent\Model;

class MenuNode extends Model
{
    protected $table = 'menu_node';

    protected $fillable = [
        'name', 'url', 'menu', 'index', 'created_at', 'updated_at', 'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getMenu()
    {
        return $this->belongsTo(Menu::class, 'menu', 'id');
    }
}