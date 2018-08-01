#!/usr/bin/perl

require 'referer_chk.pl';

print "Content-type: text/html\n\n";
while (($key, $val) = each %ENV) {
        print "$key = $val<BR>\n";
}

if (&referer_chk() == 0) {
	print "OK<BR>\n";
} else {
	print "NG<BR>\n";
}
