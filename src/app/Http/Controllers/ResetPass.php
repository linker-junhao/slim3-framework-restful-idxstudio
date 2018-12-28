<?php
/**
 * Created by PhpStorm.
 * User: Shinelon
 * Date: 2018/12/21
 * Time: 18:55
 */

namespace App\Http\Controllers;

use App\Models\ORM\YbResetPass;
use IdxLib\standard\BindViewData\BindViewData;
use IdxLib\util\FormValidation\Validation;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ResetPass extends AbstractController
{

//    返回视图的数据
    protected $viewData;
//    用户充值密码请求未处理标志
    protected $NOT_DEAL_CODE_NUM;



    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);

        $this->viewData = new BindViewData();
        $this->NOT_DEAL_CODE_NUM = 0;
    }

    /**
     * return reset password view response
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response $response.
     */
    public function get(Request $request, Response $response, array $args)
    {
        $this->ci->view->render($response, 'resetPass.twig');
        return $response;
    }

    /**
     * return reset password check response
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response $response.
     */
    public function post(Request $request, Response $response, array $args)
    {

        //获取请求参数
        $stu_name = trim($request->getParam('stu_name'));
        $stu_id = trim($request->getParam('stu_id'));
        $stu_email = trim($request->getParam('stu_email'));
        $old_phone = trim($request->getParam('old_phone'));
        $extra_info = trim($request->getParam('extra_info'));


        //        TODO 测试输出
//        echo '<br/>stu_name: ';
//        echo $stu_name;
//        echo '<br/>stu_id: ';
//        echo $stu_id;
//        echo '<br/>stu_email: ';
//        echo $stu_email;
//        echo '<br/>old_phone: ';
//        echo $old_phone;
//        echo '<br/>extra_info: ';
//        echo $extra_info;
//        echo '<br/>';

        $valid = new Validation($this->ci);
        $valid->setPostParamRegulation(array(
            'stu_name' => 'required',
            'stu_id' => 'required|numeric:1000000000~3000000000',
            'stu_email' => 'required|email',
            'old_phone' => 'required|phone',
        ))->validDone();

        //获取验证结果
//        var_dump($valid->getResult());


        $ORMYbResetPass = New YbResetPass();
        $ybResetPass = $ORMYbResetPass->where('stu_id', '=', $stu_id)->first();
        if($ybResetPass){ //如果已经提交还未处理
            //状态为未处理时
            if($this->NOT_DEAL_CODE_NUM === intval($ybResetPass->deal_code)){

                $this->viewData->setData('你已提交过充值密码请求，正在处理中！');
                $this->viewData->setStatus('success');
            }
        }else{


            $ORMYbResetPass->stu_id = $stu_id;
            $ORMYbResetPass->stu_name = $stu_name;
            $ORMYbResetPass->stu_email = $stu_email;
            $ORMYbResetPass->old_phone = $old_phone;
            $ORMYbResetPass->extra_info = $extra_info;
            if($ORMYbResetPass->save()){

                $this->viewData->setData('重置密码申请提交成功！');
                $this->viewData->setStatus('success');
            }else{

                $this->viewData->setData('重置密码申请提交失败，请稍后重试！');
                $this->viewData->setStatus('error');
            }
        }


        var_dump($valid->getResult());
        var_dump($this->viewData);


        $this->ci->view->render($response, 'resetPass.twig',$this->viewData->toArray());
        return $response;
    }
}