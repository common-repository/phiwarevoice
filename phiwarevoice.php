<?php
/*
Plugin Name: Phiware Voice
Plugin URI: http://voice.phiware.com
Description: Phiware Voice Service integration.
Version: 0.3
Author: Daniele Madama
Author URI: http://www.danysoft.org

    Copyright 2011  Daniele Madama  (d.madama@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Load all of the definitions that are needed for Phiware Voice
phiwarevoice_init();
// Run after the plugins are loaded
add_action('plugins_loaded', 'phiwarevoice_run', 1);

/**
Install the plugin
*/
function phiwarevoice_install() {
}
add_action('phiwarevoice/phiwarevoice.php', 'phiwarevoice_install');


/**
Init
*/
function phiwarevoice_init() {
    define('PHIWAREVOICE_SERVER', 'tts-voice.phiware.com');
    //define('PHIWAREVOICE_SERVER', 'localhost:8888');
    define('PHIWAREVOICE_OPTION_CUSTOMERNAME', 'phiwarevoice_customername');
    define('PHIWAREVOICE_OPTION_SHOWONLYINDETAIL', 'phiwarevoice_showonlyindetail');
    define('PHIWAREVOICE_OPTION_READBLOGTITLE', 'phiwarevoice_readblogtitle');
    define('PHIWAREVOICE_OPTION_BUTTONTYPE', 'phiwarevoice_buttontype');
    define('PHIWAREVOICE_TYPE_FORM', 'phiwarevoice_type_form');
    define('PHIWAREVOICE_TYPE_LINK', 'phiwarevoice_type_link');
    define('PHIWAREVOICE_OPTION_BUTTONSIZE', 'phiwarevoice_buttonsize');
    
    require_once('phiwarevoice-common.php');
    if (is_admin()) {
        require_once('phiwarevoice-admin.php');
    }

}

/**
Run
*/
function phiwarevoice_run() {
    // Add a filter for displaying the button in the content
    add_filter('the_content', 'phiwarevoice_content');
    add_filter('the_content_rss', 'phiwarevoice_content_rss');
    // If admin, initialise the Admin functionality
    if (is_admin()) {
        add_action('admin_menu', 'phiwarevoice_adminMenu');
    }
}

/**
Add the start and stop tags
*/
function phiwarevoice_content($content) {
    if (_phiwarevoice_showButton()) {
        _phiwarevoice_button();
    }
    if (_phiwarevoice_showInfo()) {
        global $post;
        echo "<!-- VOICE_BEGIN -->";
        echo "<div style=\"display: none\">";
        if (phiwarevoice_getReadBlogTitle()) {
            echo get_bloginfo()."<br class=\"VOICE_PAUSE\" />".get_bloginfo("description")."<br class=\"VOICE_PAUSE\" />";
        }
        echo $post->post_title;
        echo "</div>";
    }
    if (_phiwarevoice_showContent()) {
        echo $content;
    }
    if (_phiwarevoice_showInfo()) {
        echo "<!-- VOICE_END -->";
    }
}

/**
Add the start and stop tags
*/
function phiwarevoice_content_rss($content) {
    _phiwarevoice_button();
}

/**
Show the button
*/
function _phiwarevoice_button() {
    echo "<!-- Start Phiware Voice Button -->";
    $phiwarevoice_url = "http://".PHIWAREVOICE_SERVER."/".phiwarevoice_getCustomerName()."vox";
    
    if (phiwarevoice_getButtonType() == PHIWAREVOICE_TYPE_FORM) {
      $button = "<div id=\"vox\"><form action=\"".$phiwarevoice_url."\" method=\"post\" target=\"_vox\">
                    <input type=\"image\" alt=\"listen this page\" src=\"http://voice.phiware.com/resources/buttons/".phiwarevoice_getButtonSize()."\" accesskey=\"L\" />
                    <input type=\"hidden\" name=\"url\" value=\"".urlencode(get_permalink())."\" />";
      $button .= "</form></div>";
    } else {
      $phiwarevoice_url .= "?url=".urlencode(get_permalink());
      $button = "<div id=\"vox\">
                   <a href=\"". $phiwarevoice_url ."\" onClick=\"javascript:window.open('". $phiwarevoice_url ."', 'PhiwareVoice', 'toolbar=no,status=no,width=400,height=300,scrollbars=no,menubar=no'); return false;\" accesskey=\"L\" target=\"_vox\">
                     <img src=\"http://voice.phiware.com/resources/buttons/".phiwarevoice_getButtonSize()."\" alt=\"listen this page\" />
                   </a>
                 </div>";
    }
    echo $button;
    echo "<!-- End Phiware Voice Button -->";
}

/**
Decide if the button must be showed
 */
function _phiwarevoice_showButton() {
    if (is_single() == 1 || is_page() == 1 || !phiwarevoice_getShowOnlyInDetail()) {
        //print_r(debug_backtrace());
        $backtrace = debug_backtrace();
        foreach ($backtrace as $call) {
            if ($call['function'] == 'mystique_shareThis' ||
                $call['function'] == 'get_the_excerpt') {
              return false;
            }
        }
        return true;
    } else {
        return false;
    }
}

/**
Decide if the comment (start/stop) must be showed
 */
function _phiwarevoice_showInfo() {
    if (is_single() == 1 || is_page() == 1) {
        //print_r(debug_backtrace());
        $backtrace = debug_backtrace();
        foreach ($backtrace as $call) {
            if ($call['function'] == 'mystique_shareThis' ||
                $call['function'] == 'get_the_excerpt') {
                return false;
            }
        }
        return true;
    }
}

/**
Decide if the content must be showed
 */
function _phiwarevoice_showContent() {
    //print_r(debug_backtrace());
    $backtrace = debug_backtrace();
    foreach ($backtrace as $call) {
        if ($call['function'] == 'mystique_shareThis') {
          return false;
        }
    }
    return true;
}

?>
