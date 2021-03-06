#!/usr/local/bin/perl5.8 -w

# Copyright 2001-2007 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt-wizard.cgi 1003 2007-01-05 23:46:47Z gboggs $

use strict;

my($MT_DIR);
BEGIN {
    if ($0 =~ m!(.*[/\\])!) {
        $MT_DIR = $1;
    } else {
        $MT_DIR = './';
    }
    unshift @INC, $MT_DIR . 'lib';
    unshift @INC, $MT_DIR . 'extlib';
}

local $| = 1;

eval {
    require  MT::App::Wizard;
    my $app = MT::App::Wizard->new(Directory => $MT_DIR)
        or die MT->errstr;
    $app->{warning_trace} = 0;
    local $SIG{__WARN__} = sub { $app->trace($_[0]) };
    $app->run;
};

if ($@) {
    print "Content-Type: text/html\n\n";
    print "Got an error: $@";
}
