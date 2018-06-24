#
#   $Id: common.ph,v 1.5 2000/11/30 01:23:03 takatera Exp $
#
#   Copyright (c) 2000, First Server. All rights reserverd.
#
$ENV{'IFS'} = '' if $ENV{'IFS'};
$ENV{'PATH'} = '/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin';
umask(022);

# Include librarys
require 'jcode.pl';
require 'mimew.pl';
require 'common.pl';

# Get User Name , Home directory
$login = (getpwuid($<))[0] || "Intruder!!";
$ENV{'HOME'} = $home = "/virtual";
$cgi_data    = "$home/cgi-data";
$fax_data    = "$cgi_data/fax";

# for file lock
$LOCK_EX=2;
$LOCK_UN=8;

# Temporary files there are.
$tmp_file = "$home/cgi-data/mail-tmp$$.dat";

# Where is the host conection
$host_name		= $ENV{'REMOTE_HOST'};
$remote_addr	= $ENV{'REMOTE_ADDR'};
$host_addr		= $ENV{'HTTP_X_FORWARDED_FOR'};
$from_host		= $ENV{'HTTP_REFERER'};
$user_agent		= $ENV{'HTTP_USER_AGENT'};
$server_name	= $ENV{'SERVER_NAME'};

# date and time
$date = `date "+%Y/%m/%d"`;
$time = `date "+%H:%m:%S"`;
chop $date;
chop $time;

$mail_conf		= "$fax_data/fax_mail.conf";
$mail_conf_dmy	= "$fax_data/.fax_mail.conf.dmy";

$fax_prefix		= "#213";
$fax_to			= "olink.ne.jp";

$mail_conf_name{"from"}				= "送信元メールアドレス";
$mail_conf_name{"cc"}				= "メールの控えの送信先";
$mail_conf_name{"userid"}			= "Arcstar InternetFAX のユーザID";
$mail_conf_name{"passwd"}			= "Arcstar InternetFAX のパスワード";


print "Content-type:text/html\n\n";

