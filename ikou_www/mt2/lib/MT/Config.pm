# Copyright 2001-2007 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.  For more information, consult your
# Movable Type license.
#
# $Id: Config.pm 1003 2007-01-05 23:46:47Z gboggs $

package MT::Config;
use strict;

use MT::Object;
@MT::Config::ISA = qw( MT::Object );
__PACKAGE__->install_properties({
    column_defs => {
        'id' => 'integer not null auto_increment',
        'data' => 'text',
    },
    primary_key => 'id',
    datasource => 'config',
});

1;

__END__

=pod

=head1 NAME

MT::Config - Installation-wide configuration data.

=cut
