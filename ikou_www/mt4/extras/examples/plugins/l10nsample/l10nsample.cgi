#!/usr/local/bin/perl5.8 -w

# Copyright 2005-2007 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.
#
# $Id: l10nsample.cgi 44845 2007-01-10 00:59:17Z bchoate $

use strict;
use lib "lib", ($ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : "../../lib"); 
use MT::Bootstrap App => 'l10nsample';
