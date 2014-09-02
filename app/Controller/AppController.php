<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array('DebugKit.Toolbar',
        'Session',
        'Cookie',
        'Acl',
        'Auth'
    );

    public function beforeFilter() {
        $this->Auth->authorize = 'actions';
        $this->Auth->actionPath = 'controllers/';

        // allow all index and view pages
        //$this->Auth->allow('index', 'view');
        // allow everything
        $this->Auth->allow();
    }

}
