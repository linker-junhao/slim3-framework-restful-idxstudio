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
use Interop\Container\ContainerInterface;

class CMSAbstractController extends AbstractController
{
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
    }
}