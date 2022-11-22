<?php
queue_css_file('geolocation-items-map');

$title = __('Bannerstone Provenance Map');
echo head(array('title' => $title, 'bodyclass' => 'map browse'));
?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <h1 class="text-center mb-4"><?php echo $title; ?></h1>
          <p class="mb-4">
            This map shows the location where each bannerstone on this website was found. Click on the markers below to bring up information on the bannerstone discovered at that location. Or, click on the thumbnails along the side panel to see the location for specific bannerstones.
          </p>
    </div>
  </div>

  <div class="row" id="map-viewer">
    <div class="col-md-11">
      <div class="embed-responsive embed-responsive-4by3">
        <?php echo $this->geolocationMapBrowse('map_browse', array('list' => 'map-links', 'params' => $params, 'icon' => 'custom'), array('class' => 'embed-responsive-item')); ?>
      </div>
    </div>
    <div class="col-md-1 py-1 p-md-0 px-xl-2" id="map-links">
    </div>
  </div>
</div>



<?php echo foot(); ?>
