<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<kml xmlns="http://earth.google.com/kml/2.0">
    <Document>
        <name>Omeka Items KML</name>
        <?php /* Here is the styling for the balloon that appears on the map */ ?>
        <Style id="item-info-balloon">
            <BalloonStyle>
                <text><![CDATA[
                    <div class="geolocation_balloon">
                        <div class="geolocation_balloon_thumbnail">$[description]</div>
                        <div class="geolocation_balloon_body">
                          <div class="geolocation_balloon_title">$[namewithlink]</div>
                          <p class="geolocation_balloon_description">$[Snippet]</p>
                        </div>
                    </div>
                ]]></text>
            </BalloonStyle>
        </Style>
        <?php
        foreach (loop('item') as $item):
        $location = $locations[$item->id];
        $image = '<img class="card-img" src="' . bannerstone_thumbnail_url($item, 1) . '" alt="Bannerstone ' . metadata($item, array('Dublin Core', 'Title')) . '">';
        ?>
        <Placemark>
            <name><?php echo xml_escape(metadata('item', 'display_title', array('no_escape' => true))); ?></name>
            <namewithlink><?php echo xml_escape(link_to_item(metadata('item', array('Dublin Core', 'Title')), array('class' => 'view-item text-dark'))); ?></namewithlink>
            <Snippet maxLines="2"><?php echo xml_escape(metadata('item', array('Item Type Metadata', 'Provenance/Provenience'), array('snippet' => 150))); ?></Snippet>
            <description><?php
              echo xml_escape(link_to_item($image, array('class' => 'view-item')));
            ?></description>
            <collection><?php echo xml_escape(metadata('item', 'Collection Name')); ?></collection>
            <Point>
                <coordinates><?php echo $location['longitude']; ?>,<?php echo $location['latitude']; ?></coordinates>
            </Point>
            <?php if ($location['address']): ?>
            <address><?php echo xml_escape($location['address']); ?></address>
            <?php endif; ?>
        </Placemark>
        <?php endforeach; ?>
    </Document>
</kml>

<?php
function bannerstone_thumbnail_url($item, $index = 0)
            {
                if (($fitdil_data_json = metadata($item, array('Item Type Metadata', 'fitdil_data'), array('index' => $index))) && ($github_collection = metadata($item, array('Item Type Metadata', 'github_collection')))) {
                    $fitdil_data = json_decode(html_entity_decode($fitdil_data_json), true);
                    $record_name = $fitdil_data["record-name"];
                    // Fix for weirdness where iiif images for this American Museum of Natural History collection added suffix of -1
                    if ((metadata($item, 'Collection Name')) == 'American Museum of Natural History') {
                        $url = 'https://fit-bannerstones.github.io/' . $github_collection . '/images/' . $record_name . '-1/full/250,/0/default.jpg';
                    } else {
                        $url = 'https://fit-bannerstones.github.io/' . $github_collection . '/images/' . $record_name . '/full/250,/0/default.jpg';
                    }
                    return $url;
                }
            }
 ?>
