# $Id: Job.pm 59634 2007-07-30 18:38:36Z bchoate $

package MT::TheSchwartz::Job;

use strict;
use base qw( MT::Object );

__PACKAGE__->install_properties({
    column_defs => {
        jobid => 'integer not null auto_increment', # bigint unsigned primary key not null auto_increment
        funcid => 'integer not null', # int unsigned not null
        arg => 'blob', # mediumblob
        uniqkey => 'string(255)', # varchar(255) null
        insert_time => 'integer', # integer unsigned
        run_after => 'integer not null', # integer unsigned not null
        grabbed_until => 'integer not null', # integer unsigned not null
        priority => 'integer', # smallint unsigned
        coalesce => 'string(255)', # varchar(255)
    },
    datasource  => 'ts_job',
    primary_key => 'jobid',
    indexes => {
        funcid => 1,
        coalesce => 1,
        uniqkey => 1,
        run_after => 1,
        uniqfunc => {
            columns => [ 'funcid', 'uniqkey' ],
            unique => 1,
        },
    },
    # not captured (but indexed separately)
    # INDEX (funcid, run_after),
    # INDEX (funcid, coalesce)
});

sub class_label {
    MT->translate("Job");
}

1;
