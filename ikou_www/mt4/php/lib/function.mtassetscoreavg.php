<?php
require_once('rating_lib.php');

function smarty_function_mtassetscoreavg($args, &$ctx) {
    return hdlr_score_avg($ctx, 'asset', $args['namespace']);
}
?>

