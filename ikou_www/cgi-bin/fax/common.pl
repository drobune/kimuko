#
#   $Id: common.pl,v 1.6 2000/11/30 04:23:18 takatera Exp $
#
#   Copyright (c) 2000, First Server. All rights reserverd.
#

# HTMLコンテンツのヘッダ部を作成する。
sub print_head{
	my $title = $_[0];
	my $code  = $_[1];

	if($code eq ""){
		$code = "EUC-JP";
	}

    print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
    print "<HTML lang=\"ja\">\n";
    print "<HEAD>\n";
    print "<META HTTP-EQUIV=\"Content-Type\" content=\"text/html; charset=$code\">\n";
    print "<LINK REV=MADE HREF=\"mailto:takatera\@firstserver.co.jp\">\n"; 
	print "<!--鶯と龜-->\n";
    print "<TITLE>$title</TITLE>\n\n";
    print "</HEAD>\n\n";
}

# POSTメソッドで与えられた引数を取り出す。
sub get_post_value{
	#my ($buf, $name, $value, $pair, @pairs);
	my ($buf, $pair, @pairs);

	if($ENV{'REQUEST_METHOD'} eq "POST"){
		read(STDIN, $buf, $ENV{'CONTENT_LENGTH'});
	}else{
		print_head("ANTI SPAM", "EUC-JP");
		print "<BODY>\n";
		print "CAN NOT ALLOW GET METHOD.<P>\n";
		print "CGIが直接呼ばれた可能性が有ります。<BR>\n";
		print "正しくやり直してください。\n";
		print "</BODY>\n";
		print "</HTML>\n";
		exit(0);
	}

	@pairs = split(/&/, $buf);
	foreach $pair (@pairs){
		($name, $value) = split(/=/, $pair);
		$value =~ s/\+/ /g;
		$value =~ s/%(..)/pack("c", hex($1))/ge;
		&jcode'convert(*value, 'euc');
		&jcode'h2z_euc(*value);
		$value = kanji_to_ascii($value);
		$value = html_escape($value);

		$name =~ s/\+/ /g;
		$name =~ s/%(..)/pack("c", hex($1))/ge;
		&jcode'convert(*name, 'euc');
		&jcode'h2z_euc(*name);
		$name = kanji_to_ascii($name);

		$form{$name} = $value;
	}
}

sub check_illegal_access{
	split(/\//, $from_host);
	my $refferer_server = $_[2];

	my $addr			= (gethostbyname($refferer_server))[4];
	my $refferer_addr	= join(".", unpack("C4", $addr));
	$addr				= (gethostbyname($server_name))[4];
	my $server_addr		= join(".", unpack("C4", $addr));

	if($refferer_addr ne $server_addr){
		print_head("ANTI SPAM", "EUC-JP");
		print "<BODY>\n";
		print "他のWebサイトからCGIが直接呼ばれた可能性が有ります。<P>\n";
		print "CGI本体があるWebサイトから正しくやり直してください。\n";
		print "</BODY>\n";
		print "</HTML>\n";
		exit(0);
	}
}


sub remove_form_value{
	my $formkey = $_[0];
	my (%buf, $key);

	foreach $key (keys(%form)){
		if( $key ne $formkey){
			$buf{$key} = $form{$key};
		}
	}
	%form = %buf;
}

# POST渡しされた引数をすべて INPUT エレメントに hidden で記述する。
sub print_post_value{
	$negative_key = $_[0];

	my @key = sort(keys(%form));
	my $key;

	print "\n";
	foreach $key (@key){
		if($form{$key} ne "" and $key ne $negative_key){
			print "<INPUT type=\"hidden\" value=\"$form{\"$key\"}\" name=\"$key\">\n";
		}
	}
	print "\n";
}

# FAX送信設定ファイルから設定情報を取得する。
sub read_conf_file{  
	my $conf_file = $_[0];
	my $conf_flag = 0;
	my (%conf, $name, $value, $fax_count);

	if(-e $conf_file and -r $conf_file){
		open(DMY, "> $conf_file_dmy");
		lockfile(\*DMY);

		open(FILE, $conf_file);
		while(<FILE>){
			chomp;
			unless(/^#/ or $_ eq ""){
				split;
				$name  = $_[0];
				$value = $_[1];

				$name =~ s/://;  

				&jcode'convert(*value, 'jis');
				$value = &mimeencode($value);
				$conf{$name} = $value;
				$conf_file = 1;
			}
		}
		close(FILE);

		unlockfile(\*DMY);
		close(DMY);
	} 

	if($form{"userid"} ne "" and $form{"passwd"} ne "" and $form{"from"} ne ""){
		$fax_count = $conf{"fax_count"};
		%conf = ();
		$conf{"fax_count"} = $fax_count;
		foreach $key ("passwd", "from", "userid", "cc"){
			if($form{$key} ne ""){
				$conf{$key} = $form{$key};
			}
		}
	}
	foreach $key ("passwd", "from", "userid"){
		if($conf{$key} eq ""){
			msg("FAXを送信するための設定が不足しています。");
		}
	}
	if($form{"to"} ne ""){
		$fax_to = $form{"to"};
	}

#foreach $key (keys(%conf)){
#	print STDERR "-- $key|$conf{$key}\n";
#}
	return(%conf);
}

# FAX送信回数が規定の上限値に達しているかチェックする。
sub check_bulkrequest{
	my ($i, $lognum, $access_num, @utime, @remote_addr);
	my $job					= $_[0];
	my $utime				= time;
	my $check_interval		= 600;
	my $threshold_count		= 10;
	my $fax_access_log		= "/tmp/fax_access.log";
	my $fax_access_log_dmy	= "/tmp/.fax_access.log.dmy";

	if($fax_conf{'fax_count'} eq ""){
		$fax_conf{'fax_count'} = $threshold_count;
	}elsif($fax_conf{'fax_count'} <= 0){
		return(0);
	}

	# /tmp/fax_access.log を開いてメールの受信履歴を読み込む。
	if(-e $fax_access_log){
		open(DMY, "> $fax_access_log_dmy");
		lockfile(\*DMY);

		open(FILE, $fax_access_log) or die "Can't open to read $fax_access_log.";
		for($i = 0, $lognum = 0; <FILE> ; $i++){
			chomp;
			split(/\t/, $_);
			$utime[$i]       = $_[0];
			$remote_addr[$i] = $_[1];
		}
		$lognum = $i;
		close(FILE);

		unlockfile(\*DMY);
		close(DMY);
	}

	# 過去10分間に同じクライアント(IPアドレス)から何度アクセスしているか数える。
	for($i = 0, $access_num = 0; $i < $lognum; $i++){
		if($utime - $utime[$i] < $check_interval and $remote_addr eq $remote_addr[$i]){
			$access_num++;
		}
	}

	if($job eq "log"){
		# 過去10分以前のログを抹消してログを書き出す。
		open(DMY, "> $fax_access_log_dmy");
		lockfile(\*DMY);

		open(FILE, "> $fax_access_log") or die "Can't open to write $fax_access_log.";
		for($i = 0; $i < $lognum ; $i++){
			if($utime[$i] > $utime - $check_interval){
				print FILE "$utime[$i]\t$remote_addr[$i]\n";
			}
		}
		print FILE "$utime\t$remote_addr\n";
		close(FILE);

		unlockfile(\*DMY);
		close(DMY);
	}else{
		if($fax_conf{'fax_count'} <= $access_num){
			print_head("Restriction of sending FAX", "EUC-JP");
			print "<BODY>\n";
			print "FAXの送信数が上限に達しました。FAXの送信処理を中断します。<P>\n";
			print "しばらくしてから FAXを送信し直して下さい。\n";
			print "</BODY>\n";
			print "</HTML>\n";
			exit(0);
		}
	}
}

sub msg{
	print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
	print "<HTML lang=\"ja\">\n";
	print "<HEAD>\n";
	print "<META HTTP-EQUIV=\"Content-Type\" content=\"text/html; charset=EUC-JP\">\n";
	print "<LINK REV=MADE HREF=\"mailto:takatera\@firstserver.co.jp\">\n";
	print "<!--鶯と龜-->\n";
	print "<TITLE>Error</TITLE>\n";
	print "</HEAD>\n";
	print "<BODY>\n";
	print $_[0];
	print "</BODY>\n</HTML>\n";

	exit(0);
}

sub msg2{
	my $file     = $_[0];
	   $message  = $_[1];
	my $code     = $form{"html_kanji"};

	&jcode'convert(*message, $code);

	open(FILE, $file) or print $message;
	while(<FILE>){
		if(/<!--insert here-->/){
			print $message;
		}else{
			print $_;
		}
	}
	close(FILE);

	exit(0);
}

sub html_escape{
	my $str = $_[0];

	$str  =~ s/&/&amp;/g;
	$str  =~ s/</&lt;/g;
	$str  =~ s/>/&gt;/g;
	$str  =~ s/"/&quot;/g;
	#$str  =~ s/ /&nbsp;/g;

	return($str);
}

sub html_unescape{
	my $str = $_[0];

	$str  =~ s/&amp;/&/g;
	$str  =~ s/&lt;/</g;
	$str  =~ s/&gt;/>/g;
	$str  =~ s/&quot;/"/g;
	$str  =~ s/&nbsp;/ /g;

	return($str);
}

sub kanji_to_ascii{
	my $str = $_[0]; 

	$str = &jcode'trans($str, "Ａ-Ｚ", "A-Z");
	$str = &jcode'trans($str, "ａ-ｚ", "a-z");
	$str = &jcode'trans($str, "０-９", "0-9");

	$str = &jcode'trans($str, "＿", "_");
	$str = &jcode'trans($str, "−", "-");
	$str = &jcode'trans($str, "＠", "@");
	$str = &jcode'trans($str, "（", "(");
	$str = &jcode'trans($str, "）", ")");
	$str = &jcode'trans($str, "＜", "<");
	$str = &jcode'trans($str, "＞", ">");
	$str = &jcode'trans($str, "″", "\"");
	$str = &jcode'trans($str, "＝", "=");
	$str = &jcode'trans($str, "，", ",");
	$str = &jcode'trans($str, "．", ".");

	return $str;
}

# ファイルをロックする
sub lockfile{
	my($lock_file_handle) = @_[0];
	my($return_val);
	$return_val = flock($lock_file_handle, $LOCK_EX);
	return $return_val;
}

# ファイルのロックを解除する
sub unlockfile{
	my($lock_file_handle) = @_[0];
	my($return_val);
	$return_val = flock($lock_file_handle, $LOCK_UN);
	return $return_val;
}


1;
