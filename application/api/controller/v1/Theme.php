<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/21
 * Time: 9:08
 */

namespace app\api\controller\v1;


use app\api\validate\IDConllection;
use app\api\service\ProductManager;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\ThemeNew;
use app\api\validate\ProductIDConllection;
use app\lib\exception\ThemeException;

class Theme extends BaseController
{
    protected $beforeActionList = [
        'checkAdminScope' => ['only' => 'getAllThemes,createTheme,updateTheme,updateProductList,removeTheme,batchRemoveTheme'],
    ];

    public function getSimpleList($ids='')
    {
        (new IDConllection())->goCheck();

        $ids = explode(',',$ids);
        $themes = ThemeModel::with('headImg')
            ->select($ids);

        if ($themes->isEmpty()){
            throw new ThemeException();
        }

        return $themes;
    }

    public function getEssenceDetail()
    {
        $themes = ThemeModel::with(['headImg','products'])
                    ->where('is_on','1')
                    ->order('create_time desc')
                    ->select();

        if ($themes->isEmpty()) {
            throw new ThemeException();
        }

        return $themes;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        $theme = ThemeModel::getThemeWithProducts($id);

        if (!$theme){
            throw new ThemeException();
        }

        return $theme;
    }

    public function getAllProduct($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        $theme = ThemeModel::getProducts($id);

        if (!$theme){
            throw new ThemeException();
        }

        return $theme['products'];
    }

    public function getAllThemes()
    {
        //验证权限，只有管理员有此权限

        $themes = ThemeModel::with('headImg')
            ->select();

        if ($themes->isEmpty()) {
            throw new ThemeException();
        }

        return $themes;
    }

    public function createTheme()
    {
        //验证权限，只有管理员有此权限

        $validate = new ThemeNew();
        $validate->scene('create');
        $validate->goCheck();

        $data = $validate->getDataOnScene(input('post.'));

        $theme = ThemeModel::create($data);

        if (!$theme) {
            throw new ThemeException([
                'errorCode' => 300001,
                'msg' => '新增主题失败'
            ]);
        }

        return $theme;
    }

    public function updateTheme($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        //验证权限，只有管理员有此权限

        $validate = new ThemeNew();
        $validate->scene('create');
        $validate->goCheck();

        $data = $validate->getDataOnScene(input('put.'));

        $theme = ThemeModel::find($id);

        if (!$theme) {
            throw new ThemeException();
        }

        if (!$theme->save($data)) {
            throw new ThemeException([
                'errorCode' => 300002,
                'msg' => '更新主题失败',
                'code' => 417
            ]);
        }

        return $theme;
    }

    public function updateProductList($id)
    {
        $idValidate = new IDMustBePostiveInt;
        $idValidate->gocheck();

        $productIdsValidate = new ProductIDConllection;
        $productIdsValidate->gocheck();

        $newProductIds = input('put.product_id');

        $flag = ProductManager::managerByTheme($id, $newProductIds);

        if(!$flag){
            throw new CategoryException([
                'msg' => '商品更新主题失败',
                'errorCode' => 300010,
                'code' => 417
            ]);
        }

        return $flag;
    }

    public function removeTheme($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        //验证权限，只有管理员有此权限
        
        $theme = ThemeModel::destroy($id);

        if (!$theme) {
            throw new ThemeException([
                'errorCode' => 300003,
                'msg' => '删除主题失败'
            ]);
        }

        return $theme;
    }

    public function batchRemoveTheme()
    {
        (new IDConllection())->goCheck();

        //验证权限，只有管理员有此权限

        $ids = input('delete.ids');
        $themes = ThemeModel::destroy($ids);

        if (!$themes) {
            throw new ThemeException([
                'errorCode' => 300004,
                'msg' => '批量删除商品失败'
            ]);
        }

        return $themes;
    }
}