<?php
/*
Plugin Name: Colored Tags
Version: auto
Description: Allow to manage color of tags, as you want...
Plugin URI: auto
Author: Mistic
Author URI: http://www.strangeplanet.fr
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

if (basename(dirname(__FILE__)) != 'typetags')
{
  add_event_handler('init', 'typetags_error');
  function typetags_error()
  {
    global $page;
    $page['errors'][] = 'Colored Tags folder name is incorrect, uninstall the plugin and rename it to "typetags"';
  }
  return;
}

global $prefixeTable, $conf;

define('TYPETAGS_PATH' ,  PHPWG_PLUGINS_PATH . 'typetags/');
define('TYPETAGS_TABLE' , $prefixeTable . 'typetags');
define('TYPETAGS_ADMIN',  get_root_url().'admin.php?page=plugin-typetags');

include_once(TYPETAGS_PATH . 'include/events_public.inc.php');


$conf['TypeTags'] = safe_unserialize($conf['TypeTags']);


// tags on picture page
/*if (script_basename() == 'picture')
{
  add_event_handler('loc_end_picture', 'typetags_picture');
}*/

// tags everywhere
if ($conf['TypeTags']['show_all'] and script_basename() != 'tags')
{
  add_event_handler('render_tag_name', 'typetags_render', 0, 2);
}

// tags on tags page
add_event_handler('loc_end_tags', 'typetags_tags');

// escape keywords meta
add_event_handler('loc_begin_page_header', 'typetags_escape');


if (defined('IN_ADMIN'))
{
  add_event_handler('get_admin_plugin_menu_links', 'typetags_admin_menu');

  add_event_handler('loc_begin_admin_page', 'typetags_admin');

  include_once(TYPETAGS_PATH . 'include/events_admin.inc.php');
}
