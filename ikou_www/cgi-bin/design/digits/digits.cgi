#!/usr/bin/perl

require 'cgi-lib.pl';
&ReadParse(*in);

# Security blankets.

$ENV{'IFS'} = '' if $ENV{'IFS'};
$ENV{'PATH'} = '/vs/bin:/bin:/usr/bin:/usr/local/bin';
umask(022);

# set HOME environment
$login = (getpwuid($<))[0] || "Intruder!!";
$home = "/virtual";


chdir $home || die "Can't find $home.\n";

$fname=$in{'fname'};
$bgcolor=$in{'bgcolor'};

if (!$bgcolor) { $bgcolor = "#FFFFFF";}

print "Content-type: text/html\n\n";
print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Frameset//EN\">\n";
print "<!--鮨-->\n";
print "<HTML><HEAD>\n";
print "<LINK REV=MADE HREF=\"mailto:postmaster\@vf.ksi.ne.jp\">\n";
print "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html;charset=EUC-JP\">\n";
print "<TITLE>Sample digits</TITLE></HEAD>\n";
print "<BODY TEXT=\"#000000\" BGCOLOR=\"#FFFFFF\" LINK=\"#CC0066\" VLINK=\"#003399\" ALINK=\"#CCFF33\">\n";
print "<FONT SIZE=5 COLOR=\"#990000\"><STRONG>カウンター数字サンプル</STRONG></FONT><BR>\n";
print "<HR SIZE=3>\n";
print "<TABLE BORDER=1 CELLSPACING=2>\n";
print "<TR>\n";
print "<TD BGCOLOR=$bgcolor><IMG SRC=\"/cgi-bin/counter/counter.cgi?DataFile=digits-sample.num&amp;Font=$fname\" ALIGN=\"MIDDLE\">\n";
print "<TD><STRONG>&lt;IMG SRC=\"/cgi-bin/counter/counter.cgi?DataFile=digits-sample.num&amp;Font=$fname\"&gt;</STRONG>\n";
print "</TR></TABLE>\n";
print "</BODY></HTML>\n";
