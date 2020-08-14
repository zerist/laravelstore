<?php
namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'jpeg', 'gif'];

    public function save($file, $folder, $file_prefix)
    {
        $folder_name = "uploads/images/$folder" . data("Ym/d", time());

        $upload_path = public_path() . '/' .$folder_name;

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename = $file_prefix . '_' .time() . '_' . Str::random(10) . '.' . $extension;

        if (! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . "/$folder_name/$filename",
        ];
    }
}
