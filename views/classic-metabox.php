<p>
    <input type="checkbox" name="enable-expirationdate" id="enable-expirationdate" value="checked"'
    . <?php
    echo $enabled; ?>/>
    <label for="enable-expirationdate"><?php
        _e('Enable Post Expiration', 'post-expirator'); ?></label>
</p>

<?php
if ($default === 'publish') {
    ?>
    <em><?php
        _e('The published date/time will be used as the expiration value', 'post-expirator'); ?></em>
    <?php
    return;
}
?>
<div class="pe-classic-fields" style="display: <?php
echo empty($enabled) ? 'none' : 'flex'; ?>">
    <div>
        <label><?php
            _e('Year', 'post-expirator'); ?></label>
        <select name="expirationdate_year" id="expirationdate_year">
            <?php
            $currentyear = date('Y');

            if ($defaultyear < $currentyear) {
                $currentyear = $defaultyear;
            }

            for ($i = $currentyear; $i <= $currentyear + 10; $i++) {
                // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
                if ($i == $defaultyear) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                ?>
                <option <?php
                echo $selected; ?> value="<?php
                echo $i; ?>"><?php
                    echo $i; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div>
        <label><?php
            _e('Month', 'post-expirator'); ?></label>
        <select name="expirationdate_month" id="expirationdate_month">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                if ($defaultmonth === date_i18n('m', mktime(0, 0, 0, $i, 1, date_i18n('Y')))) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                ?>
                <option value="<?php
                echo date_i18n('m', mktime(0, 0, 0, $i, 1, date_i18n('Y'))); ?>" <?php
                echo $selected; ?>><?php
                    echo date_i18n('F', mktime(0, 0, 0, $i, 1, date_i18n('Y'))); ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div>
        <label><?php
            _e('Day', 'post-expirator'); ?></label>
        <input type="text" id="expirationdate_day" name="expirationdate_day" value="<?php
        echo $defaultday; ?>"
               size="2"/>
    </div>
    <div>
        <label><?php
            _e('Hour', 'post-expirator'); ?>
            (<?php
            echo date_i18n('T', mktime(0, 0, 0, $i, 1, date_i18n('Y'))); ?>)</label>
        <select name="expirationdate_hour" id="expirationdate_hour">
            <?php
            for ($i = 1; $i <= 24; $i++) {
                $hour = date_i18n('H', mktime($i, 0, 0, date_i18n('n'), date_i18n('j'), date_i18n('Y')));
                if ($defaulthour === $hour) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                ?>
                <option value="<?php
                echo $hour; ?>" <?php
                echo $selected; ?>><?php
                    echo $hour; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div>
        <label><?php
            _e('Minute', 'post-expirator'); ?></label>
        <input type="text" id="expirationdate_minute" name="expirationdate_minute" value="<?php
        echo $defaultminute; ?>"
               size="2"/>
    </div>
    <div>
        <label><?php
            _e('How to expire', 'post-expirator'); ?></label>
        <?php
        _postexpirator_expire_type(array(
            'type' => $post->post_type,
            'name' => 'expirationdate_expiretype',
            'selected' => $expireType
        )); ?>
    </div>

    <?php
    if ($post->post_type !== 'page') {
        if (isset($expireType) && ($expireType === 'category' || $expireType === 'category-add' || $expireType === 'category-remove')) {
            $catdisplay = 'block';
        } else {
            $catdisplay = 'none';
        }

        echo '<div id="expired-category-selection" style="display: ' . $catdisplay . '">';
        echo '<br/>' . __('Expiration Categories', 'post-expirator') . ':<br/>';

        echo '<div class="wp-tab-panel" id="post-expirator-cat-list">';
        echo '<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">';
        $walker = new Walker_PostExpirator_Category_Checklist();
        $taxonomies = get_object_taxonomies($post->post_type, 'object');
        $taxonomies = wp_filter_object_list($taxonomies, array('hierarchical' => true));
        if (sizeof($taxonomies) === 0) {
            echo '<p>' . __(
                    'You must assign a heirarchical taxonomy to this post type to use this feature.',
                    'post-expirator'
                ) . '</p>';
        } elseif (sizeof($taxonomies) > 1 && ! isset($defaults['taxonomy'])) {
            echo '<p>' . __(
                    'More than 1 heirachical taxonomy detected.  You must assign a default taxonomy on the settings screen.',
                    'post-expirator'
                ) . '</p>';
        } else {
            $keys = array_keys($taxonomies);
            $taxonomy = isset($defaults['taxonomy']) ? $defaults['taxonomy'] : $keys[0];
            wp_terms_checklist(0, array(
                'taxonomy' => $taxonomy,
                'walker' => $walker,
                'selected_cats' => $categories,
                'checked_ontop' => false
            ));
            echo '<input type="hidden" name="taxonomy-heirarchical" value="' . $taxonomy . '" />';
        }
        echo '</ul>';
        echo '</div>';
        if (isset($taxonomy)) {
            echo '<p class="post-expirator-taxonomy-name">' . __(
                    'Taxonomy Name',
                    'post-expirator'
                ) . ': ' . $taxonomy . '</p>';
        }
        echo '</div>';
    }
    ?>
</div>

<input name="expirationdate_formcheck" value="true" type="hidden"/>
<input name="postexpirator_view" value="classic-metabox" type="hidden"/>
<?php
wp_nonce_field('__postexpirator', '_postexpiratornonce'); ?>
