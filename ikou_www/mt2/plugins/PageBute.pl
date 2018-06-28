use strict;
package MT::Plugin::PageBute;

use vars qw( $MYNAME $VERSION );
$MYNAME = 'PageBute';
$VERSION = '3.4.0';

use MT::Plugin;
use POSIX qw( ceil );

my $plugin = MT::Plugin->new({
	name => $MYNAME,
    author_name => 'SKYARC System Co.,Ltd.',
    author_link => 'http://www.skyarc.co.jp/',
    doc_link => 'http://www.skyarc.co.jp/engineerblog/entry/2642.html',
	description => <<HTMLHEREDOC,
This plugin for Pagenate. Please read documentation if you use this plugin first. <br />It is possible to use it only once a page.
HTMLHEREDOC
	version => $VERSION,
});
MT->add_plugin( $plugin );

my %garbage = (
		PAGENEXT => '<!-- NextLink for PageBute -->',
		PAGEBEFORE => '<!-- BeforeLink for PageBute -->',
		PAGEFIRST => '<!-- FirstLink for PageBute -->',
		PAGELAST => '<!-- LastLink for PageBute -->',
		Separator => '<!-- Separator for PageBute -->',
		PageLists => '<!-- PageLists for PageBute -->',
		Contents => '<!-- Contents for PageBute -->',
		PAGECOUNT => '<!--  PageCount for PageBute-->',
		PAGEMAXCOUNT => '<!--  PageMaxCount for PageBute-->',
		IFPAGENEXT => '<!-- PageIfNext for PageBute -->',
		IFPAGENEXT_END => '<!-- PageIfNext_end for PageBute -->',
		IFPAGEBEFORE => '<!-- PageIfBefore for PageBute -->',
		IFPAGEBEFORE_END => '<!-- PageIfBefore_end for PageBute -->',
		IFPAGEFIRST => '<!-- PageIfFirst for PageBute -->',
		IFPAGEFIRST_END => '<!-- PageIfFirst_end for PageBute -->',
		IFPAGELAST => '<!-- PageIfLast for PageBute -->',
		IFPAGELAST_END => '<!-- PageIfLast_end for PageBute -->',
);

my %delimitor = (
        PAGENEXT   => '&gt;',
        PAGEBEFORE => '&lt;',
        PAGEFIRST  => '&lt;&lt;',
        PAGELAST   => '&gt;&gt;',
);

MT::Template::Context->add_container_tag(PageContents => \&_page_contents);
MT::Template::Context->add_container_tag(IfPageNext => \&_if_page_);
MT::Template::Context->add_container_tag(IfPageBefore => \&_if_page_);
MT::Template::Context->add_container_tag(IfPageFirst => \&_if_page_);
MT::Template::Context->add_container_tag(IfPageLast => \&_if_page_);
MT::Template::Context->add_tag(PageNext => \&_page_);
MT::Template::Context->add_tag(PageBefore => \&_page_);
MT::Template::Context->add_tag(PageFirst => \&_page_);
MT::Template::Context->add_tag(PageLast => \&_page_);
MT::Template::Context->add_tag(PageCount => \&_page_);
MT::Template::Context->add_tag(PageMaxCount => \&_page_);
MT::Template::Context->add_tag(PageSeparator => \&_separator);
MT::Template::Context->add_tag(PageLists => \&_page_lists);
MT->add_callback('BuildPage', 9, $plugin, \&_page_bute);
MT->add_callback('BuildFile', 9, $plugin, \&_repage_bute);

sub _if_page_ {
	my ($ctx, $args, $cond) = @_;

	my $tokens = $ctx->stash('tokens');
	my $builder = $ctx->stash('builder');
	my $result = $builder->build( $ctx, $tokens, $cond )
        or return $ctx->error( $builder->errstr );

    my $tag = uc $ctx->stash('tag');
    $garbage{$tag}. $result. $garbage{$tag. '_END'};
}

sub _page_ {
	my ($ctx,$args,$cond) = @_;

    my $tag = uc $ctx->stash('tag');
	my $delim = $args->{delim} || $delimitor{$tag} || undef;
	my $pb = $ctx->stash('PageBute');
	if(!$pb) {
		my %pagebute = ();
		$pb = \%pagebute;
		$ctx->stash('PageBute',$pb);
	}
	$pb->{$tag. '_delim'} = $delim;
	$garbage{$tag} || '';
}

sub _separator {
	$garbage{Separator} || '';
}

sub _page_lists {
	my ($ctx,$args,$cond) = @_;
	my $pb = $ctx->stash('PageBute');
	if(!$pb) {
		my %pagebute = ();
		$pb = \%pagebute;
		$ctx->stash('PageBute',$pb);
	}
	$pb->{page_delim} = defined $args->{delim} ? $args->{delim} : "&nbsp;\n";
	$pb->{link_start} = $args->{link_start} || q{};
	$pb->{link_close} = $args->{link_close} || q{};
	$pb->{show_always} = defined $args->{show_always} ? $args->{show_always} : 1;

	$garbage{PageLists};
}

sub _page_contents {
	my ($ctx,$args,$cond) = @_;
	my $tokens = $ctx->stash('tokens');
	my $builder = $ctx->stash('builder');
	my $pb = $ctx->stash('PageBute');
	if(!$pb) {
		my %pagebute = ();
		$pb = \%pagebute;
		$ctx->stash('PageBute',$pb);
	}

	return $ctx->error( 'This plugin can be applied only once in a page.') if ($pb->{loaded});
	$pb->{loaded} = 1;
	$pb->{contents} = $builder->build($ctx,$tokens,$cond);
	$pb->{count} = $args->{count} || 10;
	$pb->{navi_count} = $args->{navi_count} || '11';
	$pb->{nav_separator} = $args->{nav_separator} || '_';

	$garbage{Contents};
}

sub _page_bute {
	my ($cb, %opt) = @_;

	my $ctx = $opt{Context};
	my $pb = $ctx->stash('PageBute');
	return 1 unless($pb);

	#Get file information
	my ($filename, $file_ext);
	my $file = $opt{File};
	my $blog = $ctx->stash('blog');
	my $site_url = $blog->{column_values}->{site_url};
	$site_url = $site_url . '/' unless ($site_url =~ /[\/\\]$/);
	my $site_path = $blog->{column_values}->{site_path};
	$site_path = $site_path . '/' unless ($site_path =~ /[\/\\]$/);
	my $file_path = substr($file, length($site_path));

	if ( $file_path =~ /^[\/\\]?(.*)\.(.*?)$/ ) {
		$filename = $1;
		$file_ext = $2;
	} else {
		$filename = $file_path;
		$file_ext = '';
	}


	my $contents = $opt{Content};
	my $split_count = $pb->{count};
	my $delim = $pb->{page_delim};
	my @entries = split(/$garbage{Separator}/, $pb->{contents});
	my $page_limit = ceil( $#entries / $split_count );
	
	my $page_count = 1;
	my $output_page_contents = '';

	my $fmgr = $blog->file_mgr;

	for (my $i=0; $i < $#entries; $i++) {
		$output_page_contents .= $entries[$i];
		if( ($i + 1) % $split_count == 0 || $i == $#entries - 1) {

			$file = $page_count == 1 ? $file : "${site_path}${filename}_${page_count}.${file_ext}";
			my $output = $$contents;
			$output =~ s/$garbage{Contents}/$output_page_contents/g;

			my $lists = &_create_lists($page_count, $page_limit , $pb->{navi_count} );
			my $first = $lists->{first}
			        ? &_create_link(1, $site_url . $filename, $file_ext, $pb->{PAGEFIRST_delim}, 'link_first')
			        : '';
			my $before = $lists->{before}
			        ? &_create_link($page_count - 1, $site_url . $filename, $file_ext, $pb->{PAGEBEFORE_delim}, 'link_before')
			        : '';
			my $next = $lists->{next}
			        ? &_create_link($page_count + 1, $site_url . $filename, $file_ext, $pb->{PAGENEXT_delim}, 'link_next')
			        : '';
			my $last = $lists->{last}
			        ? &_create_link($lists->{last}, $site_url . $filename, $file_ext, $pb->{PAGELAST_delim}, 'link_last')
			        : '';

			my $page_lists = '';
			for (my $i = $lists->{min_page}; $i <= $lists->{max_page}; $i++) {
				$page_lists .= $i == $lists->{min_page} ? '' : $delim;
				$page_lists .= $pb->{link_start};
				$page_lists .= $i == $page_count
				        ? "<span class=\"current_page\">$page_count</span>"
				        : &_create_link($i, $site_url . $filename, $file_ext, $i, 'link_page');
				$page_lists .= $pb->{link_close};
			}

			#replace first link
			if ($first) {
				$first = $pb->{link_start}. $first. $pb->{link_close};
				$output =~ s/\Q$garbage{IFPAGEFIRST}\E//g;
				$output =~ s/\Q$garbage{IFPAGEFIRST_END}\E//g;
				$output =~ s/\Q$garbage{PAGEFIRST}\E/$first/g;
			} else {
				$output =~ s/\Q$garbage{IFPAGEFIRST}\E[\s\S]*?\Q$garbage{IFPAGEFIRST_END}\E//g;
			}
			#replace before link
			if ($before) {
				$before = $pb->{link_start}. $before. $pb->{link_close};
				$output =~ s/\Q$garbage{IFPAGEBEFORE}\E//g;
				$output =~ s/\Q$garbage{IFPAGEBEFORE_END}\E//g;
				$output =~ s/\Q$garbage{PAGEBEFORE}\E/$before/g;
			} else {
				$output =~ s/\Q$garbage{IFPAGEBEFORE}\E[\s\S]*?\Q$garbage{IFPAGEBEFORE_END}\E//g;
			}
			#replace next link
			if ($next) {
				$next = $pb->{link_start}. $next. $pb->{link_close};
				$output =~ s/\Q$garbage{IFPAGENEXT}\E//g;
				$output =~ s/\Q$garbage{IFPAGENEXT_END}\E//g;
				$output =~ s/\Q$garbage{PAGENEXT}\E/$next/g;
			} else {
				$output =~ s/\Q$garbage{IFPAGENEXT}\E[\s\S]*?\Q$garbage{IFPAGENEXT_END}\E//g;
			}
			#replace last link
			if ($last) {
				$last = $pb->{link_start}. $last. $pb->{link_close};
				$output =~ s/\Q$garbage{IFPAGELAST}\E//g;
				$output =~ s/\Q$garbage{IFPAGELAST_END}\E//g;
				$output =~ s/\Q$garbage{PAGELAST}\E/$last/g;
			} else {
				$output =~ s/\Q$garbage{IFPAGELAST}\E[\s\S]*?\Q$garbage{IFPAGELAST_END}\E//g;
			}

            # Page Count
            $output =~ s/\Q$garbage{PAGECOUNT}\E/$page_count/g;
            $output =~ s/\Q$garbage{PAGEMAXCOUNT}\E/$lists->{max_page}/g;

			#replace page lists
			if (!$next && !$before && $pb->{show_always} == 0) {
			    $output =~ s/\Q$garbage{PageLists}\E//g;
			}
			else {
			    $output =~ s/\Q$garbage{PageLists}\E/$page_lists/g;
			}

			$fmgr->put_data($output,"${file}.new");
			$fmgr->rename("${file}.new",$file);

			if($page_count == 1) {
				$ctx->stash('FirstContents', $output);
				$ctx->stash('FirstFileName', $file);
			}

			$output_page_contents = '';
			$page_count++;
		}
	}
	$ctx->stash('PageBute', 0);
	1;
}

sub _repage_bute {
	my ($cb, %opt) = @_;

	my $ctx = $opt{Context};
	my $file = $ctx->stash('FirstFileName');
	my $contents = $ctx->stash('FirstContents');

	return 1 unless($file);

	my $blog = $ctx->stash('blog');
	my $fmgr = $blog->file_mgr;
	$fmgr->put_data($contents,"${file}.new");
	$fmgr->rename("${file}.new",$file);

	$ctx->stash('FirstFileName',0);
}

sub _create_lists {
	my ($page, $max , $navi_count ) = @_;

    my ($min_page , $max_page , $navi_side_count) = (0,0,0);
    $navi_count = $navi_count || '11';
    if ( $navi_count =~ /^\d+$/ ){
      if($navi_count == 1 || $max == 1){
        $min_page = $page;
        $max_page = $page;
      }else{
        $navi_count = $max if $navi_count > $max;
        $navi_side_count  = $navi_count > 1 ? int ($navi_count/2) : 0;
        $min_page = $page - ($navi_side_count);
        $min_page = 1 if $min_page < 1;
        $max_page = $min_page + ($navi_count - 1);
        $max_page = $max if $max_page > $max;
        $min_page = $max_page - ($navi_count - 1) if ($max_page - $min_page) < ($navi_count - 1);
      }
    }else{
       $max_page = $max;
       $min_page = 1;
    }

	my %pages = (
		first    => $page - 1 > 0 ? 1 : 0,
		before   => $page - 1 > 0 ? $page - 1 : 0,
		next     => $page + 1 <= $max ? $page + 1 : 0,
		last     => $page + 1 <= $max ? $max : 0,
		max_page => $max_page,
		min_page => $min_page
	);
	return \%pages;
}

sub _create_link {
	my ($page, $file, $extension, $name, $class_name) = @_;
	my $url = $file . ( $page == 1 ? '' : "_${page}" ) . ".${extension}";
	$url =~ s|\\|\/|g; # for windows
	return "<a href=\"$url\" class=\"$class_name\">$name</a>";
}

1;