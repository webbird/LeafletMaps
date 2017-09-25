<div class="mod_leafletmaps">
    <?php include dirname(__FILE__).'/nav.tpl'; ?>
    <h3><?php echo lm_trans('Marker') ?></h3>
<?php if(isset($info)): ?><div class="info bot"><?php echo $info ?></div><?php endif; ?>
<?php if(isset($warn)): ?><div class="warning bot"><?php echo $warn ?></div><?php endif; ?>
<?php if(isset($markers) && is_array($markers) && count($markers)) : ?>
    <table>
        <thead>
            <tr>
                <th></th>
                <th><?php echo lm_trans('Marker name') ?></th>
                <th><?php echo lm_trans('Icon') ?></th>
                <th><?php echo lm_trans('Glyph') ?></th>
                <th><?php echo lm_trans('Latitude / Longitude') ?></th>
                <th><?php echo lm_trans('Delete') ?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach($markers as $marker): ?>
            <tr>
                <td>
                    <a href="<?php echo $baseUrl, $delim ?>marker=<?php echo $marker['marker_id'] ?>&amp;vis=1">
                        <i class="fa fa-fw fa-eye<?php if($marker['active']==0): ?>-slash<?php endif; ?>"></i>
                    </a>
                    <a href="#" class="lm-marker-id" data-marker-id="<?php echo $marker['marker_id'] ?>" data-marker-active="<?php echo $marker['active'] ?>" data-glyph="<?php echo $marker['glyph'] ?>" data-section="<?php echo $section_id ?>">
                        <i class="fa fa-fw fa-pencil"></i>
                    </a>
                    <span style="display:none">
                        <span class="lm-desc"><?php echo htmlentities($marker['description']) ?></span>
                        <span class="lm-url"><?php echo htmlentities($marker['url']) ?></span>
                    </span>
                </td>
                <td class="marker-name">
                    <?php echo $marker['name'] ?>
                </td>
                <td>
                    <img data-url="<?php echo $marker['icon_id'] ?>" src="<?php echo ( defined('CAT_URL') ? CAT_URL : WB_URL ).'/'.$marker['baseUrl'].'/'.$marker['iconUrl'] ?>" style="height:24px" />
                </td>
                <td class="marker-glyph">
<?php if(isset($marker['glyph']) && strlen($marker['glyph'])): ?>
                    <i class="fa fa-fw fa-<?php echo $marker['glyph'] ?>">
<?php endif; ?>
                </td>
                <td class="marker-latlng">
                    <span class="marker-lat"><?php echo $marker['latitude'] ?></span> / <span class="marker-lng"><?php echo $marker['longitude'] ?></span>
                </td>
                <td>
                    <a href="<?php echo $baseUrl, $delim ?>do=marker&amp;del=<?php echo $marker['marker_id'] ?>" title="<?php echo lm_trans('Delete'); ?>" onclick="return confirm('<?php echo lm_trans("Really delete this marker?") ?>');"><i class="fa fa-fw fa-trash"></i></a>
                </td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="info bot"><?php echo lm_trans('No markers yet') ?></div>
<?php endif; ?>
    <br /><br />

    <h3><?php echo lm_trans('Add / edit marker') ?></h3>
    <?php if(!defined('CAT_VERSION')): ?><div class="info bot"><?php echo lm_trans('Please notice: To show the map in the frontend, the code &lt;?php register_frontend_modfiles_body();?&gt; must be placed before the closing &lt;/body&gt; tag.') ?></div><?php endif; ?>
    
    <div class="grid">
        <div class="unit two-thirds">
            <form name="lm_modify_marker" action="<?php echo $saveUrl ?>" method="post">
                <input type="hidden" name="do" value="marker" />
                <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
                <input type="hidden" name="page_id" value="<?php echo $page_id ?>" />
                <input type="hidden" name="marker_id" value="" >

                <div class="grid">
                    <div class="unit one-third"><label for="marker_name_<?php echo $section_id ?>" accesskey="n"><?php echo lm_trans('Name') ?>:</label></div>
                    <div class="unit two-thirds"><input name="marker_name" id="marker_name_<?php echo $section_id ?>" value="" type="text" /></div>
                </div>

                <div class="grid">
                    <div class="unit one-third"><span class="label"><?php echo lm_trans('Active') ?>:</span></div>
                    <div class="unit two-thirds">
                        <input type="radio" name="marker_active" id="marker_active_y" value="1" checked="checked" /> <label class="lm-label-right" for="marker_active_y"><?php echo lm_trans('Yes') ?></label>
                        <input type="radio" name="marker_active" id="marker_active_n" value="0" /> <label class="lm-label-right" for="marker_active_n"><?php echo lm_trans('No') ?></label>
                    </div>
                </div>

                <div class="grid">
                    <div class="unit one-third"><label for="marker_icon"><?php echo lm_trans('Icon') ?>:</label></div>
                    <div class="unit two-thirds">
                    <select name="marker_icon">
                        <?php foreach($icons as $icon): ?><option value="<?php echo $icon['icon_id'] ?>" data-baseurl="<?php echo $icon['baseUrl'] ?>"><?php echo $icon['iconUrl'] ?></option><?php endforeach; ?>
                    </select>
                    <img src="<?php echo ( defined('CAT_URL') ? CAT_URL : WB_URL ).'/'.$icons[0]['baseUrl'].'/'.$icons[0]['iconUrl'] ?>" style="height:24px; width:auto" />
                    </div>
                </div>

                <div class="grid">
                    <div class="unit one-third"><label for="marker_glyph"><?php echo lm_trans('Glyph') ?>:</label></div>
                    <div class="unit two-thirds">
                        <input type="hidden" name="marker_glyph" />

                        <select class="fa_select" name="marker_select">
                            <option value="">[<?php echo lm_trans('none') ?>]</option>
                            <?php foreach($glyphs['names'] as $i => $item): ?><option value="<?php echo $item ?>"><?php echo $item ?></option><?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid">
                    <div class="unit one-third"><label for="marker_latitude_<?php echo $section_id ?>"><?php echo lm_trans('Latitude') ?>:</label></div>
                    <div class="unit two-thirds"><input name="marker_latitude" id="marker_latitude_<?php echo $section_id ?>" value="" type="text" class="lm_lat" /></div>
                </div>

                <div class="grid">
                    <div class="unit one-third"><label for="marker_longitude_<?php echo $section_id ?>"><?php echo lm_trans('Longitude') ?>:</label></div>
                    <div class="unit two-thirds"><input name="marker_longitude" id="marker_longitude_<?php echo $section_id ?>" value="" type="text" class="lm_lng" /></div>
                </div>

                <div class="grid">
                    <div class="unit one-third"><label for="marker_description_<?php echo $section_id ?>"><?php echo lm_trans('Description') ?>:</label></div>
                    <div class="unit two-thirds"><textarea id="marker_description_<?php echo $section_id ?>" name="marker_description" style=""></textarea></div>
                </div>

                <div class="grid">
                    <div class="unit one-third"><label for="marker_url_<?php echo $section_id ?>" accesskey="n"><?php echo lm_trans('Link-URL') ?>:</label></div>
                    <div class="unit two-thirds"><input name="marker_url" id="marker_url_<?php echo $section_id ?>" value="" type="text" /></div>
                </div>

                <div class="grid">
                    <div class="fg12">
                        <input name="submit" value="<?php echo lm_trans('Submit') ?>" type="submit" />
                        <input name="reset" type="reset" value="<?php echo lm_trans('Reset') ?>" />
                    </div>
                </div>
            </form>
        </div>
        <div class="unit one-third"><?php include dirname(__FILE__).'/map.tpl' ?></div>
    </div>
    <?php include dirname(__FILE__).'/init_map.tpl'; ?>

</div>