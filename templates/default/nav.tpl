<ul class="lm_nav">
    <li><a href="<?php echo $baseUrl ?>"<?php if(isset($do) && $do=='marker'): ?> class="current"<?php endif; ?>><?php echo lm_trans('Marker') ?></a></li>
    <li><a href="<?php echo $baseUrl, $delim ?>do=icon"<?php if(isset($do) && $do=='icon'): ?> class="current"<?php endif; ?>><?php echo lm_trans('Icons') ?></a></li>
    <li><a href="<?php echo $baseUrl, $delim ?>do=set"<?php if(isset($do) && $do=='set'): ?> class="current"<?php endif; ?>><?php echo lm_trans('Settings') ?></a></li>
</ul><br />
