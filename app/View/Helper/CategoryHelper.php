<?php

/**
 * CategoryHelper
 *
 *
 * @package       app.View.Helper
 */
class CategoryHelper extends AppHelper {

    public $helpers = array('Html', 'Tile');
    
    // ================================================================
    // ============ Definition of category icons =======================
    private static $categorySet = array();

    public function __construct($view = null) {
        if ($view != null) {
          parent::__construct($view);
        }
        
        self::$categorySet = array(
            'cars' => array('icon' => 'cars', 'name' => __('Car management')                
            ),
            'caradd' => array('name' => __('New car')                
            ),
            'userlogin' => array('icon' => 'user', 'categoryColor' => '',
                'categoryDestination' => array('controller' => 'Users', 'action' => 'index'),
                'name' => __('Hagleitner Sense Management - ') . __('Login'), 'picture_url' => 'configuration/users.png'
            ),
            'useradd' => array('name' => __('New user')
            ),
            'useredit' => array('name' => __('User edit')
            ),
            'users' => array('icon' => 'user', 'categoryColor' => 'Users',
                'categoryDestination' => array('controller' => 'Users', 'action' => 'index'),
                'name' => __('User management'), 'picture_url' => 'configuration/users.png'
            )
        );
    }

    /**
     * Creates a category tile with image only.
     * @return string, the category tile
     */
    public function tile($category = null, $linked = false, $colored = false) {
        if ($category == null) {
            $mySet = $this->getCategorySet($this->params['controller']);
        } else {
            $mySet = $this->getCategorySet($category);
        }

        $target = '';
        if (empty($mySet)) {
            $target = $this->Tile->blank();
        } else {
            $target = $this->getImage($mySet);
            if ($colored) {
               $target = $this->getImage($mySet, $mySet['categoryColor']);
            }
            if ($linked) {
                $destination = $mySet['categoryDestination'];
                $target = $this->Html->link($target, $destination, array('escape' => false));
            }
        }
        return $target;
    }
    
    public function getCategoryHeadline($category = null) {
        if ($category == null) {
            $mySet = $this->getCategorySet($this->params['controller']);
        } else {
            $mySet = $this->getCategorySet($category);
        }
        
        return $this->getHeadline($mySet['name']);
    }
    
    public function getHeadline($text) {
        return "<div class='headlines'><span class='headlinespan'><h2>".$text."</h2></span></div>";
    }

    public function getCategorySet($controller) {
        return CategoryHelper::$categorySet[str_replace('_', '', strtolower($controller))];
    }

    private function getImage($mySet, $color = 'bg-transparent') {
        $target = '';
        if (isset($mySet['picture_url'])) {
            $target = $this->Tile->picture($mySet);
        } else {
            $target = $this->Tile->icon($mySet['icon'], $mySet['name']);
        }

        $target = $this->Tile->basic(
                $target, array(
            'tileClass' => $color
                )
        );
        return $target;
    }

}

?>
