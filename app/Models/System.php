<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models\Access\User
 */
class System extends BaseModel {

	protected $table = 'system';

	protected $casts = [
        'content' => 'array',
    ];
}
