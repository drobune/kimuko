# $Id: ExitStatus.pm 59634 2007-07-30 18:38:36Z bchoate $

package MT::TheSchwartz::ExitStatus;

use strict;
use base qw( MT::Object );

__PACKAGE__->install_properties({
    column_defs => {
        jobid => 'integer not null primary key', # bigint unsigned primary key not null
        funcid => 'integer not null', # int unsigned not null default 0
        status => 'integer', # smallint unsigned
        completion_time => 'integer', # integer unsigned
        delete_after => 'integer', # integer unsigned
    },
    datasource => 'ts_exitstatus',
    primary_key => 'jobid',
    indexes => {
        delete_after => 1,
        funcid => 1,
    },
});

sub class_label {
    MT->translate("Job Exit Status");
}

1;
