#!/usr/bin/perl -w

# Copyright 2005-2007 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.
#
# $Id: rate.cgi 53876 2007-05-21 12:42:53Z fyoshimatsu $

use strict;
use lib "lib", ($ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : "../../lib"); 
use MT::Bootstrap App => 'FiveStarRating';