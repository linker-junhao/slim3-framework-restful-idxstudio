<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/23
 * Time : 22:28
 */

namespace IdxLib\Util\FormValidation\Local;


class ErrMsgCN
{
    static public $ErrMsgCN = array(
        'required' => '该项必填 ',
        'noWhiteSpace' => '不能有空格符、换行符、制表符 ',
        'eMail' => '请输入电子邮件地址 ',
        'allNumeric' => '只能使用数字 ',
        'allAlpha' => '只能使用英文字母 ',
        'alphaDash' => '只能使用英文字母、数字、下划线“_”和连字符“-” ',
        'num' => '只能使用数字 ',
        'alphaNum' => '只能使用英文字母和数字 ',
        'phone' => '请使用中国手机号码 ',
        'date' => '不在规定日期区间内或不符合“YYYY-MM-DD”格式 ',
        'dateTime' => '不在规定日期时间区间内或不符合“YYYY-MM-DD HH:MM:SS”格式 ',
        'regExp' => '不符合规则 ',

    );
}