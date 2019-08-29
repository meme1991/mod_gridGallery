<?php
/**
 * @version    3.0.x
 * @package    GridGallery
 * @author     SPEDI srl http://www.spedi.it
 * @copyright  Copyright (c) Spedi srl.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

// if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JFactory::getApplication()->enqueueMessage(JText::_('Phoca Gallery is not installed on your system'), 'error');
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_phocagallery'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'loader.php');
}
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.path.route');
phocagalleryimport('phocagallery.library.library');
// phocagalleryimport('phocagallery.text.text');
// phocagalleryimport('phocagallery.access.access');
// phocagalleryimport('phocagallery.file.file');
// phocagalleryimport('phocagallery.file.filethumbnail');
// phocagalleryimport('phocagallery.image.image');
// phocagalleryimport('phocagallery.image.imagefront');
// phocagalleryimport('phocagallery.render.renderfront');
// phocagalleryimport('phocagallery.render.renderdetailwindow');
// phocagalleryimport('phocagallery.ordering.ordering');
// phocagalleryimport('phocagallery.picasa.picasa');
?>
<?php if($list) : ?>
<section class="gallery-module album_grid-layout wrapper gid-<?php echo $gal_id ?>">
	<?php if($module->showtitle) : ?>
		<div class="container">
			<div class="row">
				<div class="title-section">
					<h2 class="mb-0"><?php echo $module->title ?></h2>
					<?php if($description) : ?>
						<p><?= $description ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="container<?php echo $container ?>">
		<div class="row grid-gallery">
			<?php if($shuffle) : ?>
				<?php shuffle($list) ?>
			<?php endif; ?>
			<?php foreach($list as $k => $item) : ?>

				<?php if($k >= $limit) : ?>
					<?php break; ?>
				<?php endif; ?>

				<?php $flink = JRoute::_(PhocaGalleryRoute::getCategoryRoute($item->catid, $item->alias)); ?>

				<?php $hidden = ''; ?>
				<?php if($k > 10) : ?>
					<?php $hidden = 'd-none d-md-block'; ?>
				<?php endif; ?>

				<?php
				if($item->img_cover != 0){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->select($db->quoteName(array('p.title', 'p.filename')));
					$query->from($db->quoteName('#__phocagallery', 'p'));
					$query->where($db->quoteName('id') . ' = '. $item->img_cover);
					$db->setQuery($query);
					$row = $db->loadRow();
					$img = $row[1];
				}else{
					$img = $item->filename;
				}
				?>

				<div class="col-6 col-sm-6 col-md-4 col-lg-<?php echo $col ?> col-xl-<?php echo $col ?> image <?php echo $hidden ?>" style="height: <?php echo $height ?>px">
					<figure style="margin:<?= $margin ?>px">
						<a class="magnific-overlay" title="<?php echo $item->category_title ?>" href="<?php echo $flink ?>">
							<img src="<?php echo JUri::base(true)."/images/phocagallery/".$img; ?>" alt="">
							<figcaption class="d-flex justify-content-center align-items-center" style="background-color:<?= $imgOverlay ?>">
								<p class="mb-0 text-center" style="color:<?= $imgText ?>"><?php echo $item->category_title ?></p>
							</figcaption>
						</a>
					</figure>
				</div>
			<?php endforeach; ?>

			<?php if($linkYN) : ?>
				<div class="col-12 d-flex align-items-center justify-content-center mt-4">
					<p class="mb-0"><a href="<?php echo $link ?>" title="<?php echo $link_text ?>" class="btn btn-primary"><?php echo $link_text ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a></p>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
<?php endif; ?>
