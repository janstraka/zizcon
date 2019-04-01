<?php
/**
 * Created by PhpStorm.
 * User: Hanc
 * Date: 3. 4. 2016
 * Time: 21:28
 */

namespace BaseModule\Components;

use Entity\File;
use Entity\Gallery;
use Entity\Hotel;
use Libs\NetteUploadableListener;
use Model\BaseService;
use Model\Files;
use Model\Hotels;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Control;

class GalleryEditor extends Control
{
    /** @var NetteUploadableListener */
    public $listener;
    /** @var Files */
    public $files;
    /** @var Hotels */
    public $hotels;
    /** @var IGalleryEditor */
    private $service;

    public function __construct(NetteUploadableListener $listener, Files $files)
    {
        parent::__construct();

        $this->listener = $listener;
        $this->files = $files;
    }

    ////////////////// Public

    public function setService(IGalleryEditor $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $this->template->render(__DIR__ . '/galleryEditor.latte');
    }


    ////////////////// Handles

    public function handleFindAll()
    {
        $files = $this->service->findAll();

        $this->presenter->sendResponse(new JsonResponse($files));
    }

    public function handleUpload()
    {
        $uploaded_files = $this->prepareMultipleFiles($_FILES['imageFile']);

        foreach ($uploaded_files as $uploaded_file) {
            $file = $this->createFileEntity($uploaded_file);

            $this->service->upload($file);
        }
        exit;
    }


    // fiksme implement
    public function handleChangeTitle($id_file, $title)
    {
        $file = $this->files->find($id_file);
        $file->title = $title;

        $this->files->save($file);
    }

    public function handleSort($order)
    {
        $ids = explode(',', $order);
        foreach ($ids as $sort => $id) {
            if (!$id) {
                continue;
            }

            $file = $this->files->find($id);
            $file->sort = $sort;
            $this->files->save($file);
        }
        exit;
    }

    public function handleDelete($id_file)
    {
        $file = $this->files->find($id_file);

        $this->files->delete($file);
    }


    ////////////////// PRIVATE

    /**
     * @param $uploaded_file
     * @return File
     */
    private function createFileEntity($uploaded_file)
    {
        $file = new File;
        $file->sort = 10000; // fiksme, vzit nejvetsi sort a dat +1
        $this->listener->addEntityFileInfo($file, $uploaded_file);
        return $file;
    }

    private function prepareMultipleFiles($files)
    {
        /* Transforming this terrible structure:
           array (5)
           name => array (1)
           |  0 => "26.jpg" (6)
           type => array (1)
           |  0 => "image/jpeg" (10)
           tmp_name => array (1)
           |  0 => "C:\Program Files (x86)\EasyPHP-DevServer-14.1VC11\binaries\tmp\php5C09.tmp" (74)
           error => array (1)
           |  0 => 0
           size => array (1)
           |  0 => 664448*/

        $files_new = [];


        $files_new = $this->iterateOver('name', $files, $files_new);
        $files_new = $this->iterateOver('type', $files, $files_new);
        $files_new = $this->iterateOver('tmp_name', $files, $files_new);
        $files_new = $this->iterateOver('error', $files, $files_new);
        $files_new = $this->iterateOver('size', $files, $files_new);

        return $files_new;
    }

    private function iterateOver($identifier, $files, $files_new)
    {
        foreach ($files[$identifier] as $key => $value) {
            $files_new[$key][$identifier] = $value;
        }

        return $files_new;
    }

}

class HotelGalleryEditor implements IGalleryEditor
{
    private $id_parent;
    private $hotels;

    public function __construct(BaseService $hotels, $id_parent  = 0)
    {
        $this->hotels = $hotels;
        $this->id_parent = $id_parent;
    }

    public function upload($file)
    {
        /** @var Hotel $hotel */
        $hotel = $this->hotels->find($this->id_parent);
        $hotel->addAward($file);
        $this->hotels->save($hotel);
    }

    public function findAll()
    {
        $hotel = $this->hotels->find($this->id_parent);

        $files = [];
        /** @var File $file */
        foreach ($hotel->awards as $file) {
            $files[] = [
                'id' => $file->getId(),
                'title' => $file->title,
                'path' => $file->path,
            ];
        }

        return $files;
    }
}

class GalleriesGalleryEditor implements IGalleryEditor
{
    private $id_parent;
    private $galleries;

    public function __construct(BaseService $galleries, $id_parent  = 0)
    {
        $this->galleries = $galleries;
        $this->id_parent = $id_parent;
    }

    public function upload($file)
    {
        /** @var Gallery $gallery */
        $gallery = $this->galleries->findOneByTitle($this->id_parent);
        $gallery->addPicture($file);
        $this->galleries->save($gallery);
    }

    public function findAll()
    {
        /** @var Gallery $gallery */
        $gallery = $this->galleries->findOneByTitle($this->id_parent);

        $files = [];
        /** @var File $file */
        foreach ($gallery->pictures as $file) {
            $files[] = [
                'id' => $file->getId(),
                'title' => $file->title,
                'path' => $file->path,
            ];
        }

        return $files;
    }
}

interface IGalleryEditor
{
    public function __construct(BaseService $service, $id_parent);
    public function upload($file);
    public function findAll();
}

interface IGalleryEditorFactory
{
    /** @return GalleryEditor */
    function create();
}