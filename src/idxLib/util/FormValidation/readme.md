### 用例

``` PHP
//新建一个valid验证对象
$valid = new Validation($this->ci);
//设置get验证规则
$valid->setQueryParamRegulation(array(
    's'=>'required|email'
));
//设置post验证规则
$valid->setPostParamRegulation(array(
    's'=>'required|email'
));
//将信息绑定到视图
$valid->validDone();
//上述三步也可以使用链式写法
$valid->setQueryParamRegulation(array(
            's' => 'required|email'
        ))->setPostParamRegulation(array(
            's' => 'required|email'
        ))->validDone();

//获取验证结果
var_dump($valid->getResult());
```

### 绑定到视图的数据
``` PHP
array(
    'get'=>array(
        'get_field_name1'=>array(
            'textInfo'  =>'some valid info',
            'status'    =>true|false
        ),
        'field_name2'=>array(
            'textInfo'  =>'some valid info',
            'status'    =>true|false
        )
     ),
    'post'=>array(
        'post_field_name1'=>array(
            'textInfo'  =>'some valid info',
            'status'    =>true|false
        ),
        'field_name2'=>array(
            'textInfo'  =>'some valid info',
            'status'    =>true|false
        )
    )
);
```

### 规则
##### required
>表示该项必须有值

##### no_space
>表示不能有空格、\r、\t等控制符

##### email
>验证邮件地址

##### numeric:min~max
>min表示最小值，max表示最大值，都应该为数字形式，可以为负数，用~符号分开表示区间
>
>min或max为“-0”表示不限制下限或上限


##### alpha
>英文字母

##### alpha_dash
>英文字母、数字、下划线(_)和短横线(-)

##### alpha_num
>是字母、数字

##### phone
>中国11位手机电话号码

##### date:minDate~maxDate
>minDate表示最小日期，maxDate表示最大日期，其格式都应是YYYY-MM-DD

##### datetime:minDatetime~maxDatetime
>minDatetime表示最小日期，maxDatetime表示最大日期，其格式都应是YYYY-MM-DD HH:MM:SS

##### reg:
>待完善

##### file:
>待完善





