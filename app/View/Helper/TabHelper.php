<?php

class TabHelper extends AppHelper {

    public $helpers = array('Html');

    /**
     * 'class' => active, place-right
     * 'symbole' => e.g. icon-rocket
     * 'title' => the title
     * 
     * @return type
     */
    private function tabsList($elements) {
        $listElements = '';
        foreach ($elements as $i => $element) {

            $inHeadline = '';
            if (isset($element['title'])) {
                $inHeadline = $element['title'];
            } else {
                $inHeadline = $this->Html->tag('i', '', array('class' => $element['symbole']));
            }
            $headline = $this->Html->link($inHeadline, '#_page_' . ($i + 1), array('escape' => false));

            $class = null;
            if (isset($element['class'])) {
                $class = 'class=' . $element['class'];
            }

            $listElements .= $this->Html->tag('li', $headline, $class) . "\n";
        }

        $list = $this->Html->tag('ul', $listElements, array('class' => 'tabs'));
        return $list;
    }

    private function frames($elements) {
        $inFrames = '';
        foreach ($elements as $key => $element) {
            $inFrames .= $this->Html->div('frame', $element['content'], ['id' => '_page_' . ($key + 1), 'style' => 'display: block;']
            );
        }

        return $this->Html->div('frames', $inFrames);
    }

    public function createTabs($tabs) {
        $content = $this->tabsList($tabs);
        $content .= $this->frames($tabs);
        return $this->Html->div('tab-control', $content, array('data-role' => 'tab-control'));
    }

    protected function testTabs() {
        $test = [
            ['title' => 'Tab 1',         'content' => '<p>First Tab</p>',                  'class' => 'active'],
            ['title' => 'Other Tab',     'content' => '<p>Second Tab</p>'],
            ['symbole' => 'icon-rocket', 'content' => '<p>Rocket Tab</p>'],
            ['symbole' => 'icon-heart',  'content' => '<p>This tab placed right</p>',      'class' => 'place-right'],
            ['symbole' => 'icon-cog',    'content' => '<p>This tab also placed right</p>', 'class' => 'place-right'],
        ];
        
        $this->createTabs($test);
    }
    
}

?>
