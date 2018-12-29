<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2018/12/23
 * Time : 20:20
 */

namespace IdxLib\Standard\BindViewData;


class BindViewData
{
    private $status;
    private $data;
    private $error;

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * get a array of this object's attributions
     */
    public function toArray()
    {
        return array(
            'status' => $this->status,
            'data' => $this->data,
            'error' => $this->error,
        );
    }

    /**
     * get a json of this object's attributions
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}