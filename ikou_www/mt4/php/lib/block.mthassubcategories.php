<?php
function smarty_block_mthassubcategories($args, $content, &$ctx, &$repeat) {
    $localvars = array('conditional','else_content');

    if (!isset($content)) {
        $ctx->localize($localvars);
        $class = 'category';
        if (isset($args['class'])){
            $class = $args['class'];
        }
        $has_sub_cats = _has_sub_categories($ctx, $class);
        $ctx->stash('conditional', $has_sub_cats);
        $ctx->stash('else_content', null);
    } else {
        if (!$ctx->stash('conditional')) {
            $content = $ctx->stash('else_content');
        }
        $ctx->restore($localvars);
    }
    return $content;
}

function _has_sub_categories(&$ctx, $class = 'category') {
    require_once("MTUtil.php");
    $cat = get_category_context($ctx);
    $has_sub_cats = 0;
    if (isset($cat['_children'])) {
        $has_sub_cats = count($cat['_children']) > 0;
    } else {
        $cats =& $ctx->mt->db->fetch_categories(array('blog_id' => $ctx->stash('blog_id'), 'category_id' => $cat['category_id'], 'children' => 1, 'show_empty' => 1, 'class' => $class));
        if (isset($cats)) {
            $cat['_children'] = $cats;
            $has_sub_cats = count($cats) > 0;
        }
    }
    return $has_sub_cats;
}
?>
