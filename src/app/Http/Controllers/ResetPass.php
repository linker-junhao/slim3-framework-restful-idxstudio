<?php
/**
 * Created by PhpStorm.
 * User: Shinelon
 * Date: 2018/12/21
 * Time: 18:55
 */

namespace App\Http\Controllers;

use App\Models\ORM\YbResetPass;
use Slim\Http\Request;
use Slim\Http\Response;

class ResetPass extends AbstractController
{
//    public function get(Request $request, Response $response, array $args)
//    {
//        $this->ci->view->render($response, 'resetPass.twig');
//        return $response;
//    }

    protected $NOT_DEAL_CODE_NUM = 0;

    public function get(Request $request, Response $response, array $args)
    {

        //获取请求参数
        $stu_name = $request->getParam('stu_name');
        $stu_id = $request->getParam('stu_id');
        $stu_email = $request->getParam('stu_email');
        $old_phone = $request->getParam('old_phone');
        $extra_info = $request->getParam('extra_info');


        echo $stu_name;
        echo '<br/>';
        echo $stu_id;
        echo '<br/>';
        echo $stu_email;
        echo '<br/>';
        echo $old_phone;
        echo '<br/>';
        echo $extra_info;
        echo '<br/>';

        $ORMYbResetPass = New YbResetPass();
        $ybResetPass = $ORMYbResetPass->where('stu_id', '=', $stu_id)->first();
        if($ybResetPass){ //如果已经提交还未处理
            //状态为未处理时
            if($this->NOT_DEAL_CODE_NUM === intval($ybResetPass->deal_code)){
                var_dump($ybResetPass->deal_code);
                var_dump($ybResetPass->stu_name);
            }
        }else{


            $ORMYbResetPass->stu_name = $stu_name;
            $ORMYbResetPass->stu_id = $stu_id;
            $ORMYbResetPass->stu_email = $stu_email;
            $ORMYbResetPass->old_phone = $old_phone;
            $ORMYbResetPass->old_phone = $old_phone;
            $ORMYbResetPass->extra_info = $extra_info;
            if($ORMYbResetPass->save()){

                echo 'success';   //TODO
            }
        }






        return $response;
    }
}