<?php

namespace App\Models;

use App\Handlers\ExcelImageHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RonghuaCake extends Model
{
    public $fillable = [
        'name',
        'content',
        'image',
        'price',
    ];

    public $handler;
    public $imageDirPath;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->handler = new ExcelImageHandler();
        $this->imageDirPath = storage_path('app/excels');
    }

    protected function processExcel($sheetFilePath = '')
    {
        return $this->handler
            ->setFilePath($sheetFilePath)
            ->setImageDirPath($this->imageDirPath)
            ->loadSheet()
            ->loadImages()
            ->process();
    }

    public function saveExcel($sheetFilePath = '')
    {
        $cakes = $this->processExcel($sheetFilePath);
        $cakes = array_filter($cakes, function ($cake) {
            return !!$cake['name'];
        });
        DB::table($this->getTable())->insert($cakes);
    }
}
