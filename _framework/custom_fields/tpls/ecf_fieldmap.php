<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->api_key ?>" type="text/javascript"></script>
<?php if(!empty($this->value)) : ?>
    <input type="hidden" name="<?php echo $this->name ?>" value="<?php echo $this->value ?>" id="<?php echo $this->name ?>" />
<?php else: ?>
    <input type="hidden" name="<?php echo $this->name ?>" value="" id="<?php echo $this->name ?>" />
<?php endif ?>
<div class="cl">&nbsp;</div>
<div id="map_<?php echo $this->name ?>" style="width: 500px; height: 300px; border: solid 2px #dfdfdf; overflow: hidden;"></div>
<script type="text/javascript" charset="utf-8">
    var map_<?php echo $this->name ?> = new GMap2(document.getElementById("map_<?php echo $this->name ?>"));
    map_<?php echo $this->name ?>.addControl(new GLargeMapControl());
    map_<?php echo $this->name ?>.addControl(new GMapTypeControl());
    <?php if(!empty($this->value)) : ?>
        map_<?php echo $this->name ?>.setCenter(new GLatLng(<?php echo $this->value ?>), <?php echo $this->zoom ?>);
        var marker = new GMarker(new GLatLng(<?php echo $this->value ?>), {'draggable': true});
        marker.enableDragging();
        GEvent.addListener(marker, 'dragend', change_coords);
        map_<?php echo $this->name ?>.addOverlay(marker);        
    <?php else: ?>
        map_<?php echo $this->name ?>.setCenter(new GLatLng(<?php echo $this->lat ?>, <?php echo $this->long ?>), <?php echo $this->zoom ?>);
    <?php endif; ?>    
    
    map_<?php echo $this->name ?>.enableScrollWheelZoom();
    map_<?php echo $this->name ?>.disableDoubleClickZoom();
    function change_coords(point) {
        document.getElementById("<?php echo $this->name ?>").value = point.lat() + "," + point.lng();
    }
    function set_coords(overlay, point) {
        map_<?php echo $this->name ?>.clearOverlays();
        if (point) {
            var marker = new GMarker(point, {'draggable': true});
            marker.enableDragging();
            GEvent.addListener(marker, 'dragend', change_coords);
            map_<?php echo $this->name ?>.addOverlay(marker);
        }
        change_coords(point);
        return false;
    }
    GEvent.addListener(map_<?php echo $this->name ?>, "dblclick", set_coords);
</script>
