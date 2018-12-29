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
    protected $DEAL_CODE_NUM;
    protected $resetViewData;



    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);

        $this->viewData = new BindViewData();
        $this->NOT_DEAL_CODE_NUM = 0;
        $this->DEAL_CODE_NUM = 1;
        $this->resetViewData = [
            'message'=>'',
            'result_check_code'=>''
        ];
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
        if($valid->getIntegratedStatus()){
            $ORMYbResetPass = New YbResetPass();
            $ybResetPass = $ORMYbResetPass->where('stu_id', '=', $stu_id)->first();
            if($ybResetPass){ //如果已经提交
                //状态为未处理时
                if($this->NOT_DEAL_CODE_NUM === intval($ybResetPass->deal_code)){
                    $this->resetViewData['message'] = '你已提交过重置密码请求，扫描下方二维码或点击链接查看处理进度。';
                    $this->resetViewData['result_check_code'] = $ybResetPass->result_check_code;
//                    var_dump($this->resetViewData['result_check_code']);
//                    var_dump($ybResetPass->deal_code);

                    $this->viewData->setData($this->resetViewData);
                    $this->viewData->setStatus('success');
                }else{  //状态为已处理，再次提交


                    //更新数据库数据
                    $resultCheckCode= uniqid($stu_id,true);
                    $ybResetPass->result_check_code = $resultCheckCode;
                    $ybResetPass->stu_name = $stu_name;
                    $ybResetPass->stu_email = $stu_email;
                    $ybResetPass->old_phone = $old_phone;
                    $ybResetPass->extra_info = $extra_info;
                    $ybResetPass->deal_code = $this->NOT_DEAL_CODE_NUM;


                    if($ybResetPass->save()){
                        $this->resetViewData['message'] = '再次重置密码申请提交成功，扫描下方二维码或点击链接查看进度。';
                        $this->resetViewData['result_check_code'] = $resultCheckCode;
                        $this->viewData->setData($this->resetViewData);
                        $this->viewData->setStatus('success');
                    }else{
                        $this->resetViewData['message'] = '重置密码申请提交失败，请稍后重试！';
                        $this->viewData->setData($this->resetViewData);
                        $this->viewData->setStatus('error');
                    }

                }
            } else{


                $resultCheckCode= uniqid($stu_id,true);
                $ORMYbResetPass->stu_id = $stu_id;
                $ORMYbResetPass->result_check_code = $resultCheckCode;
                $ORMYbResetPass->stu_name = $stu_name;
                $ORMYbResetPass->stu_email = $stu_email;
                $ORMYbResetPass->old_phone = $old_phone;
                $ORMYbResetPass->extra_info = $extra_info;
                if($ORMYbResetPass->save()){

                    $this->resetViewData['message'] = '重置密码申请提交成功，扫描下方二维码或点击链接查看进度。';
                    $this->resetViewData['result_check_code'] = $resultCheckCode;
                    $this->viewData->setData($this->resetViewData);
                    $this->viewData->setStatus('success');
                }else{
                    $this->resetViewData['message'] = '重置密码申请提交失败，请稍后重试！';
                    $this->viewData->setData($this->resetViewData);
                    $this->viewData->setStatus('error');
                }
            }
        }


//
//        var_dump($valid->getResult());
//        var_dump($this->viewData);


        $this->ci->view->render($response, 'resetPass.twig',$this->viewData->toArray());
        return $response;
    }

    public function resetPassResult(Request $request, Response $response, array $args){
        $this->viewData->setStatus('success');
        $this->resetViewData['result_check_code'] = $request->getAttribute('route')->getArgument('result_check_code');

        $ORMYbResetPass = YbResetPass::where('result_check_code', '=', $request->getAttribute('route')->getArgument('result_check_code'))->first();

        if($this->NOT_DEAL_CODE_NUM === intval($ORMYbResetPass->deal_code)){

            $this->resetViewData['message'] = '正在处理中，请稍后再查询。';
        }else if($this->DEAL_CODE_NUM === intval($ORMYbResetPass->deal_code)){

            $this->resetViewData['message'] = $ORMYbResetPass->deal_status_text;
        }
        $this->viewData->setData($this->resetViewData);
        $this->ci->view->render($response, 'resetPassResult.twig', $this->viewData->toArray());
        return $response;
    }
}