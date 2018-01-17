<?php
/**
 * @version    3.0.x
 * @package    GridGallery
 * @author     SPEDI srl http://www.spedi.it
 * @copyright  Copyright (c) Spedi srl.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JError::raiseError(JText::_('Phoca Gallery Error'), JText::_('Phoca Gallery is not installed on your system'));
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'loader.php');
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
<section class="gallery-module wrapper grid-isotope-layout">
	<?php if($module->showtitle) : ?>
		<div class="container">
			<div class="row">
				<div class="col-12 title-section">
					<h2><?php echo $module->title ?></h2>
					<p>Lorem Ipsum è un testo segnaposto utilizzato nel settore della tipografia e della stampa.</p>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="container<?php echo $container ?>">
		<div class="row">
			<div class="col-12 text-center button-group filter-button-group">
				<?php foreach($list as $k => $item) : ?>
					<?php $filters[] = $item->alias ?>
				<?php endforeach; ?>
				<?php $filters = array_unique($filters) ?>
				<button class="btn btn-outline-primary" data-filter="*">Tutte</button>
				<?php foreach($filters as $filter) : ?>
					<button class="btn btn-outline-primary" data-filter=".<?php echo $filter ?>"><?php echo ucfirst(str_replace('-',' ',$filter)) ?></button>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="row grid-gallery gid-<?php echo $gal_id ?> mt-5">
			<div class="col-6 col-sm-6 col-md-4 col-lg-<?php echo $col ?> col-xl-<?php echo $col ?> image grid-sizer"></div>

			<?php shuffle($list) ?>
			<?php foreach($list as $k => $item) : ?>

				<?php if($k >= $limit) : ?>
					<?php break; ?>
				<?php endif; ?>

				<?php if($magnific) : ?>
					<?php $flink = JUri::base(true)."/images/phocagallery/".$item->filename; ?>
				<?php else: ?>
					<?php $flink = JRoute::_(PhocaGalleryRoute::getCategoryRoute($item->catid, $item->alias)); ?>
				<?php endif; ?>

				<?php $hidden = ''; ?>
				<?php if($k > 10) : ?>
					<?php $hidden = 'hidden-sm-down'; ?>
				<?php endif; ?>

				<div class="col-6 col-sm-6 col-md-4 col-lg-<?php echo $col ?> col-xl-<?php echo $col ?> image <?php echo $hidden ?> grid-item <?php echo $item->alias ?>">
					<figure style="margin:<?php echo $margin ?>px">
						<a class="magnific-overlay" title="<?php echo $item->title ?>" href="<?php echo $flink ?>">
							<img src="<?php echo JUri::base(true)."/images/phocagallery/".$item->filename; ?>" class="img-fluid" alt="">
							<figcaption class="d-flex justify-content-center align-items-center">
								<p class="mb-0 text-center text-white"><?php echo $item->title ?></p>
							</figcaption>
						</a>
					</figure>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if($linkYN) : ?>
			<div class="row">
				<div class="col-12 d-flex align-items-center justify-content-center py-5">
					<p class="mb-0"><a href="<?php echo $link ?>" title="<?php echo $link_text ?>" class="btn btn-primary"><?php echo $link_text ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a></p>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php

$document->addScriptDeclaration("
  jQuery(document).ready(function($){

    $('.grid-gallery.gid-".$gal_id."').magnificPopup({
	    delegate:'a.magnific-overlay',
	    type:'image',
	    gallery:{enabled:true}
	  })

  });
");

$document->addScriptDeclaration("
	jQuery(document).ready(function($){

		var grid = $('.grid-gallery.gid-".$gal_id."').isotope({
		  // set itemSelector so .grid-sizer is not used in layout
		  itemSelector: '.grid-item',
		  percentPosition: true,
		  masonry: {
		    columnWidth: '.grid-sizer'
		  }
		})

		// filter items on button click
		$('.filter-button-group').on( 'click', 'button', function() {
		  var filterValue = $(this).attr('data-filter');
		  grid.isotope({ filter: filterValue });
		});

		// layout Isotope after each image loads
		grid.imagesLoaded().progress( function() {
		  grid.isotope('layout');
		});

	})
");
 ?>
<?php endif; ?>
