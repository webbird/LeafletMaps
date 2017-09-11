<div class="mod_leafletmaps">
    <?php include dirname(__FILE__).'/nav.tpl'; ?>
    <h3><?php echo lm_trans('Settings') ?></h3>
    <div class="info">
        <?php echo lm_trans('Please note: There will be no marker for the LAT/LNG you set here. This is only for the map center. If you need a marker, please add it on the [Markers] tab.') ?><br />
        <?php echo lm_trans('The map is for visualization purposes only. Clicking on the plus/minus, moving the map etc. will not change any settings.') ?><br />
    </div>
    <?php include dirname(__FILE__).'/map.tpl' ?>
    <form name="edit" action="<?php echo $baseUrl ?>" method="post">
        <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
        <input type="hidden" name="page_id" value="<?php echo $page_id ?>" />
        <input type="hidden" name="do" value="set" />
        
        <label for="deflatitude"><?php echo lm_trans('Default latitude') ?>:</label>
            <input type="text" name="deflatitude" id="deflatitude" value="<?php echo $lm_settings['deflatitude'] ?>" class="lm_lat" /><br />
        
        <label for="deflongitude"><?php echo lm_trans('Default longitude') ?>:</label>
            <input type="text" name="deflongitude" id="deflongitude" value="<?php echo $lm_settings['deflongitude'] ?>" class="lm_lng" /><br />
        
        <label for="defzoom"><?php echo lm_trans('Default zoom') ?>:</label>
            <input type="range" name="defzoom" id="defzoom" min="1" max="19" value="<?php echo $lm_settings['defzoom'] ?>" />
            <span class="defzoom_value"><?php echo $lm_settings['defzoom'] ?></span><br />
    
        <label for="width"><?php echo lm_trans('Map width') ?>:</label>
            <input class="small" type="text" name="width" id="width" value="<?php echo $lm_settings['width'] ?>" />
            <i><?php echo lm_trans('If you do not add a length (px, em, ...), px will be used') ?></i><br />

        <label for="height"><?php echo lm_trans('Map height') ?>:</label>
            <input class="small" type="text" name="height" id="height" value="<?php echo $lm_settings['height'] ?>" />
            <i><?php echo lm_trans('If you do not add a length (px, em, ...), px will be used') ?></i><br />
        
        <label for="popuptpl"><?php echo lm_trans('Popup template') ?>:</label>
            <textarea name="popuptpl"><?php echo $lm_settings['popuptpl'] ?></textarea><br /><br />

        <input type="submit" name="submit" value="<?php echo lm_trans('Submit') ?>" />
    </form>
<?php include dirname(__FILE__).'/init_map.tpl'; ?>
</div>