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
        <?php if (strtolower(metadata('item', ['Item Type Metadata', 'NAGPRA'])) == "true"): ?>
        <Placemark>
            <name><?php echo xml_escape(metadata('item', 'display_title', array('no_escape' => true))); ?></name>
            <namewithlink><?php echo xml_escape(link_to_item(metadata('item', array('Dublin Core', 'Title')), array('class' => 'view-item text-dark'))); ?></namewithlink>
            <Snippet maxLines="2">Bannerstone Temporarily Removed Pending Tribal Perspectives</Snippet>
            <collection><?php echo xml_escape(metadata('item', 'Collection Name')); ?></collection>
            <Point>
                <coordinates><?php echo $location['longitude']; ?>,<?php echo $location['latitude']; ?></coordinates>
            </Point>
            <?php if ($location['address']): ?>
            <address><?php echo xml_escape($location['address']); ?></address>
            <?php endif; ?>
        </Placemark>
        <?php else: ?>
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
        <?php endif; ?>
        <?php endforeach; ?>
    </Document>
</kml>

<?php
function bannerstone_thumbnail_url($item, $index = 0)
{
    if (($s3_path = metadata($item, array('Item Type Metadata', 's3_path'), array('index' => $index)))) {
        $path_parts = pathinfo($s3_path);
        $url = str_replace("/objects", "/thumbnails", $path_parts['dirname']) . '/' . substr($path_parts['filename'], 0, 36) . '.jpg';
        return $url;
    }
}
 ?>
