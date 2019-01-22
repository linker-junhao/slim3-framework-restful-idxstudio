<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/13
 * Time: 19:30
 */

namespace App\Models\ORM;


use Illuminate\Database\Eloquent\Model;

class AbstractAppORM extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param  array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}