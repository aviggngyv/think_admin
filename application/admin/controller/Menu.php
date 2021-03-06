<?php
namespace app\admin\controller;

use app\admin\model\AuthRule as AuthRuleModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 后台菜单
 * Class Menu
 * @package app\admin\controller
 */
class Menu extends AdminBase {

    protected $auth_rule_model;

    protected function _initialize() {
        parent::_initialize();
        $this->auth_rule_model = new AuthRuleModel();
        $admin_menu_list       = $this->auth_rule_model->order(['sort' => 'DESC', 'id' => 'ASC'])->select();
        $admin_menu_level_list = array2level($admin_menu_list);

        $this->assign('admin_menu_level_list', $admin_menu_level_list);
    }

    /**
     * 后台菜单
     * @return mixed
     */
    public function index() {
        return $this->fetch();
    }

    /**
     * 添加菜单
     * @param string $pid
     * @return mixed
     */
    public function add($pid = '') {
        return $this->fetch('add', ['pid' => $pid]);
    }

    /**
     * 保存菜单
     */
    public function save() {
        $data = $this->request->post();

        if ($this->auth_rule_model->save($data)) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败');
        }
    }

    /**
     * 编辑菜单
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $admin_menu = $this->auth_rule_model->find($id);

        return $this->fetch('edit', ['admin_menu' => $admin_menu]);
    }

    /**
     * 更新菜单
     * @param $id
     */
    public function update($id) {
        $data = $this->request->post();

        if ($this->auth_rule_model->save($data, $id) !== false) {
            $this->success('更新成功');
        } else {
            $this->error('更新失败');
        }
    }

    /**
     * 删除菜单
     * @param $id
     */
    public function delete($id) {
        if ($this->auth_rule_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}