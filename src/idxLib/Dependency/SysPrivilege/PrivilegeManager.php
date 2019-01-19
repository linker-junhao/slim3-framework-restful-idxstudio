<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/18
 * Time : 14:15
 */

namespace IdxLib\Dependency\SysPrivilege;


class PrivilegeManager
{
    //TODO 这部分一大堆事情没有做，或者说压根没做
    private $pdo = null;
    private $table = null;

    public function __construct(
        \PDO $pdo,
        $table = array(
            'role' => 'table_privilege_role',
            'api_src' => 'table_privilege_src'
        )
    )
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function getRoleByName($roleName)
    {
        $sql = 'select * from `' . $this->table['role'] . '` where role_name = \'' . $roleName . '\'';
        return $this->pdo->query($sql);
    }

    public function getRoleByID($roleID)
    {
        $sql = 'select * from `' . $this->table['role'] . '` where id = \'' . $roleID . '\'';
        return $this->pdo->query($sql);
    }

    public function setRole()
    {

    }
}