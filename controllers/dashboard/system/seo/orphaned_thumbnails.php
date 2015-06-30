<?php
defined('C5_EXECUTE') or die('Access Denied.');

class DashboardSystemSeoOrphanedThumbnailsController extends Controller
{
    public function view() {
        $db = Loader::db();

        $directory = new RecursiveDirectoryIterator(DIR_FILES_CACHE);
        $flattened = new RecursiveIteratorIterator($directory);

        $files = new RegexIterator($flattened, '/^.+_f(\d)\.(jpeg|jpg|gif|png)$/i', RegexIterator::GET_MATCH);
        $thumbnails = [];

        foreach($files as $file) {
            $exists = $db->GetOne('SELECT 1 FROM Files WHERE fID = ?', [$file[1]]);
            if (!$exists) {
                $thumbnails[] = [
                    'id' => $file[1],
                    'filename' => basename($file[0]),
                    'ext' => $file[2],
                    'size' => getimagesize($file[0]),
                    'modification_date' => filemtime($file[0]),
                ];
            }
        }

        $this->set('thumbnails', $thumbnails);
    }

    public function delete_file()
    {
        $filename = Loader::helper('text')->sanitize($_REQUEST['filename']);
        unlink(DIR_FILES_CACHE . DIRECTORY_SEPARATOR . $filename);
        die();
    }
}