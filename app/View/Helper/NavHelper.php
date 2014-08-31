<?php

//define('IND', (PHP_SAPI == 'cli') ? PHP_EOL : '                                          ');
//define('IND2', (PHP_SAPI == 'cli') ? PHP_EOL : '                                    ');

// http://advitum.de/2013/05/cakephp-tutorial-views-layouts-und-helpers/
App::uses('AclComponent', 'Controller/Component');

class NavHelper extends AppHelper {

    public $name = 'Nav';
    public $helpers = array('Html');

    public function topBar($user = array()) { //navigation-bar-content container
        $result = "<nav class='horizontal-menu compact'>
                   <ul>";
        $result .= $this->getLogo();
        $result .= $this->getLanguages();
        $result .= $this->loginOrLogout($user);
        $result .= $this->showLoginName($user);
        $result .= "</ul>
                    </nav>";
        return $result;
    }

    private function getLogo() {
        return "<li>" .
//               $this->Html->image('hagleitner/Hagleitner_Logo_klein.png', array('id' => 'logo', 'width' => '100', 'alt' => 'Icon')) .
               "</li>";
    }
    
    private function showLoginName($user) {
        $name = __('No user') . " " . __('is logged in');
        
        if (!empty($user)) {
            $name = $user['first_name'] . " " . $user['last_name'];
            if ($name == ' ') {
                $name = $user['username'];
            }
        }
        
        $destination = array('controller' => 'Configurations', 'action' => 'index');
        
        return "<li id='login' class='place-right'>" . $this->Html->link($name, $destination) . "</li>";
    }

    private function startPoint($user) {
        $destination = array('controller' => 'pages', 'action' => 'display', 'home');

        if (!empty($user)) {
            $destination = array('controller' => 'Configurations', 'action' => 'index');
        }

        return "<li>" .
                $this->Html->link(__('Home'), $destination) .
                "</li>\n";
    }

    private function arrayToURLParameter($params) {
        $result = "/";
        foreach ($params as $param) {
            $result .= $param . "/";
        }
        return $result;
    }
    
    private function getLanguages() {
        $destination = array(
            'controller' => $this->request->controller,
            'action' => $this->request->action .  $this->arrayToURLParameter($this->request->pass),
            'language' => 'eng'
        );
        $destEng = $destination;
        
        $destination['language'] = 'deu';
        $destDeu = $destination;
        
        return "<li class='place-right'>
                <a class='dropdown-toggle' href='#'>".$this->request->language."</a>
                <ul class='dropdown-menu' data-role='dropdown'>
                    <li>" . $this->Html->link('eng', $destEng) . "</li>\n
                    <li style='margin-left:0px;'>" . $this->Html->link('deu', $destDeu) . "</li>\n
                </ul>
                </li>"; 
    }

    private function loginOrLogout($user) {
        $destination = array('controller' => 'Users', 'action' => 'login');
        $text = __('Sign in');
        
        if (!empty($user)) {
            $destination = array('controller' => 'Users', 'action' => 'logout');
            $text = __('Sign out');
        }
        
        $config = array('title' => $text);
        
        return "<li class='place-right'>" . $this->Html->link($text, $destination, $config) . "</li>";
    }

}

?>