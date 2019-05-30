<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    // 允许的后缀名
    protected $allowed_ext = ['png', 'jpg', 'jpeg', 'gif'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        // 构建存储的文件规则，值如:uploads/images/avatars/201812/27/
        // 文件夹切割能让查询效率更高
        $folder_name = "uploads/images/$folder".date('Ym/d', time());

        // 文件具体的存储路径，`public_path()`获取的是`public`文件夹的物理路径
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201812/27/
        $upload_path = public_path().'/'.$folder_name;

        // 获取文件的后缀名，确保后缀存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        //拼接文件名，加前缀是为了增加辨识度，前缀可以是相关数据模型的ID
        // 值如：1_1493564380_7BVc9c9ujP.png
        $filename = $file_prefix.'_'.time().'_'.str_random(10).'.'.$extension;

        // 如果上传的不是图片，将中止
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 将图片移动到目标路径
        $file->move($upload_path, $filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            // 裁剪图片
            $this->reduceSize($upload_path.'/'.$filename, $max_width);
        }

        return ['path' => config('app.url')."/$folder_name/$filename"];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁剪图片时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}