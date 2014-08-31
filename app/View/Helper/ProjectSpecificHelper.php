<?php

App::uses('Helper', 'View');

class ProjectSpecificHelper extends AppHelper {

    public $helpers = array('Html', 'Form');
    public $timeout = 10000;    
    private $width_double = '250px';
    
    public $colors = array('bg-black', 'bg-white', 'bg-lime', 'bg-green', 'bg-emerald',
        'bg-teal', 'bg-cyan', 'bg-cobalt', 'bg-indigo', 'bg-violet',
        'bg-pink', 'bg-magenta', 'bg-crimson', 'bg-red', 'bg-orange',
        'bg-amber', 'bg-yellow', 'bg-brown', 'bg-olive', 'bg-steel',
        'bg-mauve', 'bg-taupe', 'bg-gray', 'bg-dark', 'bg-darker',
        'bg-transparent', 'bg-darkBrown', 'bg-darkCrimson', 'bg-darkMagenta',
        'bg-darkIndigo', 'bg-darkCyan', 'bg-darkCobalt', 'bg-darkTeal',
        'bg-darkEmerald', 'bg-darkGreen', 'bg-darkOrange', 'bg-darkRed',
        'bg-darkPink', 'bg-darkViolet', 'bg-darkBlue', 'bg-lightBlue',
        'bg-lightRed', 'bg-lightGreen', 'bg-lighterBlue', 'bg-lightTeal',
        'bg-lightOlive', 'bg-lightOrange', 'bg-lightPink', 'bg-grayDark',
        'bg-grayDarker', 'bg-grayLight', 'bg-grayLighter', 'bg-blue'
    );

    // ================================================================
    // ============ Definition der Rubrik-Icons =======================

    public $categorySet = array(
        'banks' => array('categoryIcon' => 'icon-stats-up', 'categoryColor' => 'bg-yellow',
            'categoryDestination' => array('controller' => 'Banks', 'action' => 'index'),
            'description' => 'Geldanlagen'
        ),
        'colors' => array('categoryIcon' => ' icon-rainbow', 'categoryColor' => 'bg-cobalt',
            'categoryDestination' => array('controller' => 'Colors', 'action' => 'index'),
            'description' => 'Farben'
        ),
        'costs' => array('categoryIcon' => 'icon-heart-2', 'categoryColor' => 'bg-lime',
            'categoryDestination' => array('controller' => 'Costs', 'action' => 'index'),
            'description' => 'Kosten der Hochzeit'
        ),
        'elektronicparts' => array('categoryIcon' => 'icon-clipboard', 'categoryColor' => 'bg-darkCobalt',
            'categoryDestination' => array('controller' => 'ElectronicParts', 'action' => 'index'),
            'description' => 'Anmelden'
        ),
        'joomlas' => array('categoryIcon' => 'icon-joomla', 'categoryColor' => 'bg-amber',
            'categoryDestination' => array('controller' => 'Joomlas', 'action' => 'index'),
            'description' => 'Joomla Update'
        ),
        'movies' => array('categoryIcon' => 'icon-film', 'categoryColor' => 'bg-green',
            'categoryDestination' => array('controller' => 'Movies', 'action' => 'index'),
            'description' => 'Filme'
        ),
        'pages' => array('categoryIcon' => 'icon-home', 'categoryColor' => 'bg-grayDark',
            'categoryDestination' => array('controller' => 'Pages', 'action' => 'display'),
            'description' => 'Uebersicht'
        ),
        'powers' => array('categoryIcon' => 'icon-power', 'categoryColor' => 'bg-lightRed',
            'categoryDestination' => array('controller' => 'Powers', 'action' => 'index'),
            'description' => 'Strom'
        ),
        'projects' => array('categoryIcon' => 'icon-lab', 'categoryColor' => 'bg-orange',
            'categoryDestination' => array('controller' => 'Projects', 'action' => 'index'),
            'description' => 'Projekte'
        ),
        'users' => array('categoryIcon' => 'icon-user', 'categoryColor' => 'bg-darkPink',
            'categoryDestination' => array('controller' => 'Users', 'action' => 'index'),
            'description' => 'Benutzerverwaltung'
        ),
        'userlogin' => array('categoryIcon' => 'icon-key', 'categoryColor' => 'bg-green',
            'categoryDestination' => array('controller' => 'Users', 'action' => 'login'),
            'description' => 'Anmelden'
        ),
    );

    public function getCategoryItem($category = null, $raw = false) {
        if ($category == null) {
            $hilf = strtolower($this->request->params['controller']);
        } else {
            $hilf = strtolower($category);
        }
        $mySet = $this->categorySet[$hilf];
        if (empty($mySet)) {
            return $this->emptyTile();
        }

        $parameters = array('tileSize' => null,
            'color' => $mySet['categoryColor'],
            'icon' => $mySet['categoryIcon'],
            'destination' => $mySet['categoryDestination'],
            'title' => null,
            'text' => null,
            'id' => 'categoryItem'
        );

        if ($raw == true) {
            return $parameters;
        } else {
            return $this->iconTile($parameters);
        }
    }
    
    
    /* $pictures = array('mainPicture' => array('source' => 'Programme/Abbyy_FineReader_11.jpg', 'alt' => 'Text'),
     *                 'overlayPicture' => 'ok.jpg',
     *                 'statusPictures' => array(array ('source' => 'falsch.jpg', 'alt' => 'Text',
     *                                                  'title' => 'Text', 'link' => array('controller' => 'Status', 'action' => 'index')
     *                                                 ),
     *                                           array ('source' => 'ok.jpg', 'alt' => 'Text',
     *                                                  'title' => 'Text', 'link' => array('controller' => 'Status', 'action' => 'index')
     *                                                 ),
     *                                           array ('source' => 'falsch.jpg', 'alt' => 'Text',
     *                                                  'title' => 'Text')                          
     *                                           )
     *                );
     * $link = array('id' => 'idxxx', 'link' => array('controller' => 'AController', 'action' => 'index'));
     * $text = array('zeile1', 'zeile2', 'zeile3');
     */
    public function statusTile($link, $pictures, $texts) {
        $result = "<div id='".$link['id']."' onclick='' style='border: 1px #000000 solid;' class='tile double bg-white'>";
        
        $inside =      "<div style='margin-left:75px'>
                           <p style='margin:5px; height:2px;font-size: 10px;'>";
            
                           foreach ($texts as $i => $text) {
                               if ($i == 0) {
                                   $inside .= "<b>".$text."</b>";
                               } else {
                                  $inside .= "<br>".$text;
                               }
                           }
        

        $inside .=        "</p>
                        </div>

                        <div style='float:left; width:70px; height:70px;'>
                           <div style='z-index:2;'>".
                              $this->Html->image($pictures['mainPicture']['source'], array('height' => '70', 'width' => '70', 'alt' => $pictures['mainPicture']['alt'])) .
                           "</div>
                           <div style='margin-top:-40px; margin-left:30px; z-index:3;'>" .
                              $this->Html->image($pictures['overlayPicture'], array('height' => '20', 'width' => '20')) .        
                           "</div>
                        </div>
                        <div style='clear:both; float:left; margin:5px;'>";
                              
                           foreach ($pictures['statusPictures'] as $picture) {
                               $tmp = $this->Html->image($picture['source'], array('height' => '20', 'width' => '20', 'alt' => $picture['alt'], 'title' => $picture['title']));
                               if (isset($picture['link'])) {
                                   $inside .= $this->Html->link($tmp, $picture['link'], array('escape' => false));
                               } else {
                                   $inside .= $tmp;
                               }
                           }
                           
        $inside .= "    </div>";
        
        $result .= $this->Html->link($inside, $link['link'], array('escape' => false)) . 
                  "</div>";

        return $result;
    }

    // ================================================================
    // ============== Special-Tiles =====================================

    /*
     * $parameters = array( 'tileSize' => null,
     * 	                     'color' => $color,
     * 	                     'icon' => null,
     *                       'image' => '/image/bild.jpg',
     * 	                     'destination' => $destination,
     * 	                     'title' => $text,
     * 	                     'text' => $text,
     *                       'id' => $id
     * 	                   );
     *
     * - if icon is set, icon will be displayed, image otherway
     */
    public function iconTile($parameters) {
        $result = "<div class='tile " . $parameters['tileSize'] . " " . $parameters['color'] . "' id=" . $parameters['id'] . ">";

        if ($parameters['icon'] != null) {
            $inhalt = "    <div class='tile-content icon'>
                            <i class='" . $parameters['icon'] . "'></i>
                           </div>";
        } else {
            $inhalt = "    <div class='tile-content image'>
                               <img src='" . $parameters['image'] . "'></img>
                           </div>";
        }
        $inhalt .= "   <div class='tile-status'>
                            <span class='name'>" . $parameters['text'] . "</span>
                        </div>";

        if ($parameters['destination'] != null) {
            $result .= $this->Html->link($inhalt, $parameters['destination'], array('escape' => false, 'title' => $parameters['title']));
        } else {
            $result .= $inhalt;
        }
        $result .= "</div>";

        return $result;
    }

    // =================================================================
    // =========== Tiles with Badges ===================================

    function tileBadgeForOtherCategory($category, $title) {
        $help = $this->getCategoryItem($category, true);
        $parameters = array('tile-size' => null,
            'color-bigarea' => $help['color'],
            'icon-bigarea' => $help['icon'],
            'image-bigarea' => null,
            'destination-smallarea' => array('controller' => $category, 'action' => 'add'),
            'text-overlay' => null,
            'text-overlay-color' => 'fg-white',
            'badge-color' => 'bg-emerald',
            'badge-icon' => 'icon-plus-2',
            'badge-valueAsIcon' => 'xxx',
            'destination-bigarea' => array('controller' => $category, 'action' => 'index'),
            'title-bigarea' => $title,
            'title-smallarea' => null
        );
        return $this->tileBadge($parameters);
    }

    /*
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

    function tileBadge($parameters) {
        $result = "";
        $result .= "<div class='tile " . $parameters['tile-size'] . " " . $parameters['color-bigarea'] . "'>";

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

        $fillsmall = "       <span class='badge " . $parameters['badge-color'] . "'>";
        if ($parameters['badge-icon'] != null) {
            $fillsmall .= "    <i class='" . $parameters['badge-icon'] . "'></i>";
        } else {
            $fillsmall .= $parameters['badge-valueAsIcon'];
        }
        $fillsmall .= "       </span>";

        if ($parameters['destination-smallarea'] != null) {
            $fillsmall = $this->Html->link($fillsmall, $parameters['destination-smallarea'], array('escape' => false, 'title' => $parameters['title-smallarea']));
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

    // =================================================================
    // ============= Custom Tiles ======================================

    /*
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
    public function fiveRowDoubleTileWithImage($parameters) {
        $result = "  <div>";
        if ($parameters['image'] != null) {
            $result .= "<div style='width:70px; height:60px; float:left;'>" .
                    $parameters['image'] . "
                                   </div>";
        }

        $result .= "    <div style='clear:right'>
                         
                           <p style='margin:5px; height:60px;'>" . $parameters['row1'] . "<br>
                              " . $parameters['row2'] . "<br>
                              " . $parameters['row3'] . "</p>
                         
                       </div>
                       <div style='margin:5px;'>
                          <p>" . $parameters['row4'] . "<br>";
        if (strcmp(trim($parameters['row5']), ',') != 0) {
            $result .= $parameters['row5'];
        }
        $result .= "</p>
                       </div>
                     </div>";

        $result = "<div class='tile " . $parameters['tile-size'] . " " . $parameters['color'] . "' style='border: 1px #000000 solid;'>" .
                $this->Html->link($result, $parameters['destination'], array('escape' => false, 'title' => $parameters['title'])) .
                "</div>";
        return $result;
    }

    // ================================================================
    // =========== Hilfsfunktionen ====================================

    public function emptyTilesBar($amount) {
        $result = "";
        for ($i = 0; $i < $amount; $i++) {
            $result = $result . $this->emptyTile('');
        }
        return $result;
    }

    public function emptyTile($color = '') {
        $result = "<div class='tile " . $color . "'>";
        $result .= "</div>";
        return $result;
    }

    // ================================================================
    // =========== Standard OP for Toptiles ===========================

    public function submitTile() {
        $parameters = array('tileSize' => null,
            'color' => 'bg-emerald',
            'icon' => 'icon-enter-2',
            'image' => null,
            'destination' => null,
            'title' => __('submit'),
            'text' => null,
            'id' => 'submitTileId'
        );

        return $this->iconTile($parameters);
    }

    public function cancelTile($destination) {
        $parameters = array('tileSize' => null,
            'color' => 'bg-red',
            'icon' => 'icon-cancel-2',
            'image' => null,
            'destination' => $destination,
            'title' => __('cancel'),
            'text' => null,
            'id' => 'cancelTile'
        );

        return $this->iconTile($parameters);
    }

    public function addTile() {
        $parameters = array('tileSize' => null,
            'color' => 'bg-green',
            'icon' => 'icon-plus-2',
            'image' => null,
            'destination' => array('action' => 'add'),
            'title' => __('add'),
            'text' => null,
            'id' => 'addTile'
        );

        return $this->iconTile($parameters);
    }

    public function editTile($id = null) {
        $parameters = array('tileSize' => null,
            'color' => 'bg-green',
            'icon' => 'icon-pencil',
            'image' => null,
            'destination' => array('action' => 'edit', $id),
            'title' => __('edit'),
            'text' => null,
            'id' => 'editTile'
        );

        return $this->iconTile($parameters);
    }

    public function deleteTile($id = null, $destination = null) {
        $color = 'bg-green';
        $icon = 'icon-minus-2';
        $result = "";

        $action = 'delete/' . $id;
        if ($destination != null) {
            $action = $destination['action'] . '/' . $id;
        }

        $result .= "<div class='tile " . $color . "'>";

        $result .= $this->Form->create(null, array('id' => 'post_52b2bc87e06bd718709271',
            'name' => 'post_52b2bc87e06bd718709271',
            'inputDefaults' => array('label' => false, 'div' => false),
            'type' => 'post',
            'action' => $action));

        $result .= $this->Form->end();
        $result .= "  <a href='#' onclick='if (confirm(&quot;M\u00f6chten Sie mit dem L\u00f6schen fortfahren?&quot;)) {document.post_52b2bc87e06bd718709271.submit();} event.returnValue = false; return false;'>";
        $result .= "    <div class='tile-content icon'>";
        $result .= "       <i class='" . $icon . "'></i>";
        $result .= "    </div>";
        $result .= "  </a>";
        $result .= "</div>";

        return $result;
    }

    // =================================================================

    public function assignTile($id = null) {
        return $this->actionTile('icon-pencil', 'edit', __('Assign'), $id);
    }

    public function actionTile($icon, $action, $label, $id = null, $secondId = null) {
        $destination = array('action' => $action . '/' . $id, $secondId);
        return $this->specialTile($icon, $destination, 'bg-emerald', $label);
    }

    public function overview($item, $locations = null) {
        if (isset($item)) {
            $target = '<div>';
            $target .= $this->keyValue($item['name'], null, 5, 5, 25);
            $target .= $this->keyValue($item['description'], null, 35, 5, 18);
            if (!empty($locations)) {
                $target .= $this->keyValue($this->getPathAsString($locations), null, 80, 5, 12);
            }
            $target .='</div>';

            return $this->targetTile($target, null, 'double', 'color:#fff; background-color:#666;');
        }
    }

    public function getPathAsString($locations, $separator = ' / ') {
        $path = '';
        $size = sizeof($locations);
        foreach ($locations as $i => $location) {
            $path .= $location['Location']['name'];
            if ($i < $size - 1) {
                $path .= $separator;
            }
        }
        return $path;
    }

    public function keyValue($key, $value, $top, $left = 5, $font_size = 12) {
        $target = '<h7 class = "state"
				style = "font-weight: bold;
				font-size: ' . $font_size . 'px;
						position: absolute;
						top: ' . $top . 'px;
								left: ' . $left . 'px;
										white-space:nowrap;">';
        if (!empty($key)) {
            $target .= substr($key, 0, 50);
        }
        $target .= '</h7>';
        if ($value != null) {
            $target .= '&nbsp;';
            $target .= '<h7 class = "state" style = "font-size: ' . $font_size . 'px; position: absolute; top: ' . $top . 'px; left: 150px;">';
            $target .= $value;
            $target .= '</h7>';
        }
        return $target;
    }

    public function inputTile($model, $fields = array()) {
        $target = $this->Form->create($model);

        foreach ($fields as $field) {
            if ($field['id'] == 'id') {
                $target .= $this->Form->input($field['id']);
            } else {
                $options = array(
                    'style' => 'vertical-align:middle; width:' . $this->width_double,
                    'div' => NULL
                );
                if (isset($field['params'])) {
                    $options = array_merge($field['params'], $options);
                }

                $input = $this->Form->input($field['id'], $options);

                $target .= '<div class="input-control text nbm" data-role="input-control">';
                $target .= $input;
                $target .= '<button class="btn-clear" tabindex="-1" type="button"></button>';
                $target .= '</div>';

                if (isset($field['br'])) {
                    $target .= '<br><br>';
                }
            }
        }
        $target .= $this->Form->end(__('Submit'));

        return $this->targetTile($target, null, 'double triple-vertical', 'background-color:#fff;');
    }

    public function fillDefaults($options, $defaults) {
        foreach (array_keys($defaults) as $key) {
            if (!isset($options[$key])) {
                $options[$key] = $defaults[$key];
            }
        }
        return $options;
    }

    // ================================================================
    // ============== Image-Tiles =====================================

    public function imageTileTriple($icon, $destination = array(), $text = '') {
        $image = $this->Html->image($icon, array('width' => '380', 'height' => '120', 'alt' => 'Icon'));
        $image .= $this->Html->div('', $this->tileTextOverlay($text));
        return $this->targetTile($image, $destination, 'tile triple');
    }

    public function imageTileDouble($icon, $destination = array(), $text = '') {
        $image = $this->Html->image($icon, array('width' => $this->width_double, 'height' => '120', 'alt' => 'Icon'));
        $image .= $this->Html->div('', $this->tileTextOverlay($text));
        return $this->targetTile($image, $destination, 'tile double');
    }

    public function imageTile($icon, $destination = array(), $text = '', $depth = 0) {
        $image = $this->Html->image($icon, array('width' => '120', 'height' => '120', 'alt' => 'Icon'));
        $image .= $this->Html->div('', $this->tileTextOverlay($text));
        if ($depth == 0) {
            return $this->targetTile($image, $destination);
        } else {
            return $this->targetTile($image, $destination, '', '', 'image', '', $depth);
        }
    }

    // ================================================================

    public function targetTile($target, $destination = array(), $class = '', $style = '', $tileContent = 'image', $title = '', $hierarchydepth = 0) {
        $space = "       ";

        $link = '';
        if (!empty($destination)) {
            $link = $this->Html->link(
                    $target, $destination, array('escape' => false, 'title' => str_replace('<br>', ' ', $title))
            );
        }
        return $this->targetLinkTile($target, $link, $class, $style, $tileContent, $hierarchydepth);
    }

    public function targetTileText($target, $destination = array(), $text = '', $class = '', $style = '', $tileContent = 'image', $hierarchydepth = 0) {
        $target .= $this->Html->div('', $this->tileTextOverlay($text));
        return $this->targetTile($target, $destination, $class, $style, $tileContent, $text, $hierarchydepth);
    }

    public function targetLinkTile($target, $link = '', $class = '', $style = '', $tileContent = 'image', $hierarchydepth = 0) {
        $space = "       ";
        $result = "";

        $result .= $space . "<div class='tile " . $class . "'>\n";
        $result .= $space . "   <div class='tile-content " . $tileContent . "' style='" . $style . "'>\n";

        if (empty($link)) {
            $result .= $space . $target;
        } else {
            $result .= $space . $link;
        }

        $result .= $space . "   </div>\n";
        if ($hierarchydepth > 0) {
            $result .= $space . "       <div class='stripe-hgl$hierarchydepth bg-dark'>\n";
            $result .= $space . "       </div>\n";
        }
        $result .= $space . "</div>\n";

        return $result;
    }

    public function tileTextOverlay($text) {
        $tileElement = "";
        if (!empty($text)) {
            $tileElement .= "<div class='brand bg-grayLight opacity' style='z-index:1'>";
            $tileElement .= "<span class='text' style='word-wrap: break-word;'>";
            $tileElement .= $text;
            $tileElement .= "</span>";
            $tileElement .= "</div>";
        }
        return $tileElement;
    }

    // ===========================================================================

    public function listViewElement($image, $destination, $title, $subtitle, $remark) {
        $space = "       ";
        $result = "";

        $result .= $space . "<div class='list-content'>\n";

        $result .= $space . $image = $this->Html->image($image, array('class' => 'icon'));
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

    // ===========================================================================
    // ====================== ADD/EDIT Masken ====================================	

    public function typeField($ref, $label, $fieldtype, $selection = null, $emptySelectable = false) {

        $klasse = 'input-control text nbm';

        switch ($fieldtype) {
            case 'text' : break;
            case 'password' : $klasse = 'input-control password nbm';
                break;
            case 'selection' : $klasse = 'input-control select nbm';
                break;
        }

        $inp = array('selected' => $selection, 'label' => false, 'div' => array('class' => $klasse, 'data-role' => 'input-control'));
        if ($emptySelectable) {
            $inp = array('selected' => $selection, 'empty' => '', 'label' => false, 'div' => array('class' => $klasse, 'data-role' => 'input-control'));
        }

        $result = "";
        $result .= "<tr>";
        $result .= "  <td class='text-left' style='vertical-align:middle'><strong>" . __($label) . ":</strong></td>";
        $result .= "  <td>";
        $result .= $ref->Form->input($label, $inp);
        $result .= "  </td>";
        $result .= "</tr>";
        return $result;
    }

    private function i18nLocations() {
        __('Add');
        __('Schedule');
        __('Edit_details');
        __('Tour_schedule');

        __('username');
        __('password');
        __('first_name');
        __('last_name');
        __('employee_number');
        __('email');
        __('phone');
        __('cell');
        __('fax');
        __('group_id');
        __('company_id');
        __('hourly_rate');

        __('name');
        __('address');
        __('zip');
        __('city');
        __('country');
        __('phone');
        __('fax');
        __('number_of_employees');
        __('number_of_visitors');
        __('number_of_bathrooms');
        __('note');
    }
    
}