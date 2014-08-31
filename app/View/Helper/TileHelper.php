<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
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

    public function sendResponse($status = array(), $tileClasses = array(), $responseFunctionName = 'sendResponse()'){
        $status = $this->fillDefaults($status,
            array(
                'changed' => false,
                'busy' => false
            )
        );
        return  $this->basic(
            $this->icon('enter-2', __('Send response')),
            array( 
                'tileClass' => 'bg-emerald '.implode(" ", $tileClasses), 
                'onclick' => $responseFunctionName)
        );
    }

    public function selectAll($id = 'selectAll', $targetFunction = 'toggleSelectAll()'){
        return  $this->basic(
            $this->icon('checkbox', __('Select All')),
            array( 
                'id' => 'selectAll',
                'tileClass' => 'bg-emerald ', 
                'onclick' => $targetFunction)
        );
    }

    public function input($id, $description, $value){
        $tileClass = 'tile double';
        $tileContent = $this->Html->div('', "<h4>$description</h4>").
                       $this->Html->div('', "<input type=text id='$id', value='$value'></input>");
        return $this->Html->div($tileClass, $this->Html->div('tile-content', $tileContent));
    }

    public function special(
        $icon, 
        $destination = array(), 
        $color = 'bg-darkPink', 
        $text = '', 
        $tileOptions = array(), 
        $txtComponent = '', 
        $linkid = ''
    ) {
        $class = "tile $color ";

        if (isset($tileOptions['class'])) {
            $class .= " " . $tileOptions['class'] . " ";
        }
        if (isset($tileOptions['selected'])) {
            if ($tileOptions['selected']) {
                $class .= " selected ";
            }
            unset($tileOptions['selected']);
        }

        $icon = $this->Html->div('tile-content icon', "<i class='$icon'></i>$txtComponent");
        if (!empty($destination)) {
             $icon = $this->Html->link($icon, $destination, array('escape' => false, 'id' => $linkid, 'title' => str_replace('<br>', ' ', $text)));
        }
        return $this->Html->div($class, $icon, $tileOptions);
    }

    public function specialText($icon, $destination = array(), $color = 'bg-darkPink', $text = '', $tileOptions = array()) {
        $txtComponent = "";
        if (!empty($text)) {
            $txtComponent = $this->tileTextOverlay($text);
        }

        $result = $this->special($icon, $destination, $color, $text, $tileOptions, $txtComponent);

        return $result; 
    }

	public function filter($labelText = '', $options = array()){
		$options = $this->fillDefaults($options,
				array(
						'class' => '',
						'color' => '',
						'suggestionInputId' => 'filterTileSuggestionInputId',
						'searchCallback' => 'contentRequest'
				));

        $suggestionInputId = $options['suggestionInputId'];
        $class = $options['class'];
        $color = $options['color'];
        $buttonId = 'suggestionButtonId';
        $searchCall = $options['searchCallback'];
        $filterTileId = 'filter-tile-id';

        $tileClass = "$class $color tile";
        $searchFunction = "$searchCall($('#$suggestionInputId').val()); console.log('Called');";

        return "
            <div id='$filterTileId' class='$tileClass' onclick=\"$searchFunction\">"
                  ."<div id='filter-icon' class='tile-content icon'>
                        <i class='icon-filter' data-role='input-control'></i>
                    </div>
                    <div id='filter-input' class='input-control text' data-role ='input-control'>
                        <input type=text id='$suggestionInputId' placeholder='$labelText'/>
                    </div>"."
            </div>
            <script>
                $('#$suggestionInputId').keyup(function(event){ if(event.keyCode == 13){ $searchFunction;}});
                function clearButtonPressed(){
                    $('#$suggestionInputId').val(''); 
                    $searchFunction;
                }
            </script>
        ";
    }

    private function routeWithTimeSpanDays($ds, $ts){
        $ds['?']['to'] = time() * 1000;
        $ds['?']['from'] = $ds['?']['to'] - 1000 * /*msec*/ 60 /*sec*/ * 60 /*min*/ * 24 /*hour*/ * $ts /*day*/; 
        return Router::url($ds);
    }

    public function barPlotTime(
        $dataSourceDestination, 
        $label,
        $classes = array()
    ){
        $classes = $this->fillDefaults($classes,
            array(
                'targetElement' => 'plotFixed',
                'radioName' => 'timeScale'
            )
        );
        $targetElement = $classes['targetElement'];
        $radioName = $classes['radioName'];

        $routeMonth = $this->routeWithTimeSpanDays($dataSourceDestination, 30);
        $routeWeek = $this->routeWithTimeSpanDays($dataSourceDestination, 7);
        $routeDay = $this->routeWithTimeSpanDays($dataSourceDestination, 1); 
        return $this->basic(
            "
            <script>
                $(document).ready(function() {
                    $('#$radioName').buttongroup({
                        click: function(btn, on){
                            if($(btn).hasClass('btnday')){
                                ".$this->Plot->update($routeDay)."
                            }
                            else if($(btn).hasClass('btnmonth')){
                                ".$this->Plot->update($routeMonth)."
                            }
                            else if($(btn).hasClass('btnweek')){
                                ".$this->Plot->update($routeWeek)."
                            }
                        }
                    });
                }); 
            </script>
            ".
            "<div id=$radioName class='button-set plot-timescale-switch'>
                <button class='btnday'>".__('Day')."</button>
                <button class='btnweek active'>".__('Week')."</button>
                <button class='btnmonth'>".__('Month')."</button>
            </div>".
            $this->Plot->barTime(
                $dataSourceDestination, 
                $label, array('targetElement' => "$targetElement")
            ),
            array(
                'tileClass' => 'quadro triple-vertical plot bg-white',
                'id' => $targetElement,
                'style' => 'background-color:#fff; border: 1px #000000 solid;'
            )
        );
    }

    public function moveUp($tileClasses = array(), $classes = array()){
        $classes = $this->fillDefaults($classes, array('onclick' => 'shift(this, true)'));
        $onclick = $classes['onclick'];

        $tileClassesImplode = implode(" ", $tileClasses);
        if(in_array('small', $tileClasses)){
            return "
                <button onclick='$onclick' class='button $tileClassesImplode'>".
                   $this->icon('arrow-up', __('Move up'))." 
                </button>
                ";
        }

        return $this->basic(
            $this->icon('arrow-up', __('Move up')), 
            array(
                'tileClass' => 'bg-emerald '.$tileClassesImplode, 
                'onclick' => $onclick)
        );
    }

    public function moveDown($tileClasses = array(), $classes = array()){
        $classes = $this->fillDefaults($classes, array('onclick' => 'shift(this, false)'));
        $onclick = $classes['onclick'];
        
        $tileClassesImplode = implode(" ", $tileClasses);
        if(in_array('small', $tileClasses)){
            return "
                <button onclick='$onclick' class='button $tileClassesImplode'>".
                   $this->icon('arrow-down', __('Move down'))." 
                </button>
                ";
        }
        return $this->basic(
            $this->icon('arrow-down', __('Move down')),
            array(
                'tileClass' => 'bg-emerald '.$tileClassesImplode,
                'onclick' => $onclick)
        );
    }

    public function toggleTrash(){
        return $this->basic(
            $this->icon('remove', __('Exclude')),
            array(
                'tileClass' => 'bg-emerald', 
                'onclick' => 'toggleTrash()'
        	)
        );
    }

    /**
     * Creates a context tile.
     *
     * @param string $tileClass the additional class parts of the tile, e.g. the background
     * @param array $icon the icon
     * @param array $text the tooltip text
     * @return string the context tile
     */
    public function context($tileClass, $icon, $text = ''){
    	return $this->basic(
    			$this->icon($icon, $text),
    			array(
    				'tileClass' => $tileClass
    			)
    	);
    }
    
    /**
     * Creates a tile-content div from an item's icon.
     *
     * @param array $item the item with field 'icon'
     * @return string the item's icon in a tile-content div
     */
    public function icon($class, $text = '') {
    	$content = $this->iconTag($class);
    	return $this->content($content, 'icon',
    			array(
    				'title' => $text
    			)
    	); 
    }
    
    /**
     * Creates an i-tag.
     *
     * @param string $class the additional class parts of the i-tag
     * @return string the i-tag
     */
    public function iconTag($class) {
    	return $this->Html->tag("i", "",
    			array(
    					'class'=> "icon-$class"
    			)
    	);
    }
    
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
    
    /**
     * Creates a HTML image from an item's picture_url.
     *
     * @param array $item the item with field 'picture_url'
     * @return string the item's picture_url in a HTML image
     */
    public function pictureTag($item) {
    	return $this->Html->image($item['picture_url'],
    			array(
    					'alt' => $item['name'],
    					'title' => $item['name']
    			)
    	);
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
    	$span = $this->span($text,
    			array(
    					'class' => 'text',
    					'style'=> 'word-wrap: break-word;'
    			)
    	);
    	return $this->Html->div("brand bg-grayLight opacity", $span,
    			array(
    					'style'=> 'z-index:1'
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
    		$link = $this->Html->link($content, $destination,
    			array_merge($options, 
    					array(
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
     * Creates an empty blank bar.
     *
     * @param int $amount number of blank tiles
     * @return string the blank tiles bar
     */
    public function blankBar($amount) {
    	$result = "";
    	for ($i = 0; $i < $amount; $i++) {
    		$result = $result . $this->blank();
    	}
    	return $result;
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
    public function basic($content, $classes = array()){
        $classes = $this->fillDefaults($classes,
        		array(
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
        return $this->Html->div("tile $tileClass", $content,
        		array(
        				'id' => $id,
        				'onclick' => $onclick,
                        'style' => $style,
                        'name' => $name
        			)
        		);
    }
    
    public function tileTextOverlay($text) {
        if (empty($text)) {
            return "";
        }
        return "
            <div class='brand bg-grayLight opacity' style='z-index:1'>
                <span class='text' style='word-wrap: break-word;'>
                    $text
                </span>
            </div>";
    }
    
    public function image($icon, $destination = array(), $text = '', $depth = 0) {
        $image = $this->Html->image($icon, array('width' => '120', 'height' => '120', 'alt' => 'Icon', 'title' => $text));
        $image .= $this->Html->div('', $this->tileTextOverlay($text));
        if ($depth == 0) {
            return $this->target($image, $destination);
        } else {
            return $this->target($image, $destination, '', '', 'image', '', $depth);
        }
    }
  
    public function imageTriple($icon, $destination = array(), $text = '') {
          $image = $this->Html->image($icon, array('width' => '380', 'height' => '120', 'alt' => 'Icon', 'title' => $text));
          $image .= $this->Html->div('', $this->tileTextOverlay($text));
          return $this->target($image, $destination, 'tile triple');
    }
    
    public function imageDouble($icon, $destination = array(), $text = '') {
          $image = $this->Html->image($icon, array('width' => $this->width_double, 'height' => '120', 'alt' => 'Icon', 'title' => $text));
          $image .= $this->Html->div('', $this->tileTextOverlay($text));
          return $this->target($image, $destination, 'tile double');
    }

    public function target($target, $destination = array(), $class = '', $style = '', $tileContent = 'image', $title = '') {
        $link = '';
        if (!empty($destination)) {
            $link = $this->Html->link(
                    $target, $destination, array('escape' => false, 'title' => str_replace('<br>', ' ', $title))
            );
        }
        return $this->targetLink($target, $link, $class, $style, $tileContent);
    }

    public function targetText($target, $destination = array(), $text = '', $class = '', $style = '', $tileContent = 'image') {
        $target .= $this->Html->div('', $this->tileTextOverlay($text));
        return $this->target($target, $destination, $class, $style, $tileContent, $text);
    }

    public function targetLink($target, $link = '', $class = '', $style = '', $tileContent = 'image') {
        $result = "";

        $result .= "<div class='tile " . $class . "'>
		              <div class='tile-content " . $tileContent . "' style='" . $style . "'>";

        if (empty($link)) {
            $result .= $target;
        } else {
            $result .= $link;
        }

        $result .= " </div>\n";
        $result .= "</div>\n";

        return $result;
    }
    
    /**
     * $parameters = array('tile-size' => null,
     *                     'color-bigarea' => 'bg-orange',
     *                     'icon-bigarea'  => 'icon-layers',
     *                     'image-bigarea' => null, //$this->Html->image(...),
     *                     'destination-smallarea' => array('controller' => $destination['controller'], 'action' => 'add'),
     *     	               'text-overlay' => null,
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
        $result .= "<div class='tile " . $parameters['tile-size'] . " " . $parameters['color-bigarea'] . "' ".
            (empty($onclick)
                ? ""
                : "onclick='$onclick'").
            (empty($id)
                ? ""
                : "id='$id'").
            (empty($name)
                ? ""
                : "name='$name'").">";

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

    /**
     * Make a simple badge tile.
     *
     * @param string content The content of the tile
     * @param string label The tile label
     * @param string badge The badge label
     * @param array classes Defines the tile classes, onlclick, id and name.  
     * @return string The Html for the assembles tile.
     */ 
    public function simpleBadge($content, $label, $badge, $classes=array()){
        return $this->basic("
            $content
            <div class='brand'>
                <span class='label fg-white'>
                    $label
                </span>
                <span class='badge fg-white'>
                    $badge
                </span>
            </div>
            ", 
            $classes);
    }

    /**
     *  $parameters = array('title' => '',
     * 	                    'tile-size' => 'double',
     *                      'destination' => array('controller' => 'users', 'action' => 'edit', $user['User']['id']),
     * 	                    'color' => 'bg-grayLighter',
     * 	                    'image' => $this->Html->image($user['Group']['picture_url'], array('height' => '60', 'width' => '60')),
     * 	                    'row1'  => $user['User']['username'],
     * 	                    'row2'  => $user['User']['first_name'].' '.$user['User']['last_name'],
     * 	                    'row3'  => $user['User']['phone'],
     * 	                    'row4'  => $user['Company']['name'],
     * 	                    'row5'  => $user['Company']['country']. ', ' . $user['Company']['zip'] . ' ' . $user['Company']['city'],
     * 	                   );
     */
    public function fiveRowDoubleTileWithImage(
        $parameters, 
        $contentClass = '',
        $onclickHandler = array(),
        $selected = false,
        $id = null,
        $truncateEarlierAt = 36
    ) {
        $style = 'width:70px; height:60px; float:left;';
        $tileSize = $parameters['tile-size'];
        $color = $parameters['color'];
        $title = $parameters['title'];
        $row1 = $parameters['row1'];
        $row2 = $parameters['row2'];
        $row3 = $parameters['row3'];
        $row4 = $parameters['row4'];
        $row5 = $parameters['row5'];
        $destination = $parameters['destination']; 

        $tileImage = 
                (isset($parameters['image'])
                ? $this->Html->div(
                    '', 
                    $parameters['image'], 
                    array('style' => $style)
                )
                : (isset($parameters['icon'])
                  ? $this->Html->div(
                      '', 
                      $this->Html->div(
                          'tile-content icon', 
                          "<i class='".$parameters['icon']."'></i>", 
                          array('style' => $style)), 
                      array('style' => $style)
                    )
                  : ""
                  )
                );
        $tileContent = "
            <div>
                $tileImage
                <div style='clear:right'>
                    <p style='margin:5px; height:60px;'>".
                        $this->truncate($row1, $truncateEarlierAt) . " <br>".
                        $this->truncate($row2, $truncateEarlierAt) . " <br>".
                        $this->truncate($row3, $truncateEarlierAt) . " <br>".
                        $this->truncate($row4, 36) . " <br>".
                        $this->truncate($row5, 36) .
                    "</p>
                </div>" .
//                <div style='margin:5px;'>
//                    <p> $row4<br> </i>
//                    </p>
//                </div>
            "</div>";
            if(!empty($destination)){
                $tileContent = $this->Html->link(
                    $tileContent, 
                    $parameters['destination'], 
                    array('escape' => false, 'title' => $title));
            }
            return "
                <div 
                    ".($id != null ? "id=$id" : "")."
                    class='tile $tileSize $color $contentClass".($selected?" selected":"")."' 
                    style='border: 1px #000000 solid;'".
                    (!empty($onclickHandler) 
                      ? "onclick=$onclickHandler "
                      : "")."
                     name='$title'>
                    $tileContent
                </div>
            ";
    }

}
