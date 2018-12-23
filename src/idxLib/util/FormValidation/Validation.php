<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/21
 * Time : 20:32
 */

namespace IdxLib\util\FormValidation;


use Interop\Container\ContainerInterface;

class Validation
{
    private $ci;
    private $getParams;
    private $postParams;
    private $files;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->getParams = count($this->ci->request->getQueryParams()) == 0 ? null : $this->ci->request->getQueryParams();
        $this->postParams = count($this->ci->request->getParsedBody()) == 0 ? null : $this->ci->request->getParsedBody();
        $this->files = count($this->ci->request->getUploadedFiles()) == 0 ? null : $this->ci->request->getUploadedFiles();
    }

    public function setQueryParamRegulation(array $regulation)
    {
        foreach ($regulation as $fieldName => $fieldRegulation) {

        }
    }

    public function setPostParamRegulation(array $regulation)
    {

    }

    private function distributeRegulation($target, $regulation)
    {
        $regArray = explode('|', $regulation);


        //required，表示该项必填
        if (in_array('required', $regArray)) {
            $this->required($target);
        }

        //no_space，无空格
        if (in_array('no_space', $regArray)) {
            $this->noSpace($target);
        }

        //email，邮件格式
        if (in_array('email', $regArray)) {
            $this->eMail($target);
        }

        //numeric，都是数字
        if (preg_grep('/^(numeric:)([0-9]{0,})~([0-9]{0,})$/', $regArray)) {
            $this->allNumeric($target);
        }

        //alpha，全部都是英文字母
        if (in_array('alpha', $regArray)) {
            $this->allAlpha($target);
        }

        //alpha_dash，可以是英文、数字、下划线(_)和短横线(-)
        if (in_array('alpha_dash', $regArray)) {
            $this->alphaDash($target);
        }

        //alpha_num，必须完全是字母、数字。
        if (in_array('alpha_num', $regArray)) {
            $this->alphaNum($target);
        }

        //phone，电话号码
        if (in_array('phone', $regArray)) {
            $this->phone($target);
        }

        //date，日期
        if (preg_grep('/^(date:)([0-9]{4}-[0-9]{2}-[0-9]{2})~([0-9]{4}-[0-9]{2}-[0-9]{2})$/', $regArray)) {

        }

        //datetime，日期时间
        if (preg_grep('/^(date:)([0-9]{4}-[0-9]{2}-[0-9]{2} [0-2][0-9]:[0-5][0-9]:[0-5][0-9])~([0-9]{4}-[0-9]{2}-[0-9]{2} [0-2][0-9]:[0-5][0-9]:[0-5][0-9])$/', $regArray)) {

        }

    }

    private function required($target)
    {
        return count_chars($target);
    }

    private function noSpace($target)
    {

    }

    private function eMail($target)
    {

    }

    private function allNumeric($target)
    {

    }

    private function allAlpha($target)
    {

    }

    private function alphaDash($target)
    {

    }

    private function alphaNum($target)
    {

    }

    private function phone($target)
    {

    }

    private function date($target)
    {

    }

    private function dateTime($target)
    {

    }

    private function regExp($target)
    {

    }

    private function fileSize($target)
    {

    }

    private function fileSuffix($target)
    {

    }

    private function fileMIMEType($target)
    {

    }

    private function strLength($target)
    {

    }

}