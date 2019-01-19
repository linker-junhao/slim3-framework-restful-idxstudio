<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/19
 * Time : 14:41
 */

namespace App\Models\ORM\CMS;


use App\Models\ORM\AbstractAppORM;

class CMSAbstractORM extends AbstractAppORM
{
    protected $connection = 'cms';
}