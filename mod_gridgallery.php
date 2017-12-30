<?php
/**
 * @version    1.0.x
 * @package    GridGallery
 * @author     SPEDI Labs srl http://www.spedi.it
 * @copyright  Copyright (c) 1991 - 2016 Spedi srl. Tutti i diritti riservati.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

JLoader::register('ModGridGallery', __DIR__ . '/helper.php');

// params
$jquery       = $params->get('jquery-load');
$magnific     = $params->get('magnific');
$masonry      = $params->get('masonry');
$catid        = $params->get('catid', array());
$image        = $params->get('image');
$num_line     = $params->get('num-line');
$container    = $params->get('container');
$height       = $params->get('photo-height');
$limit        = $params->get('limit');
$linkYN       = $params->get('link-yn');
$link         = $params->get('link');
$link_text    = $params->get('link-text');

// gallery id
$gal_id = substr(md5($module->id.$module->title), 1, 5);

$list      = ModGridGallery::category($catid, $image);
$col       = 12/$num_line;
$container = ($container) ? '-fluid' : '';

$document = JFactory::getDocument();
$tmpl     = JFactory::getApplication()->getTemplate();

/* style */
switch ($params->get('layout')) {
  case '_:grid':
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/css/grid-gallery.min.css?v=1.0.0');
    break;
  case '_:grid-masonry':
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/css/grid-gallery-masonry.min.css?v=1.0.0');
    $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/masonry.min.js');
    $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/lazyload.min.js');
    break;
  case '_:isotope':
    $document->addStyleSheet(JUri::base(true).'/modules/'.$module->module.'/css/isotope.min.css?v=1.0.0');
    $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/isotope/isotope.min.js');
    $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/masonry/lazyload.min.js');
    break;

}

/* script */
if($jquery)
  JHtml::_('jquery.framework');
if($magnific){
  $document->addStyleSheet(JUri::base(true).'/templates/'.$tmpl.'/dist/magnific/magnific-popup.min.css');
  $document->addScript(JUri::base(true).'/templates/'.$tmpl.'/dist/magnific/jquery.magnific-popup.min.js');
}

/* layout */
require JModuleHelper::getLayoutPath($module->module, $params->get('layout'));