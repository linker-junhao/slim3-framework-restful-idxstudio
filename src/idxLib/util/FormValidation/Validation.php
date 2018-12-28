<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/21
 * Time : 20:32
 */

namespace IdxLib\util\FormValidation;


use IdxLib\util\FormValidation\Local\ErrMsgCN;
use Interop\Container\ContainerInterface;

class Validation
{
    private $ci;
    private $getParams;
    private $postParams;
    private $files;

    private $resultInfo;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->getParams = count($this->ci->request->getQueryParams()) == 0 ? null : $this->ci->request->getQueryParams();
        $this->postParams = count($this->ci->request->getParsedBody()) == 0 ? null : $this->ci->request->getParsedBody();
        $this->files = count($this->ci->request->getUploadedFiles()) == 0 ? null : $this->ci->request->getUploadedFiles();
        $this->resultInfo = array(
            'get' => array(),
            'post' => array()
        );
    }

    /**
     * set get query parameters valid regulation
     * @param array $regulation
     * @return $this
     */
    public function setQueryParamRegulation(array $regulation)
    {
        foreach ($regulation as $fieldName => $fieldRegulation) {
            $this->resultInfo['get'][$fieldName] = array();
            $this->distributeRegulation($this->getParams[$fieldName], $fieldRegulation, $this->resultInfo['get'][$fieldName]);
        }
        return $this;
    }

    /**
     * set post form valid regulation
     * @param array $regulation
     * @return $this
     */
    public function setPostParamRegulation(array $regulation)
    {
        foreach ($regulation as $fieldName => $fieldRegulation) {
            $this->resultInfo['post'][$fieldName] = array();
            $this->distributeRegulation($this->postParams[$fieldName], $fieldRegulation, $this->resultInfo['post'][$fieldName]);
        }
        return $this;
    }


    /**
     * set valid result info to view data
     * @return array
     */
    public function validDone()
    {
        $this->ci->view->offsetSet('validErr', $this->resultInfo);
        return $this->resultInfo;
    }

    /**
     * get the valid result of validation
     * @return array
     */
    public function getResult()
    {
        return $this->resultInfo;
    }

    /**
     * distribute the valid to different valid function
     * and set the error information
     * @param $target
     * @param $regulation
     * @param $resultArray
     * @return bool
     */
    private function distributeRegulation($target, $regulation, &$resultArray)
    {
        $regArray = explode('|', $regulation);
        $testResult = true;

        $resultInfo = '';
        //required，表示该项必填
        if (in_array('required', $regArray)) {
            if (!($test = $this->required($target))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['required'];
            }
            $testResult = $testResult && $test;
        }

        //no_space，无空格
        if (in_array('no_space', $regArray)) {
            if (!($test = $this->noWhiteSpace($target))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['noWhiteSpace'];
            }
            $testResult = $testResult && $test;
        }

        //email，邮件格式
        if (in_array('email', $regArray)) {
            if (!($test = $this->eMail($target))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['eMail'];
            }
            $testResult = $testResult && $test;
        }

        //numeric，都是数字
        if (count($pregResult = preg_grep('/^(numeric:)(-?[0-9]+)~(-?[0-9]+)$/', $regArray))) {
            if (!($test = $this->allNumeric($target, $pregResult[1]))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['allNumeric'];
            }
            $testResult = $testResult && $test;
        }

        //alpha，全部都是英文字母
        if (in_array('alpha', $regArray)) {
            if (!($test = $this->allAlpha($target))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['allAlpha'];
            }
            $testResult = $testResult && $test;
        }

        //alpha_dash，可以是英文、数字、下划线(_)和短横线(-)
        if (in_array('alpha_dash', $regArray)) {
            if (!($test = $this->alphaDash($target))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['alphaDash'];
            }
            $testResult = $testResult && $test;
        }

        //alpha_num，必须完全是字母、数字。
        if (in_array('alpha_num', $regArray)) {
            if (!($test = $this->alphaNum($target))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['alphaNum'];
            }
            $testResult = $testResult && $test;
        }

        //phone，电话号码
        if (in_array('phone', $regArray)) {
            if (!($test = $this->phone($target))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['phone'];
            }
            $testResult = $testResult && $test;
        }

        //date，日期
        if (count($pregResult = preg_grep('/^(date:)([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31))~([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31))$/', $regArray))) {
            if (!($test = $this->date($target, $pregResult[1]))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['date'];
            }
            $testResult = $testResult && $test;
        }

        //datetime，日期时间
        if (count($pregResult = preg_grep('/^(datetime:)(([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31)) ((0|1)[0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))~(([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31)) ((0|1)[0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))$/', $regArray))) {
            if (!($test = $this->dateTime($target, $pregResult[1]))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['dateTime'];
            }
            $testResult = $testResult && $test;
        }

        if (preg_grep('/^(reg:)(.|\n|\r)+$/', $regArray)) {
            if (!($test = $this->regExp($target, 'ss'))) {
                $resultInfo .= ErrMsgCN::$ErrMsgCN['regExp'];
            }
            $testResult = $testResult && $test;
        }

        $resultArray['textInfo'] = $resultInfo;
        $resultArray['status'] = $testResult;
        return $testResult;
    }

    /**
     * @param $target
     * @return bool
     */
    public function required($target)
    {
        return strlen($target) == 0 ? false : true;
    }

    /**
     * @param $target
     * @return bool
     */
    public function noWhiteSpace($target)
    {
        return !preg_match('/\s/', $target);
    }

    /**
     * @param $target
     * @return false|int
     */
    public function eMail($target)
    {
        return preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $target);
    }

    /**
     * @param $target
     * @return false|int
     */
    public function allNumeric($target, $regulation)
    {
        preg_match('/^(numeric:)(-?[0-9]{0,})~(-?[0-9]{0,})$/', $regulation, $regResult);
        $min = intval($regResult[2]);
        $max = intval($regResult[3]);
        $target = intval($target);
        return ($target >= $min) && $target && ($target <= $max);
    }

    /**
     * @param $target
     * @return false|int
     */
    public function allAlpha($target)
    {
        return preg_match('/^[a-zA-Z]+$/', $target);
    }

    /**
     * alpha_dash，可以是英文、数字、下划线(_)和短横线(-)
     */
    public function alphaDash($target)
    {
        return preg_match('/^[a-zA-Z0-9|_|-]+$/', $target);
    }

    /**
     * @param $target
     * @return false|int
     */
    public function alphaNum($target)
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $target);
    }

    /**
     * @param $target
     * @return false|int
     */
    public function phone($target)
    {
        return preg_match('/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/', $target);
    }

    /**
     * @param $target
     * @param $regulation
     * @return bool
     */
    public function date($target, $regulation)
    {
        preg_match('/^(date:)([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31))~([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31))$/', $regulation, $regResult);
        $minData = strtotime($regResult[2]);
        $maxDate = strtotime($regResult[8]);
        $targetDate = strtotime($target);
        return ($targetDate >= $minData) && ($targetDate <= $maxDate) && $targetDate;
    }

    /**
     * @param $target
     * @param $regulation
     * @return bool
     */
    public function dateTime($target, $regulation)
    {
        preg_match('/^(datetime:)(([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31)) ((0|1)[0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))~(([0-9]{4}-(0[1-9]|1[0-2])-((0[1-9])|((1|2)[0-9])|30|31)) ((0|1)[0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))$/', $regulation, $regResult);
        $minData = strtotime($regResult[1]);
        $maxDate = strtotime($regResult[12]);
        $targetDate = strtotime($target);
        return ($targetDate >= $minData) && ($targetDate <= $maxDate) && $targetDate;
    }

    /**
     * @param $target
     * @param $regulation
     * @return int
     */
    public function regExp($target, $regulation)
    {
        return 1;
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

    private function errorInfoConcat()
    {

    }
}