#!/usr/bin/perl -w

# Copyright 2005-2007 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.
#
# $Id: l10nsample.cgi 1006 2007-01-06 00:29:17Z gboggs $

use strict;
use lib "lib", ($ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : "../../lib"); 
use MT::Bootstrap App => 'l10nsample';
