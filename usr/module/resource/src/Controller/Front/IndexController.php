<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14-9-11
 * Time: 上午11:23
 */

namespace Module\Resource\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $model = $this->getModel('resource');
        $select = $model->select()
            ->order('id DESC');
        $rowset = $model->selectWith($select);
        $items = array();
        foreach ($rowset as $row) {
            $items[] = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'icon' => $row['icon'],
                'description' => $row['description'],
                'url' => $this->url('', array(
                        'action' => 'view',
                        'id' => $row['id'],
                    )),
            );
        }
        $this->view()->assign('items', $items);
        $this->view()->setTemplate('index-list');
    }

//    public function downloadAction()
//    {
//        $id = $this->params('id', 0);
//        $rowset = $this->getModel('resource')->find($id);
//        $data = $rowset->toArray();
//        $filename = $data['filename'];
//        $source = 'upload/resource/attach/' . $filename;
//        $options = array(
//            'filename' => $filename,
//            'content_type' => 'application/octet-stream',
//            'content_length' => 1234,
//        );
//        $downloader = new Download;
//        $downloader->send($source, $options);
//
//        //Pi::service('file')->download($source, $options);
//    }

    /**
     * Download a file
     */
    public function downloadAction()
    {
        $path = $this->getUploadPath();
        d($path);
        $id = $this->params('id', 0);
        $rowset = $this->getModel('resource')->find($id);
        $data = $rowset->toArray();
        $filename = $data['filename'];
        $file = $path . '/' . $filename;
        Pi::service('file')->download($file);
    }

    /**
     * Get relative path for upload
     *
     * @return string
     */
    protected function getUploadPath()
    {
        return 'upload/resource/attach';
    }
}