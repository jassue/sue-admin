<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/6/30
 * Time: 19:22
 */

namespace app\service;


use think\facade\Request;
use think\File;

class UploadImage
{
    private $rootPath = 'uploads/';

    /**
     * @param $savePath
     * @return string
     */
    public function getUrl($savePath)
    {
        return Request::domain() . '/' . $this->rootPath . $savePath;
    }

    /**
     * @param File $file
     * @param string $dirName
     * @return array|string
     */
    public function upload(File $file, $dirName = 'default')
    {
        $path = $this->rootPath . $dirName;
        $info = $file->rule('uniqid')->move($path);
        if ($info) {
            $savePath = $dirName . '/' . $info->getSaveName();
            $url = $this->getUrl($savePath);
        } else {
            $errMsg = $file->getError();
        }
        return $errMsg ?? ['path' => $savePath, 'url' => $url];
    }

    /**
     * @param $path
     */
    public function deleteImage($path)
    {
        unlink(getcwd() . '/' . $this->rootPath . $path);
    }
}