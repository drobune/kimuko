# $Id: Error.pm 57618 2007-07-03 17:54:41Z bchoate $

package TheSchwartz::Error;
use strict;
use base qw( Data::ObjectDriver::BaseObject );

__PACKAGE__->install_properties({
               columns     => [ qw( jobid funcid message error_time ) ],
               datasource  => 'error',
           });

1;
