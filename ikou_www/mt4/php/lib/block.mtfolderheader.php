<?php
function smarty_block_mtfolderheader($args, $content, &$ctx, &$repeat) {
    if (!isset($content)) {
        $ctx->localize(array('conditional', 'else_content'));
        $ctx->stash('conditional',
            ($ctx->stash('_categories_counter') == 1) ||
            ($ctx->stash('subFolderHead') == 1)
        );
        $ctx->stash('else_content', null);
    } else {
        if (!$ctx->stash('conditional')) {
            $content = $ctx->stash('else_content');
        }
        $ctx->restore(array('conditional', 'else_content'));
    }
    return $content;
/*
    if (!isset($content)) {
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat, $ctx->stash('_categories_counter') == 1);
    } else {
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat);
    }
*/
}
?>