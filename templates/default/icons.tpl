<div class="mod_leafletmaps">
    <?php include dirname(__FILE__).'/nav.tpl'; ?>
    <h3><?php echo lm_trans('Icons') ?></h3>
    <div class="info bot"><?php echo lm_trans('Please note: Icons cannot be managed in this version of the LeafletMaps module.') ?></div>
<?php if(isset($icons) && is_array($icons) && count($icons)) : ?>
    <table>
        <thead>
            <tr>
                <th><?php echo lm_trans('Iconset ID') ?></th>
                <th><?php echo lm_trans('Iconset Name') ?></th>
                <th><?php echo lm_trans('Icon') ?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach($icons as $icon): ?>
            <tr>
                <td>
                    <?php echo $icon['class_id'] ?>
                </td>
                <td>
                    <?php echo $icon['setName'] ?>
                </td>
                <td>
                    <img data-url="<?php echo $icon['icon_id'] ?>" src="<?php echo ( defined('CAT_URL') ? CAT_URL : WB_URL ).'/'.$icon['baseUrl'].'/'.$icon['iconUrl'] ?>" style="height:24px" />
                </td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="info bot"><?php echo lm_trans('No icons yet') ?></div>
<?php endif; ?>
    <br /><br />
