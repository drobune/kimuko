#!/usr/local/bin/perl5.8 -w

use strict;
use lib "lib", ($ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : "../../lib");
use MT::Bootstrap App => 'Mirror';
