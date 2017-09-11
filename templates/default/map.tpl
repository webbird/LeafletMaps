    <div style="float:right;width:33%;margin-left:5%;">
        <div id="lm__<?php echo $section_id ?>_mapid" class="lm_map"></div>
        <div class="lm_search" data-id="<?php echo $section_id ?>">
            <input type="text" name="lm_addr" value="" placeholder="<?php echo lm_trans("f.e. '<city>, <street>'") ?>" />
            <button type="button" class="lm_submit" data-id="<?php echo $section_id ?>"><?php echo lm_trans('Search') ?></button>
            <button type="button" class="lm_take" style="display:none;" data-id="<?php echo $section_id ?>"><?php echo lm_trans('Take over') ?></button>
            <div class="lm_results" style="display:none">
                <strong><?php echo lm_trans('Search results') ?>:</strong>
                <span></span>
            </div>
        </div>
    </div>
