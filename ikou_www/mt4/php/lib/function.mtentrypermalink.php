<?php
function smarty_function_mtentrypermalink($args, &$ctx) {
    $entry = $ctx->stash('entry');
    $blog = $ctx->stash('blog');
    $at = $args['type'];
    $at or $at = $args['archive_type'];
    $at or $at = $blog['blog_archive_type_preferred'];
    if (!$at) {
        $at = $blog['blog_archive_type'];
        # strip off any extra archive types...
        $at = preg_replace('/,.*/', '', $at);
    }
    $args['blog_id'] = $blog['blog_id'];
    return $ctx->mt->db->entry_link($entry['entry_id'], $at, $args);
} 
?>
