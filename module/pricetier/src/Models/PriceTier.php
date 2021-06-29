<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:24 PM
 */

namespace PriceTier\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class PriceTier extends Model
{
	protected $table = 'price_tier';
	protected $guarded = [];
	protected $fillable = [
		'name', 'price', 'author', 'editor', 'created_at', 'updated_at', 'status'
	];
	
	/**
	 * @param $value
	 */
	public function setPriceAttribute($value)
	{
		$price = intval($value);
		$this->attributes['price'] = $price;
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner()
	{
		return $this->belongsTo(Users::class, 'author');
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function edit()
	{
		return $this->belongsTo(Users::class, 'editor');
	}
}