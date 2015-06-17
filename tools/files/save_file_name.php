<?php

$fileId = intval($_REQUEST['fileId']);
$fileName = Loader::helper('text')->sanitize($_REQUEST['fileName']);

$file = File::getByID($fileId);

// check if we already have a file with the target name
$f = Loader::helper('concrete/file');
if ($file->getStorageLocationID() > 0) {
    $fsl = FileStorageLocation::getByID($file->getStorageLocationID());
    $path = $f->mapSystemPath($file->getPrefix(), $fileName, false, $fsl->getDirectory());
}
else {
    $path = $f->mapSystemPath($file->getPrefix(), $fileName, false);
}
if (file_exists($path)) {
    echo t('File with the name "%s" already exists in the directory "%s"!', $fileName, $file->getPrefix());
    die();
}

// get old paths of file
$oldPath = $file->getPath();
$oldPathThumbnail1 = $file->hasThumbnail(1) ? $file->getThumbnailPath(1) : false;
$oldPathThumbnail2 = $file->hasThumbnail(2) ? $file->getThumbnailPath(2) : false;
$oldPathThumbnail3 = $file->hasThumbnail(3) ? $file->getThumbnailPath(3) : false;

// rename file in database
$file->updateFile($fileName, $file->getPrefix());

// rename files on disk
rename($oldPath, $file->getPath());
if ($oldPathThumbnail1) {
    rename($oldPathThumbnail1, $file->getThumbnailPath(1));
}
if ($oldPathThumbnail2) {
    rename($oldPathThumbnail2, $file->getThumbnailPath(2));
}
if ($oldPathThumbnail3) {
    rename($oldPathThumbnail3, $file->getThumbnailPath(3));
}