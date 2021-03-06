# Copyright 2001-2007 Six Apart. This code cannot be redistributed without
# permission from www.sixapart.com.  For more information, consult your
# Movable Type license.
#
# $Id: Folder.pm 59582 2007-07-29 02:23:28Z bchoate $

package MT::Folder;

use strict;
use base qw( MT::Category );

__PACKAGE__->install_properties({
    class_type => 'folder',
    child_of => 'MT::Blog',
    child_classes => ['MT::Placement', 'MT::FileInfo'],
});

sub class_label {
    return MT->translate("Folder");
}

sub class_label_plural {
    MT->translate("Folders");
}

sub basename_prefix {
    "folder";
}

1;
