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
use Pi\File\Transfer\Download;

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

    public function downloadAction()
    {
        $source = 'upload/resource';
        $options = array(
            'filename'      => 'pi-download',
            'content_type'   => 'application/octet-stream',
            'content_length'=> 1234,
        );
//        $downloader = new Download;
//        $downloader->send($source, options);
        Pi::service('file')->download($source, options);
    }

    public function download($source, array $options = array())
    {
        $downloader = new Download;
        $downloader->send($source, $options);

        d($downloader);
        return $downloader;
    }
} 