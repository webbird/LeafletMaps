<div class="mod_leafletmaps">
    <?php include dirname(__FILE__).'/nav.tpl'; ?>
    <h3><?php echo lm_trans('Settings') ?></h3>
    <div class="info bot">
        <?php echo lm_trans('Please note: There will be no marker for the LAT/LNG you set here. This is only for the map center. If you need a marker, please add it on the [Markers] tab.') ?><br />
        <?php echo lm_trans('The map is for visualization purposes only. Clicking on the plus/minus, moving the map etc. will not change any settings.') ?><br />
    </div>    
<div class="grid">
<div class="unit two-thirds">
	
    <form name="edit" action="<?php echo $baseUrl ?>" method="post">
        <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
        <input type="hidden" name="page_id" value="<?php echo $page_id ?>" />
        <input type="hidden" name="do" value="set" />
		
		<div class="grid">
			<div class="unit one-third"><label for="deflatitude"><?php echo lm_trans('Default latitude') ?>:</label></div>
			<div class="unit two-thirds"><input type="text" name="deflatitude" id="deflatitude" value="<?php echo $lm_settings['deflatitude'] ?>" class="lm_lat" /><br /></div>
		</div>
		
		<div class="grid">
			<div class="unit one-third"><label for="deflongitude"><?php echo lm_trans('Default longitude') ?>:</label></div>
			<div class="unit two-thirds"><input type="text" name="deflongitude" id="deflongitude" value="<?php echo $lm_settings['deflongitude'] ?>" class="lm_lng" /></div>
		</div>
		
		<div class="grid">
			<div class="unit one-third"><label for="defzoom"><?php echo lm_trans('Default zoom') ?>:</label></div>
			<div class="unit two-thirds">
				<input type="range" name="defzoom" id="defzoom" min="1" max="19" value="<?php echo $lm_settings['defzoom'] ?>" />
				 <span class="defzoom_value"><?php echo $lm_settings['defzoom'] ?></span>
			</div>
		</div>
		
		<div class="grid">
			<div class="unit one-third"><label for="width"><?php echo lm_trans('Map width') ?>:</label></div>
			<div class="unit two-thirds"><input  type="text" name="width" id="width" value="<?php echo $lm_settings['width'] ?>" /> <br />
            <i><?php echo lm_trans('If you do not add a length (px, em, ...), px will be used') ?></i></div>
		</div>
		
		<div class="grid">
			<div class="unit one-third"><label for="height"><?php echo lm_trans('Map height') ?>:</label></div>
			<div class="unit two-thirds"><input  type="text" name="height" id="height" value="<?php echo $lm_settings['height'] ?>" /><br />
            <i><?php echo lm_trans('If you do not add a length (px, em, ...), px will be used') ?></i></div>
		</div>
		
		<div class="grid">
			<div class="unit one-third"><label for="popuptpl"><?php echo lm_trans('Popup template') ?>:</label></div>
			<div class="unit two-thirds"><textarea name="popuptpl"><?php echo $lm_settings['popuptpl'] ?></textarea></div>
		</div>
		
		<div class="grid">			
			<div class="fg12"><input type="submit" name="submit" value="<?php echo lm_trans('Submit') ?>" /></div>
		</div>
        
 
        
    </form>
	</div>
	<div class="unit one-third">
	<?php include dirname(__FILE__).'/map.tpl' ?>
	</div>
<?php include dirname(__FILE__).'/init_map.tpl'; ?>
</div>