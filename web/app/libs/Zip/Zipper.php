<?php

namespace Libs;

use ZipArchive;

class Zipper
{
    private $dir;
    private $zipped_file;


    public function zip($dir, $zipped_file)
    {
        $this->dir = $dir;
        $this->zipped_file = $zipped_file = $dir . $zipped_file;


        $files_array = [];
        $invoice_files = scandir($dir);
        foreach ($invoice_files as $filename) {
            if ($filename != '.' AND $filename != '..') {
                $files_array[] = ['path' => $dir . $filename, 'name' => $filename];
            }
        }


        return $this->createZip($files_array, $zipped_file, true);
    }

    private function createZip($files = [], $destination = '', $overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = [];
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file['path'])) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();

            if ($zip->open($destination, $overwrite ? ZipArchive::OVERWRITE : ZipArchive::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file['path'], $file['name']);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }


    public function truncateDirectory()
    {
        $files = scandir($this->dir); // get all file names
        foreach ($files as $file) { // iterate files
            $fullpath = $this->dir . $file;
            if (is_file($fullpath)) {
                unlink($fullpath); // delete file
            }
        }
    }

}