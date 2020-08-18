<?php
require '../vendor/autoload.php';

$sheetFileName = '/Users/xukang/Desktop/mooncake.xlsx';
$imageDirPath = '../storage/app/excel';

//$sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($sheetFileName)->getActiveSheet();
//$sheet->toArray();
//$sheet->getDrawingCollection()->getIterator();


$excelImageHandler = new \App\Handlers\ExcelImageHandler();
$result = $excelImageHandler->setFilePath($sheetFileName)
                            ->setImageDirPath($imageDirPath)
                            ->loadSheet()
                            ->loadImages()
                            ->process();

var_dump($result);
