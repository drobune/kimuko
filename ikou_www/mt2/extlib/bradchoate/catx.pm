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

package bradchoate::catx;

use strict;

sub CategoryNext {
    my ($ctx, $args, $cond) = @_;
    my $e = $ctx->stash('entry');
    my $cat = $e ? $e->category : ($ctx->stash('category') || $ctx->stash('archive_category'));
    return $ctx->error(MT->translate(
        "You used an [_1] tag outside of the proper context.",
        '<MTCategoryNext>' )) if !defined $cat;
    require MT::Placement;
    my $needs_entries = ($ctx->stash('uncompiled') =~ /<\$?MTEntries/) ? 1 : 0;
    my $blog_id = $ctx->stash('blog')->id;
    my $cats = _load_categories($ctx, $cat);
    my ($pos, $idx);
    $idx = 0;
    foreach (@$cats) {
        $pos = $idx, last if $_->id eq $cat->id;
        $idx++;
    }
    if (defined $pos) {
        while ($pos+1 < scalar(@$cats)) {
            $pos++;
            if (!exists $cats->[$pos]->{_placement_count}) {
                if ($needs_entries) {
                    require MT::Entry;
                    my @entries = MT::Entry->load({ blog_id => $blog_id,
                                                    status => MT::Entry::RELEASE() },
                                    { 'join' => [ 'MT::Placement', 'entry_id',
                                                { category_id => $cat->id } ],
                                      'sort' => 'created_on',
                                      direction => 'descend', });
                    $cats->[$pos]->{_entries} = \@entries;
                    $cats->[$pos]->{_placement_count} = scalar @entries;
                } else {
                    $cats->[$pos]->{_placement_count} =
                        MT::Placement->count({ category_id => $cats->[$pos]->id });
                }
            }
            next unless $cats->[$pos]->{_placement_count} || $args->{show_empty};
            local $ctx->{__stash}{category} = $cats->[$pos];
            local $ctx->{__stash}{entries} = $cats->[$pos]->{_entries} if $needs_entries;
            local $ctx->{__stash}{category_count} = $cats->[$pos]->{_placement_count};
            return MT::Template::Context::_hdlr_pass_tokens($ctx, $args, $cond);
        }
    }
    '';
}

sub CategoryPrevious {
    my ($ctx, $args, $cond) = @_;
    my $e = $ctx->stash('entry');
    my $cat = $e ? $e->category : ($ctx->stash('category') || $ctx->stash('archive_category'));
    return $ctx->error(MT->translate(
        "You used an [_1] tag outside of the proper context.",
        '<MTCategoryPrevious>' )) if !defined $cat;
    require MT::Placement;
    my $needs_entries = ($ctx->stash('uncompiled') =~ /<\$?MTEntries/) ? 1 : 0;
    my $blog_id = $ctx->stash('blog')->id;
    my $cats = _load_categories($ctx, $cat);
    my ($pos, $idx);
    $idx = 0;
    foreach (@$cats) {
        $pos = $idx, last if $_->id eq $cat->id;
        $idx++;
    }
    if (defined $pos) {
        while ($pos > 0) {
            $pos--;
            if (!exists $cats->[$pos]->{_placement_count}) {
                if ($needs_entries) {
                    require MT::Entry;
                    my @entries = MT::Entry->load({ blog_id => $blog_id,
                                                    status => MT::Entry::RELEASE() },
                                    { 'join' => [ 'MT::Placement', 'entry_id',
                                                { category_id => $cat->id } ],
                                      'sort' => 'created_on',
                                      direction => 'descend', });
                    $cats->[$pos]->{_entries} = \@entries;
                    $cats->[$pos]->{_placement_count} = scalar @entries;
                } else {
                    $cats->[$pos]->{_placement_count} =
                        MT::Placement->count({ category_id => $cats->[$pos]->id });
                }
            }
            next unless $cats->[$pos]->{_placement_count} || $args->{show_empty};
            local $ctx->{__stash}{category} = $cats->[$pos];
            local $ctx->{__stash}{entries} = $cats->[$pos]->{_entries} if $needs_entries;
            local $ctx->{__stash}{category_count} = $cats->[$pos]->{_placement_count};
            return MT::Template::Context::_hdlr_pass_tokens($ctx, $args, $cond);
        }
    }
    '';
}

sub IfCategory {
    my ($ctx, $args, $cond) = @_;
    my $e = $ctx->stash('entry');
    my $cat = $e ? $e->category : ($ctx->stash('category') || $ctx->stash('archive_category'));
    my $tag = $ctx->stash('tag');
    my $primary = $tag =~ m/^If(Not)?PrimaryCategory$/;
    my $negate = $tag =~ m/Not/;
    my $name = $args->{name};
    my $pattern = $args->{pattern};
    if ((!defined $name) && (!defined $pattern)) {
        return $ctx->error("You failed to specify either the name or pattern attribute for the $tag tag.");
    }
    if (!defined $cat) {
        if ($negate) {
            return MT::Template::Context::_hdlr_pass_tokens($ctx, $args, $cond);
        } else {
            return '';
        }
    }
    my $cats;
    if ($primary || !$e) {
        push @$cats, $cat;
    } else {
        $cats = $e->categories;
    }
    my $ok = 0;
    if (defined $name) {
       foreach my $cat (@$cats) {
           if ($cat->label eq $name) {
               $ok = 1;
               last;
           }
       } 
    } elsif (defined $pattern) {
        require bradchoate::regex;
        my $cpatt = bradchoate::regex::compile_pattern($pattern);
        return $ctx->error("Could not evaluate pattern '$pattern'.") unless defined $cpatt;
        $ok = $cpatt->($cat->label);
    }
    $ok = !$ok if $negate;
    if ($ok) {
        return MT::Template::Context::_hdlr_pass_tokens($ctx, $args, $cond);
    } else {
        return '';
    }
}

sub EntryAdditionalCategories {
    my($ctx, $args, $cond) = @_;
    my $e = $ctx->stash('entry')
        or return $ctx->_no_entry_error('MTEntryAdditionalCategories');
    my $cats = $e->categories;
    return '' unless $cats && @$cats;
    my $builder = $ctx->stash('builder');
    my $tokens = $ctx->stash('tokens');
    my @res;
    for my $cat (@$cats) {
        next if $e->category && ($cat->label eq $e->category->label);
        local $ctx->{__stash}->{category} = $cat;
        defined(my $out = $builder->build($ctx, $tokens, $cond))
            or return $ctx->error( $builder->errstr );
        push @res, $out;
    }
    my $sep = $args->{glue} || '';
    join $sep, @res;
}

sub _load_categories {
    my ($ctx, $cat) = @_;
    my $blog_id = $cat->blog_id;
    my $cats = $ctx->stash('__cat_cache_'.$blog_id);
    if (!$cats) {
        my @cats = MT::Category->load({blog_id => $blog_id},
                                      {'sort' => 'label', direction => 'ascend'});
        $ctx->stash('__cat_cache_'.$blog_id, \@cats);
        $cats = \@cats;
    }
    $cats;
}

1;
