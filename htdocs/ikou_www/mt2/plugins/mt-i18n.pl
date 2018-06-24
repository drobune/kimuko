# MT-I18N plugin for MT::I18N container tags and global filters
#
# Release 0.02 (Apr 24, 2005)
#
# This software is provided as-is. You may use it for commercial or 
# personal use. If you distribute it, please keep this notice intact.
#
# Copyright (c) 2004 Hirotaka Ogawa

package MT::Plugin::I18N;
use strict;
use MT::Template::Context;
use MT::I18N;

eval("use Storable;");
if (!$@ && MT->can('add_plugin')) {
    require MT::Plugin;
    my $plugin = new MT::Plugin();
    $plugin->name("MT-I18N Plugin 0.02");
    $plugin->description("Add MT::I18N container tags and global filters.");
    $plugin->doc_link("http://as-is.net/blog/archives/000900.html");
    MT->add_plugin($plugin);
}

MT::Template::Context->add_container_tag('GuessEncoding' => sub {
    my ($ctx, $args) = @_;
    my $builder = $ctx->stash('builder');
    my $tokens = $ctx->stash('tokens');
    defined(my $text = $builder->build($ctx, $tokens))
	or return $ctx->error($builder->errstr);
    return MT::I18N::guess_encoding($text);
});

MT::Template::Context->add_container_tag('EncodeText' => sub {
    my ($ctx, $args) = @_;
    my $builder = $ctx->stash('builder');
    my $tokens = $ctx->stash('tokens');
    defined(my $text = $builder->build($ctx, $tokens))
	or return $ctx->error($builder->errstr);
    my $from = $args->{'from'};
    my $to = $args->{'to'};
    return MT::I18N::encode_text($text, $from || '', $to || '');
});

MT::Template::Context->add_container_tag('SubstrText' => sub {
    my ($ctx, $args) = @_;
    my $builder = $ctx->stash('builder');
    my $tokens = $ctx->stash('tokens');
    defined(my $text = $builder->build($ctx, $tokens))
	or return $ctx->error($builder->errstr);
    my $startpos = $args->{'startpos'};
    my $length = $args->{'length'};
    return MT::I18N::substr_text($text, $startpos || 0, $length || 0);
});

MT::Template::Context->add_container_tag('WrapText' => sub {
    my ($ctx, $args) = @_;
    my $builder = $ctx->stash('builder');
    my $tokens = $ctx->stash('tokens');
    defined(my $text = $builder->build($ctx, $tokens))
	or return $ctx->error($builder->errstr);
    my $cols = $args->{'cols'};
    return MT::I18N::wrap_text($text, $cols || 72);
});

MT::Template::Context->add_container_tag('LengthText' => sub {
    my ($ctx, $args) = @_;
    my $builder = $ctx->stash('builder');
    my $tokens = $ctx->stash('tokens');
    defined(my $text = $builder->build($ctx, $tokens))
	or return $ctx->error($builder->errstr);
    my $cols = $args->{'cols'};
    return MT::I18N::length_text($text);
});

MT::Template::Context->add_container_tag('FirstNText' => sub {
    my ($ctx, $args) = @_;
    my $builder = $ctx->stash('builder');
    my $tokens = $ctx->stash('tokens');
    defined(my $text = $builder->build($ctx, $tokens))
	or return $ctx->error($builder->errstr);
    my $length = $args->{'length'} || 20;
    return (MT::I18N::length_text($text) > $length) ?
	MT::I18N::first_n_text($text, $length) . '...' : $text;
});

MT::Template::Context->add_global_filter('first_n_text' => sub {
    my ($text, $length, $ctx) = @_;
    $length ||= 20;
    return (MT::I18N::length_text($text) > $length) ?
	MT::I18N::first_n_text($text, $length) . '...' : $text;
});
