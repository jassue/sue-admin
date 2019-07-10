<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:21
 */

namespace app\common\model;


use app\common\enum\BaseStatus;
use app\service\facade\UploadImage;

class Admin extends BaseUser
{
    /**
     * @return \think\model\relation\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, AdminRoleRelation::class, 'role_id', 'admin_id');
    }

    /**
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'avatar_id');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getStatusAttr($value)
    {
        return BaseStatus::$statusMap[$value];
    }

    /**
     * @param $value
     * @return false|string
     */
    public function getLastLoginTimeAttr($value)
    {
        return $value != 0 ? date('Y-m-d H:i:s', $value) : '';
    }

    /**
     * @param $value
     * @return int
     */
    public function setLastLoginIpAttr($value)
    {
        return ip2long($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getLastLoginIpAttr($value)
    {
        return $value != 0 ? long2ip($value) : '';
    }

    /**
     * @param $value
     * @return string
     */
    public function getAvatarAttr($value)
    {
        $avatar = $this->image;
        return is_null($avatar) ? '/static/admin/img/default_avatar.png' : UploadImage::getUrl($avatar->path);
    }
}