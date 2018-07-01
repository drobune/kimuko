<?php
function smarty_function_mtentryblogdescription($args, &$ctx) {
    $entry = $ctx->stash('entry');
    if ($entry['entry_blog_id']) {
        $blog = $ctx->mt->db->fetch_blog($entry['entry_blog_id']);
        if ($blog) {
            return $blog['blog_description'];
        }
    }
    return '';
}
?>