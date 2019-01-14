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
     * @return BindViewData
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param mixed $error
     * @return BindViewData
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @param mixed $status
     * @return BindViewData
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
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