<div class="mod_leafletmaps">
    <?php include dirname(__FILE__).'/nav.tpl'; ?>

    <table>
        <thead>
            <tr>
                <th></th>
                <th><?php echo lm_trans('Icon / Glyph') ?></th>
                <th><?php echo lm_trans('Category name') ?></th>
                <th><?php echo lm_trans('Markers') ?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach($categories as $cat): ?>
            <tr>
                <td>
                    <a href="<?php echo $admin_url ?>/pages/modify.php?page_id=<?php echo $page_id ?>&amp;do=cat&amp;cat=<?php echo $cat['cat_id'] ?>&amp;vis=1">
                        <i class="fa fa-fw fa-eye<?php if($cat['cat_active']==0): ?>-slash<?php endif; ?>"></i>
                    </a>
                    <a href="#" class="lm-cat-id" data-cat-id="<?php echo $cat['cat_id'] ?>" data-cat-active="<?php echo $cat['cat_active'] ?>" data-cat-id="<?php echo $cat['cat_id'] ?>">
                        <i class="fa fa-fw fa-pencil"></i>
                    </a>
                </td>

                <td><?php if(strlen($cat['icon_url'])): ?><img src="<?php echo $cat['icon_url'] ?>" /><?php else: ?><i class="fa fa-fw fa-<?php echo $cat['glyph'] ?>"><?php endif; ?></td>
                <td><?php echo $cat['cat_name'] ?></td>
                <td><?php echo $cat['markers'] ?></td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>

    <h3><?php echo lm_trans('Edit category') ?></h3>
    <form name="modify" action="" method="post">
        <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
        <input type="hidden" name="page_id" value="<?php echo $page_id ?>" />
        <input type="hidden" name="category_id" value="" >

        <label for="cat_name" accesskey="n"><?php echo lm_trans('Name') ?>:</label>
        <input name="cat_name" id="cat_name" value="" type="text" /><br />

        <label for="cat_icon"><?php echo lm_trans('Icon') ?></label>
        <br />

        <label for="cat_glyph" accesskey="n"><?php echo lm_trans('Glyph') ?>:</label>
        <select class="fa_select" name="cat_glyph">
<?php foreach($icons['names'] as $i => $item): ?><option value="<?php echo $item ?>"><?php echo $icons['entities'][$i] ?> <?php echo $item ?></option><?php endforeach; ?>
        </select><br />

        <label for="cat_name" accesskey="n">Icon URL für Ihr individuelles Karten-Icon:</label>
        <input name="icon_url" id="icon_url" value="" type="text" /><br />

        <label for="cat_name" accesskey="n"><?php echo lm_trans('Active') ?>:</label>
        <input value="1" name="active" type="radio"> <?php echo lm_trans('Yes') ?>
        <input value="0" name="active" type="radio"> <?php echo lm_trans('No') ?><br />

        <input name="save" value="<?php echo lm_trans('Submit') ?>" type="submit" />
    </form>
</div>