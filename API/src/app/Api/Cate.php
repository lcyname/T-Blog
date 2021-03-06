<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\Cate as CateDomain;
use App\Model\ArticleCate as ArticleCateModel;

/**
 * Cate管理类
 * 
 * @author: iimT tfhhh@qq.com 2018.3.11
 */
class Cate extends Api {
    protected $model;
    function __construct() {
        $this->model = new CateDomain();
    }
    public function getRules() {
        return array(
            'add'        => array(
                'name'   => array('name' => 'name')
            ),
            'updateById' => array(
                'id'     => array('name' => 'id'),
                'name'   => array('name' => 'name'),
            ),
            'getById' => array(
                'id'     => array('name' => 'id')
            ),
            'deleteById' => array(
                'id'     => array('name' => 'id')
            ),
        );
    }

    function getById () {
        return $this->model->getById($this -> id);
    }

    /**
     * 增加一个分类
     * 
     * @param string 分类名称
     * 
     * @return int 新增分类的id
     */
    public function add() {
        $data = array(
            'name' => $this->name
        );
        return $this->model->insert($data);
    }

    /**
     * 根据id更新分类
     * 
     * @param string 新的分类名
     * 
     * @return int 有更新返回1 无变化返回0 错误返回false
     */
    public function updateById() {
        $data = array(
            'name' => $this->name
        );
        return $this->model->updateById($this->id, $data);
    }

    /**
     * 根据id删除分类
     * 
     * 
     * @return int 1成功 0失败
     */
    public function deleteById() {
        return $this->model->deleteById($this->id);
    }
    /**
     * 获取全部分类
     * 
     * @return array 全部分类的数组
     */
    public function getAll(){
        $data = $this->model->getAll();
        //循环获取数量并添加进data
        $res_data = array();
        foreach ($data as $row) {
            $cateId = $row['id'];
            $articleCateModel = new ArticleCateModel();

            $count = $articleCateModel->countByCateId($cateId);
            $row['sum'] = $count;
            array_push($res_data, $row);
        }
        return $res_data;
    }
}
?>