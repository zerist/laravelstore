<?php
namespace App\Handlers;

class ExcelImageHandler
{
    protected $filePath;
    protected $workSheet;
    protected $imageDirPath;
    protected $images;

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function setImageDirPath($path)
    {
        $this->imageDirPath = $path;
        return $this;
    }

    public function loadSheet()
    {
        if (!$this->workSheet) {
            $this->workSheet = (\PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath))->getActiveSheet();
        }
        return $this;
    }

    public function loadImages()
    {
        $this->images = $this->workSheet->getDrawingCollection();
        return $this;
    }

    public function process()
    {
//        $result = array_map(function ($row, $image){
//            //收集数据
//            $data = $this->gatherRowData($row);
//            //保存图片到本地文件
//            $this->saveImage($image, $data['image']);
//
//            return $data;
//        }, $this->workSheet->getRowIterator(), $this->images->getIterator());

        $result = [];
        $isFirst = true;
        $imageIterator = $this->images->getIterator();
        foreach ($this->workSheet->getRowIterator() as $row) {
            //收集数据
            $data = $this->gatherRowData($row);

            //保存图片到本地文件
            if ($isFirst) {
                $image = $imageIterator->current();
                $isFirst = false;
            } else if ($imageIterator->valid()){
                $imageIterator->next();
                $image = $imageIterator->current();
            } else {
                continue;
            }

            if ($image) {
                $data['image'] = $this->saveImage($image, $data['image']);
                $result[] = $data;
            }
        }

        return $result;
    }

    public function generateImagePath($imageName)
    {
        return $this->imageDirPath . DIRECTORY_SEPARATOR . md5($imageName);
    }

    public function gatherRowData($row)
    {
        $cells = $row->getCellIterator();
        $cells->next();
        $name = $cells->current()->getValue();
        $cells->next();
        $content = $cells->current()->getValue();
        $imagePath = $this->generateImagePath($name);
        //$cells->next();
        $cells->next();
        $price = $cells->current()->getValue();

        return [
            'name' => $name,
            'content' => $content,
            'image' => $imagePath,
            'price' => $price,
        ];
    }

    public function saveImage($image, $imageName)
    {
        try {
            $imageType = $image->getExtension();
            switch ($imageType) {
                case 'jpg':
                case 'jpeg':
                    $imageName .= '.jpg';
                    $source = imagecreatefromjpeg($image->getPath());
                    imagejpeg($source, $imageName);
                    break;
                case 'gif':
                    $imageName .= '.gif';
                    $source = imagecreatefromgif($image->getPath());
                    imagegif($source, $imageName);
                    break;
                case 'png':
                    $imageName .= '.png';
                    $source = imagecreatefrompng($image->getPath());
                    imagegif($source, $imageName);
                    break;
            }
            return $imageName;
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
