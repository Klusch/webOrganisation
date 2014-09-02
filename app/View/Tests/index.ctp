<?php

        $badge = ['content' => $this->Html->tag('i', '', array('class' => 'icon-rocket'))];
        $label = ['content' => 'labeltext'];
        $tile =  $this->Tile->simpleBadge('content', $label, $badge);
            
        $test = [
            ['title' => 'Tab 1',         'content' => '<p>First Tab</p>',                  'class' => 'active'],
            ['title' => 'Other Tab',     'content' => '<p>Second Tab</p>'],
            ['symbole' => 'icon-rocket', 'content' => '<p>Rocket Tab</p>'],
            ['symbole' => 'icon-heart',  'content' => '<p>This tab placed right</p>',      'class' => 'place-right'],
            ['symbole' => 'icon-cog',    'content' => '<p>This tab also placed right</p>', 'class' => 'place-right'],
        ];
        
        echo $this->Tab->createTabs($test);

        
?>
