<?php
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {

    public $helpers = array('Html', 'Form', 'Text');
    public $timeout = 10000;
    public $validationDomain = 'validation';
    public $dateFormat = 'yyyy-mm-dd';

    // ================================================================
    // =========== Breadcrumbs & Accordion ============================

    public function truncate($text, $limit = 50) {
        $trimmedText = $text;
        if (strlen($text) > $limit) {
            $trimmedText = $this->Text->truncate(
                    $text, $limit, array(
                'ellipsis' => '...',
                'exact' => true,
                'html' => true
                    )
            );
        }
        return $trimmedText;
    }

    /**
     * Used by all Sites
     * 
     * @param type $crumbs
     * @return string
     */
    public function breadcrumbs($crumbs) {
        // Home
        $home = array('controller' => 'Pages', 'action' => 'display');
        $target = __('Main menu');

        $result = "<div id='navcontainer'>
                      <ul id='navlist'>";
        $result .= "     <li id='active'>" . $this->Html->link($target, $home, array('escape' => false, 'title' => 'Home')) . "</li>";

        // Rest breadcrumbs
        $size = count($crumbs);
        foreach ($crumbs as $i => $crumb) {
            if ($i == $size - 1) {
                $result .= " <li class='active'>";
            } else {
                $result .= " <li>";
            }

            $text = $this->truncate($crumb['text']);
            if (isset($crumb['link'])) {
                $result .= $this->Html->link($text, $crumb['link'], array('escape' => false, 'title' => $crumb['text'])) . "</li>";
            } else {
                $result .= $text . "</li>";
            }
        }

        $result .= "  </ul>
                    </div>";
        return $result;
    }

    // =================================================================

    public function fillDefaults($options, $defaults) {
        foreach (array_keys($defaults) as $key) {
            if (!isset($options[$key])) {
                $options[$key] = $defaults[$key];
            }
        }
        return $options;
    }

    // ===========================================================================

    /*
     * For future use
     */
    public function listViewElement($image, $destination, $title, $subtitle, $remark) {
        $space = "       ";
        $result = "";

        $result .= $space . "<div class='list-content'>\n";

        $result .= $space . $image = $this->Html->image($image, array('class' => 'icon', 'title' => $title));
        $result .= $space . "        <div class='data'>\n";
        $result .= $space . "            <span class='list-title'>$title</span>\n";
        $result .= $space . "            <span class='list-subtitle'>$subtitle</span>\n";
        $result .= $space . "            <span class='list-remark'>$remark</span>\n";
        $result .= $space . "        </div>\n";
        $result .= $space . "</div>\n";

        $result = $this->Html->link(
                $result, $destination, array('class' => 'list', 'escape' => false)
        );

        return $result;
    }

}
