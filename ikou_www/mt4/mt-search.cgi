#!/usr/local/bin/perl5.8 -w

# Original copyright 2001-2002 Jay Allen.
# Modifications and integration Copyright 2001-2007 Six Apart.
# Copyright 2001-2006 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.  For more information, consult your
# Movable Type license.
#
# $Id: mt-search.cgi 44845 2007-01-10 00:59:17Z bchoate $

use strict;
use lib $ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : 'lib';
use MT::Bootstrap App => 'MT::App::Search';
