<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/19
 * Time : 15:18
 */

namespace App\Models\BM\CMS;


class Article extends CMSAbstractBM
{
    protected $ORMClass = \App\Models\ORM\CMS\ArticleORM::class;
}