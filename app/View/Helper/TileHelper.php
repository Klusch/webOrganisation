<?php

App::uses('Helper', 'View');
App::uses('ProjectSpecificHelper', 'View/Helper');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class TileHelper extends ProjectSpecificHelper {

    public $helpers = array('Html', 'Form', 'Text', 'Devices', 'Plot');

    /**
     * Creates a tile-content div from an item's icon.
     *
     * @param array $item the item with field 'icon'
     * @return string the item's icon in a tile-content div
     */
    public function icon($class, $text = '') {
        $content = $this->iconTag($class);
        return $this->content($content, 'icon', array('title' => $text));
    }

    private function iconTag($class) {
        return $this->Html->tag("i", "", array('class' => "icon-$class"));
    }

    // ========================================================================

    /**
     * Creates a tile-content div from an item's picture_url.
     *
     * @param array $item the item with field 'picture_url'
     * @return string the item's picture_url in a tile-content div
     */
    public function picture($item) {
        $content = $this->pictureTag($item);
        return $this->content($content, 'image');
    }

    private function pictureTag($item) {
        return $this->Html->image($item['picture_url'], array('alt' => $item['name'], 'title' => $item['name']));
    }

    // ========================================================================

    /**
     * 
     * @param type $id
     * @param type $text
     * @param type $destination
     * @param type $image
     * @param type $title
     * @return type
     */
    public function linkTile($id, $text, $destination, $image, $title = null) {
        $result = $this->selectableTile($id, $text, $image);
        return $this->Html->link($result, $destination, array('escape' => false, 'title' => $title));
    }

    //ToDo: Refractor
    private function selectableTile($id, $text, $image, $onclickHandler = array(), $selected = false) {
        $result = "<div " . ($id != null ? "id=$id" : "") . " class='tile triple User UsersLight" . ($selected ? " selected" : "") . "'" .
                (!empty($onclickHandler) ? " onclick=$onclickHandler " : "") . ">
    					<div class='tile-content image'>";
        $result .= $image;
        $result .= "</div>";
        if (isset($id)) {
            $result .= "<input type='hidden' name='data[Selection][selectedTiles][" . $id . "]' value='" . ($selected ? "selected" : "") . "'></input>";
        }
        $result .= "<div class='userbrand'>
    	<span class='text'>" .
                $text
                . "</span>
                     </div>
    			</div>";
        return $result;
    }

    /**
     * Creates an overlay text div with opacity from an item's text or alternative name.
     *
     * @param array $item the item with field 'name'
     * @return string the item's name in a div
     */
    public function text($item) {
        $text = $item['name'];
        if (isset($item['text'])) {
            $text = $item['text'];
        }
        $text = $this->truncate($text, 100);
        $span = $this->span($text, array(
            'class' => 'text',
            'style' => 'word-wrap: break-word;'
                )
        );
        return $this->Html->div("brand bg-grayLight opacity", $span, array(
                    'style' => 'z-index:1'
                        )
        );
    }

    /**
     * Creates a span tag.
     *
     * @param string $content the inner part of the span
     * @param array $options the span options
     * @return string the span
     */
    public function span($content, $options = array()) {
        return $this->Html->tag('span', $content, $options);
    }

    /**
     * Creates a HTML link.
     *
     * @param string $text the link text
     * @param string $content the inner part of the link, maybe an image or div
     * @param array $destination the link url
     * @param array $options the link options
     * @return string the link
     */
    public function link($text, $content, $destination = null, $options = array(), $linkid = null) {
        $link = $content;
        if (isset($destination)) {
            $link = $this->Html->link($content, $destination, array_merge($options, array(
                'title' => $text,
                'escape' => false,
                'id' => $linkid
                            )
                    )
            );
        }
        return $link;
    }

    /**
     * Creates a tile-content div.
     *
     * @param string $content the inner part of the content div
     * @param string $contentClass the additional class parts of the content div
     * @param array $options the options the content div, like style
     * @return string the tile-content div
     */
    public function content($content, $contentClass, $options = array()) {
        return $this->Html->div("tile-content $contentClass", $content, $options);
    }

    /**
     * Creates an empty blank tile.
     *
     * @param string $type the inner part of the blank tile
     * @return string the basic tile div
     */
    public function blank($type = '') {
        return $this->basic($type);
    }

    /**
     * Creates a basic tile.
     *
     * @param string $content the div as inner part of the basic tile
     * @param array $classes list of parameters
     * @return string the basic tile div
     */
    public function basic($content, $classes = array()) {
        $classes = $this->fillDefaults($classes, array(
            'tileClass' => '',
            'onclick' => '',
            'id' => '',
            'style' => '',
            'name' => null
                )
        );

        $tileClass = $classes['tileClass'];
        $onclick = $classes['onclick'];
        $id = $classes['id'];
        $style = $classes['style'];
        $name = $classes['name'];
        return $this->Html->div("tile $tileClass", $content, array(
                    'id' => $id,
                    'onclick' => $onclick,
                    'style' => $style,
                    'name' => $name
                        )
        );
    }



    /**
     * $parameters = array('tile-size' => null,
     *                     'color-bigarea' => 'bg-orange',
     *                     'icon-bigarea'  => 'icon-layers',
     *                     'image-bigarea' => null, //$this->Html->image(...),
     *                     'destination-smallarea' => array('controller' => $destination['controller'], 'action' => 'add'),
     *     	           'text-overlay' => null,
     * 	                   'text-overlay-color' => 'fg-white',
     * 	                   'badge-color' => 'bg-emerald',
     * 	                   'badge-icon' => 'icon-plus-2',
     *                     'badge-valueAsIcon' => 'xxx',
     * 	                   'destination-bigarea' => $destination,
     * 	                   'title-bigarea' => $title,
     * 	                   'title-smallarea' => null
     * 	);
     *
     *  - if image is set image will displayed else icon is used
     *  - if badge-icon is set icon will displayed else badge-valueAsIcon is used
     */
    function badge($parameters) {

        $result = "";
        $result .= "<div class='tile " . $parameters['tile-size'] . " " . $parameters['color-bigarea'] . "' " .
                (empty($onclick) ? "" : "onclick='$onclick'") .
                (empty($id) ? "" : "id='$id'") .
                (empty($name) ? "" : "name='$name'") . ">";

        if ($parameters['image-bigarea'] != null) {
            $fill = "   <div class='tile-content image'>" .
                    $parameters['image-bigarea'] . "
                       </div>";
        } else {
            $fill = "   <div class='tile-content icon'>
                          <i class='" . $parameters['icon-bigarea'] . "'></i>
                       </div>";
        }

        $fill .= "   <div class='brand'>";

        if ($parameters['text-overlay'] != null) {
            $fill .= "       <span class='label " . $parameters['text-overlay-color'] . "'>" . $parameters['text-overlay'] . "</span>";
        }


        $fillsmall = "";
        if (isset($parameters['destination-smallarea'])) {
            $fillsmall .= "       <span class='badge " . $parameters['badge-color'] . "'>";
            if ($parameters['badge-icon'] != null) {
                $fillsmall .= "    <i class='" . $parameters['badge-icon'] . "'></i>";
            } else {
                $fillsmall .= $parameters['badge-valueAsIcon'];
            }
            $fillsmall .= "       </span>";
            $linkParameters = array('escape' => false, 'title' => $parameters['title-smallarea']);
            if (isset($parameters['parameters-smallarea'])) {
                $linkParameters = array_merge($linkParameters, $parameters['parameters-smallarea']);
            }
            $fillsmall = $this->Html->link($fillsmall, $parameters['destination-smallarea'], $linkParameters);

            if (isset($parameters['form-smallarea'])) {
                $fillsmall .= $parameters['form-smallarea'];
            }
        }

        $fill .= $fillsmall;
        $fill .= "   </div>";

        if ($parameters['destination-bigarea'] == null) {
            $result .= $fill;
        } else {
            $result .= $this->Html->link($fill, $parameters['destination-bigarea'], array('escape' => false, 'title' => $parameters['title-bigarea']));
        }

        $result .= "</div>";
        return $result;
    }

    // *************************************************************************
    // *************************************************************************
    // **************************** refactored *********************************
    // *************************************************************************
    // *************************************************************************

    private function prepareBadgePart($type, $span) {
        $color = 'fg-white';
        if (isset($span['fgcolor'])) {
            $color = $span['fgcolor'];
        }

        if (isset($span['bgcolor'])) {
            $color .= ' ' . $span['bgcolor'];
        }

        return $this->Html->tag('span', $span['content'], array('class' => $type . ' ' . $color));
    }

    private function prepareBadgeContent($content) {
        return $this->Html->div('tile-content', $content);
    }    
    
    
    public function simpleBadge($content, array $label, array $badge, $classes = []) {
        return $this->basic(
                        $this->prepareBadgeContent($content) .
                        $this->Html->div('brand', $this->prepareBadgePart('label', $label) .
                                $this->prepareBadgePart('badge', $badge))
                        , $classes);
    }

    // -------------------------------------------------------------------------

    private function targetLink($target, $link = '', $class = '', $style = '', $tileContent = 'image') {
        if (empty($link)) {
            $link = $target;
        }
        
        $result = $this->Html->div('tile-content '. $tileContent, $link, array('style' => $style));
        return $this->Html->div('tile '. $class, $result);
    }     
    
    private function target($target, $destination = array(), $class = '', $style = '', $tileContent = 'image', $title = '') {
        $link = '';
        if (!empty($destination)) {
            $link = $this->Html->link(
                    $target, $destination, array('escape' => false, 'title' => str_replace('<br>', ' ', $title))
            );
        }
        return $this->targetLink($target, $link, $class, $style, $tileContent);
    }
    
    public function image($icon, $tilesize = '', $destination = array(), $text = '') {
        $image = $this->Html->image($icon, array('title' => $text));
        $image .= $this->Html->div('', $this->tileTextOverlay($text));
        return $this->target($image, $destination, $tilesize);
    }

}
