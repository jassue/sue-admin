<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/30
 * Time: 19:20
 */

namespace app\admin\controller;


use app\common\exception\BusinessException;
use app\common\response\SuccessResult;
use app\service\facade\UploadImage;
use think\facade\Validate;
use think\Request;

class Common extends AdminBaseController
{
    public function uploadImage(Request $request)
    {
        $validate = Validate::make(
            [
                'image'          => 'require|fileExt:jpg,jpeg,png|fileSize:5242880'
            ],
            [
                'image.required' => '图片不能为空',
                'image.fileExt'  => '图片格式不正确',
                'image.fileSize' => '图片大小不能大于5M'
            ]
        );
        $result = $validate->check($request->file());
        if (!$result) {
            throw new BusinessException($validate->getError());
        }
        $uploadResult = UploadImage::upload($request->file('image'), 'admin');
        if (is_string($result)) {
            throw new BusinessException($uploadResult);
        }
        return $this->json(new SuccessResult($uploadResult));
    }
}