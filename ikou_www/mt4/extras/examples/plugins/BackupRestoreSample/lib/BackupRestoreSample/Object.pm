# Copyright 2001-2007 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.  For more information, consult your
# Movable Type license.
#
# $Id: Object.pm 57940 2007-07-07 09:41:03Z fyoshimatsu $

package BackupRestoreSample::Object;
use strict;

use MT::Blog;
use base qw( MT::Object );
__PACKAGE__->install_properties({
    column_defs => {
        'id' => 'integer not null auto_increment',
        'blog_id' => 'integer not null',
        'role_id' => 'integer not null',
        'description' => 'text',
    },
    indexes => {
        blog_id => 1,
        role_id => 1,
    },
    child_of => 'MT::Blog',
    datasource => 'backup_restore_sample_object',
    primary_key => 'id',
});

sub parents {
    my $obj = shift;
    {
        blog_id => MT->model('blog'),
        role_id => MT->model('role'),
    };
}

1;
