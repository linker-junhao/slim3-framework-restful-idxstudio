<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/19
 * Time : 15:25
 */

namespace App\Http\Controllers\CMS;


use App\Http\Controllers\AbstractController;

class CMSAbstractController extends AbstractController
{
    protected $_ARTICLE_COVER = array(
        'save_path' => './src/img/thumb_pic/',
        'base_url' => 'http://localhost:8888/src/img/thumb_pic/'
    );
}