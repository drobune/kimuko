package MT::Plugin::CutString;
use strict;

use MT;
use MT::Template::Context;
use MT::Plugin;
use MT::I18N;

my $plugin = MT::Plugin->new;
$plugin->name("Cut String");
$plugin->description('');
MT->add_plugin($plugin);

MT::Template::Context->add_global_filter(cutbefore => \&cutbefore);
MT::Template::Context->add_global_filter(cutnext => \&cutnext);
MT::Template::Context->add_global_filter(cutstr => \&cutstring);
MT::Template::Context->add_global_filter(cuttag => \&cuttag);
MT::Template::Context->add_global_filter(getstr => \&getstring);

sub cutbefore {
  my ($text, $arg, $ctx) = @_;

  $text = $1 if($text =~ m/$arg(.*)/);
  return $text;
}

sub cutnext {
  my ($text, $arg, $ctx) = @_;

  $text = $1 if($text =~ m/(.*?)$arg/);
  return $text;
}

sub cuttag {
	my ($text, $arg, $ctx) = @_;
		
	my @tags = split(',',$arg);
	foreach (@tags) {
		$text =~ s/<\/?$_.*?>//igs;
	}
	return $text;
}

sub cutstring {
  my ($text, $arg, $ctx) = @_;

	my $max_length = $arg*2;
	$text =~ s/\r|\n|\t//g;
	my @str = split(/<[^<>]+?>/,$text);
	my @tags = $text =~ m/<([^<>]+?)>/g;
	
	my $length = 0;
	my $str = '<p>';
	my $str_length;
	my $temp;
	
  for (my $i=0; $i<scalar(@tags); $i++ ) {
		if($str[$i] ne '') {
			$str_length = MT::I18N::length_text($str[$i]) * 2;
			if ($length > $max_length) {
				$str .= "<" . $tags[$i] . ">";
			} elsif ($max_length - $length - $str_length > 0) {
				$str .= $str[$i] . "<" . $tags[$i] . ">";
				$length += $str_length;
			} else {
				$temp = MT::I18N::substr_text($str[$i],0,int(($max_length - $length)/2)) . '...';
				$str .= $temp;
				$str .= "<" . $tags[$i] . ">";
				$length += MT::I18N::length_text($temp) + 50;
			}
		}
	}
	return $str;
}

sub getstring {
  my ($text, $arg, $ctx) = @_;
  return substr($text, 0, $arg);
}
