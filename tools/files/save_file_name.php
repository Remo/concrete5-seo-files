<?php

$fileId = intval($_REQUEST['fileId']);
$fileName = Loader::helper('text')->sanitize($_REQUEST['fileName']);

$file = File::getByID($fileId);

$oldPath = $file->getPath();
$oldPathThumbnail1 = $file->hasThumbnail(1) ? $file->getThumbnailPath(1) : false;
$oldPathThumbnail2 = $file->hasThumbnail(2) ? $file->getThumbnailPath(2) : false;
$oldPathThumbnail3 = $file->hasThumbnail(3) ? $file->getThumbnailPath(3) : false;

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