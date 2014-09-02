<?php

class AccordionHelper extends AppHelper {

    public $helpers = array('Html');

    /**
     * Implements the accordion of Metro UI Framework
     * 
     * @param $frames           An array with subaccordions in accordion
     * @param $classAttributes
     * @return An accordion
     */
    public function accordion($frames, $classAttributes = array()) {
        $class = 'accordion ';
        $properties = "data-role='accordion' data-closeany='false'";

        foreach ($classAttributes as $classAttribute) {
            $class .= $classAttribute . " ";
        }

        $result = "<div class='" . $class . "' " . $properties . ">";
        foreach ($frames as $frame) {
            $head = $this->createAccordionHead($frame['head']);
            $content = $this->createAccordionBody($frame['content']);
            $result .= $this->combineAccordionParts($head, $content);
        }
        $result .= "</div>";
        return $result;
    }

    private function createAccordionHead($headline, $inactive = false) {
        $class = "heading collapsed";
        $destination = '#';
        $properties = null;

        if ($inactive == true) {
            $properties = "none";
        }

        return $this->Html->link($headline, $destination, array('class' => $class, 'data-action' => $properties));
    }

    private function createAccordionBody($content) {
        $style = "'display: block;'";
        $result = "<div class='content' style=" . $style . ">" .
                $content .
                "</div>";
        return $result;
    }

    private function combineAccordionParts($head, $content, $filter = null, $active = 'active') {
        return "<div class='accordion-frame " . $active . "'>" .
                $filter .
                $head .
                $content .
                "</div>";
    }

}
?>