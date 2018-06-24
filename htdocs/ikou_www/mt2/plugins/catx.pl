# ---------------------------------------------------------------------------
# Supplemental Category Tags 
# A Plugin for Movable Type
#
# Release 1.5
# June 14, 2003
#
# From Brad Choate
# http://www.bradchoate.com/
# ---------------------------------------------------------------------------
# This software is provided as-is.
# You may use it for commercial or personal use.
# If you distribute it, please keep this notice intact.
#
# Copyright (c) 2002-2003 Brad Choate
# ---------------------------------------------------------------------------

package plugins::catx;

use vars qw($VERSION);
$VERSION = 1.5;

use strict;
use MT::Template::Context;

MT::Template::Context->add_container_tag(CategoryNext => \&CategoryNext);
MT::Template::Context->add_container_tag(CategoryPrevious => \&CategoryPrevious);
MT::Template::Context->add_container_tag(IfCategory => \&IfCategory);
MT::Template::Context->add_container_tag(IfNotCategory => \&IfCategory);
MT::Template::Context->add_container_tag(IfPrimaryCategory => \&IfCategory);
MT::Template::Context->add_container_tag(IfNotPrimaryCategory => \&IfCategory);
MT::Template::Context->add_container_tag(EntryAdditionalCategories => \&EntryAdditionalCategories);

sub CategoryNext {
    require bradchoate::catx;
    &bradchoate::catx::CategoryNext;
}

sub CategoryPrevious {
    require bradchoate::catx;
    &bradchoate::catx::CategoryPrevious;
}

sub IfCategory {
    require bradchoate::catx;
    &bradchoate::catx::IfCategory;
}

sub EntryAdditionalCategories {
    require bradchoate::catx;
    &bradchoate::catx::EntryAdditionalCategories;
}

1;
