#!/usr/local/bin/perl5.8 -w

# Original copyright 2001-2002 Jay Allen.
# Copyright 2001-2007 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.  For more information, consult your
# Movable Type license.
#
# $Id: mt-search.cgi 1003 2007-01-05 23:46:47Z gboggs $

use strict;
use lib $ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : 'lib';
use MT::Bootstrap App => 'MT::App::Search';
