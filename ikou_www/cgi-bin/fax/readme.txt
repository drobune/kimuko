#
#   $Id: readme.txt,v 1.6 2000/11/30 07:02:30 takatera Exp $
#
#   Copyright (c) 2000, First Server. All rights reserverd.
#

FAXゲートウェイ

★ はじめに

このスクリプトはFORMで指定したファイルを元にNTTコミュニケーション(株)
がサービスを提供している「Arcstar InternetFAX」(旧称: インターネット
FAXサービス テガルス)を利用してFAXを送信するCGIです。
また、本体とは別にFAXゲートウェイの設定を行うツールを用意していますの
で パスワードやユーザIDを変更した場合にも用意に対応することが出来ます。

なお、本CGIを利用するには予め Arcstar InternetFAX に申し込んでおく必要
があります。  Arcstar InternetFAX の詳細は http://www.ntt.com/iFAX/ 
を参照して下さい。

★ ファイルリスト

このCGIは以下の場所にあります。

/www/cgi-bin/fax/common.ph       perlのヘッダファイル
                 common.pl       perlの共通サブルーチンファイル
                 fax.cgi         FAXの内容を確認/修正/送信する。
                 fax_form.cgi    テキストフォーム等から入力された文面で
                                 FAXを送信する。
                 fax_conf.cgi    FAXゲートウェイ設定CGI

                 readme.txt      このファイル

★ 各CGIの説明

1. fax.cgi

    1) 機能

       以下の指定した文書と Arcstar InternetFAX がサポートするデータを
       指定して FAXを送信します。

    (1) FAX番号     : FAXを送信する相手の電話番号です。
                      数字以外に記号として「-()」が使用できます。
    (2) FAXの送り状 : テキストファイルを指定します。
                      文字コードはJIS,シフトJIS,日本語EUCなどが利用できます。
    (3) 添付ファイル: 画像ファイルなど Arcstar InternetFAX で使用可能な
                      ファイルを指定します。

    2) 必須項目

        以下のとおり指定します。

    (1) FAXの送信先
        複数の送信先を指定できます。
        INPUT文の中でNAMEには FAX〜 と指定して下さい。
        TYPEには何を指定しても構いませんが、必ずFAX番号がCGIに渡るよう
        に記述して下さい。通常は TEXT などを指定しておけば問題ないでしょう。
    (2) FAXの送り状
        INPUT文の中でNAMEには MSG:〜 と指定して下さい。
        VALUEには送り状として使用するテキストファイルを指定して下さい。
        テキストファイルは/cgi-data/fax/からの相対パスで指定します。
        複数のテキストファイルをCGIに渡すことも可能です。この場合 指定
        したテキストファイルの内容がHTMLファイルに記述した順に1つの文章
        につなぎ合わされた上で送り状になります。
    (3) 添付ファイル
        INPUT文の中でNAMEには FILE:〜 と指定して下さい。
        VALUEには添付ファイルとして使用するファイルを指定して下さい。
        ファイルは/cgi-data/fax/からの相対パスで指定します。
        複数のファイルをCGIに渡すことも可能です。

    3) Arcstar InternetFAX の設定

    Arcstar InternetFAX が要求する設定情報は以下のとおり指定します。
    指定しない場合は、サーバにある設定ファイルから値を得ます。

    (1) ユーザID
        INPUT文の中でNAMEに userid と指定して下さい。
    (2) パスワード
        INPUT文の中でNAMEに passwd と指定して下さい。
    (3) 送信元メールアドレス
        INPUT文の中でNAMEに from と指定して下さい。

    また以下の設定を指定することが出来ます。

    (4) Arcstar InternetFAX に送るメールの控えの送信先メールアドレス
        INPUT文の中でNAMEに cc と指定して下さい。

    4) その他の設定

    (1) confirm_file : 確認画面などでCGIの出力結果をはめ込むHTMLファイル
    (2) ok_url       : FAXを送信した後に表示するページの指定
    (3) ng_file      : 入力内容に問題がある場合に表示するファイルの指定
    (4) subject      : FAXを送信するときにメールのサブジェクトを指定する。
    (5) html_kanji   : HTML文書の漢字コードの指定[euc,sjis]

    5) HTMLファイルの例

	 <HTML>
	 <BODY>
	 <FORM METHOD="POST" ACTION="./fax.cgi">
	 FAX番号  <INPUT SIZE="50" TYPE="text" NAME="FAX">BR>
	 FAX番号2 <INPUT SIZE="50" TYPE="text" NAME="FAX1"><BR>
	 <P>
	 送り状(定型文)<BR>
	 <INPUT TYPE="radio" NAME="MSG:送り状1" VALUE="header1.txt">送り状1<BR>
	 <INPUT TYPE="radio" NAME="MSG:送り状2" VALUE="header2.txt">送り状2<BR>
	 <INPUT TYPE="radio" NAME="MSG:送り状3" VALUE="header3.txt">送り状3<BR>
	 <INPUT TYPE="radio" NAME="MSG:送り状4" VALUE="header4.txt">送り状4<BR>
	 <INPUT TYPE="radio" NAME="MSG:送り状5" VALUE="header5.txt">送り状5<BR>
	 <P>
	 定型文書<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:定型文1" VALUE="test.doc">定型文1<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:定型文2" VALUE="test.doc">定型文2<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:定型文3" VALUE="test.doc">定型文3<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:定型文4" VALUE="test.doc">定型文4<BR>
	 <P>
	 <INPUT TYPE="submit" VALUE="OK">
	 <INPUT TYPE="reset" VALUE="clear">

	 <INPUT TYPE="hidden" NAME="confirm_file" VALUE="confirm.html">
	 <INPUT TYPE="hidden" NAME="ok_url" VALUE="http://www.firstserver.ne.jp/">
	 <INPUT TYPE="hidden" NAME="ng_file" VALUE="ng.html">
	 <INPUT TYPE="hidden" NAME="subject" VALUE="FAXゲートウェイ">
	 <INPUT TYPE="hidden" NAME="html_kanji" VALUE="sjis">

	 <INPUT TYPE="hidden" NAME="passwd" VALUE="pass_word">
	 <INPUT TYPE="hidden" NAME="from" VALUE="support@firstserver.ne.jp">
	 <INPUT TYPE="hidden" NAME="cc" VALUE="info@firstserver.ne.jp">
     <INPUT TYPE="hidden" NAME="userid" VALUE="user_id">

	 </FORM>
	 </BODY>
	 </HTML>

2. fax_form.cgi

    1) 機能

       指定した文面で指定したFAX番号にFAXを送信します。

    2) 必須項目

    (1) FAXの送信先
        複数の送信先を指定できます。
        INPUT文の中でNAMEには FAX〜 と指定して下さい。
        TYPEには何を指定しても構いませんが、必ずFAX番号がCGIに渡るよう
        に記述して下さい。通常は TEXT などを指定しておけば問題ないでしょう。
    (2) FAXの文面
        TEXTAREA等の中でNAMEには MSG と指定して下さい。
        テキストフォームから入力することを想定していますが、INPUT文のhidden
        属性などを用いてコンテンツに静的に記述しても構いません。

    3) Arcstar InternetFAX の設定

    Arcstar InternetFAX が要求する設定情報は以下のとおり指定します。
    指定しない場合は、サーバにある設定ファイルから値を得ます。

    (1) ユーザID
        INPUT文の中でNAMEに userid と指定して下さい。
    (2) パスワード
        INPUT文の中でNAMEに passwd と指定して下さい。
    (3) 送信元メールアドレス
        INPUT文の中でNAMEに from と指定して下さい。

    また以下の設定を指定することが出来ます。

    (4) Arcstar InternetFAX に送るメールの控えの送信先メールアドレス
        INPUT文の中でNAMEに cc と指定して下さい。

    4) その他の設定

    (1) confirm_file : 確認画面などでCGIの出力結果をはめ込むHTMLファイル
    (2) ok_url       : FAXを送信した後に表示するページの指定
    (3) ng_file      : 入力内容に問題がある場合に表示するファイルの指定
    (4) subject      : FAXを送信するときにメールのサブジェクトを指定する。
    (5) html_kanji   : HTML文書の漢字コードの指定[euc,sjis]

    5) HTMLファイルの例

	  <HTML>
	  <BODY>

	  <FORM METHOD=POST ACTION="./fax_form.cgi">
	  FAX番号1 <INPUT SIZE="50" TYPE="text" NAME="FAX"><BR>
	  FAX番号2 <INPUT SIZE="50" TYPE="text" NAME="FAX2"><BR>
	  送り状(定型文)<BR>
	  <TEXTAREA name="MSG" rows="20" cols="80"></TEXTAREA>
	  <P>
	  <INPUT TYPE="submit" VALUE="OK">
	  <INPUT TYPE="reset" VALUE="clear"><BR>

	  <INPUT TYPE="hidden" NAME="ok_url" VALUE="http://www.firstserver.ne.jp/">
	  <INPUT TYPE="hidden" NAME="confirm_file" VALUE="confirm.html">
	  <INPUT TYPE="hidden" NAME="ng_file" VALUE="ng.html">
	  <INPUT TYPE="hidden" NAME="html_kanji" VALUE="sjis">
	  <INPUT TYPE="hidden" NAME="subject" VALUE="FAXゲートウェイのテスト">

	  <INPUT TYPE="hidden" NAME="passwd" VALUE="pass_word">
	  <INPUT TYPE="hidden" NAME="from" VALUE="support@firstserver.ne.jp">
	  <INPUT TYPE="hidden" NAME="cc" VALUE="info@firstserver.ne.jp">
	  <INPUT TYPE="hidden" NAME="userid" VALUE="user_id">
	  </FORM>

	  </BODY>
	  </HTML>

3. fax_conf.cgi

    1) 機能

       fax.cgi/fax_form.cgi で使用する Arcstar InternetFAX の基本設定
       を予めサーバに設定します(設定ファイルを作成/修正する)。

    2) 特徴

    (1) 本CGIで設定ファイルをしてもコンテンツにパスワードなどが設定さ
        れている場合 事前に設定した内容は無視されます。
    (2) サーバに設定ファイルを置きたくない場合は本CGIから削除すること
        ができます。
    (3) 本CGIで作成する設定ファイルはテキストファイルです。
        従って 一般的なテキストエディタでファイルを作成してFTPでサーバ
        にアップロードしても本CGIを用いるのと同様の結果が得られます。

    3) 設定ファイル

    (1) ファイル名及びパス
        ファイル名: fax_mail.conf
        パス      : /cgi-data/fax
    (2) コメント行
        行頭が「#」の行はコメント行として扱われプログラム的には意味を
        持ちません。
    (3) 行の構造
        コメント行以外の各行は次のような構造をしています。
            [設定項目]:[空白文字][設定値]
        ・設定項目は必ず「:」(コロン)で終了します。
        ・空白文字は半角スペース、タブなどです。
          全角スペースは空白文字として扱われません。
        ・設定値には各設定項目の値を記入します。
    (4) 設定値の説明
        ・passwd	Arcstar InternetFAX のパスワード
        ・userid	Arcstar InternetFAX のユーザID
        ・from      Arcstar InternetFAX にメールを送信するときの発信元
                    メールアドレス
        ・cc        Arcstar InternetFAX に送るメールの控えを送信する先
                    のメールアドレス
        ・fax_count 10分当り Arcstar InternetFAX に送るメール数の上限
                    0以下に設定すると無制限になる。
					設定していない場合 最大10分当り10通になる。

    4) 設定ファイルの例

        passwd:    pass_word
        from:      support@firstserver.ne.jp
        userid:    user_id
        cc:        info@firstserver.ne.jp
		fax_count: 20

★ セキュリティについて

本CGIでは Arcstar InternetFAX に所定のメールを送信することでFAXを送信
することを実現しています。Arcstar InternetFAX を利用すると使用料を払わ
なければなりません。従って、意図しない形で大量にFAXを送信してしまわな
いようにする必要があります。

本CGIでは以下の2種類の方法である程度 FAXの送信を抑制する仕組みを用意し
ています。

1. 単位時間当りのFAX送信数の上限

    連続してCGIを何回も実行されてしまい、結果として大量にFAXを送信する
    ことをある程度防止することが目的です。
    実際には過去10分の間にCGIから Arcstar InternetFAX に何通メールを送
    信したか数えています。
    例えば 同じホスト(IPアドレス)から過去10分間に9通FAXを送信している
    場合 あと1通だけFAXを送信できます。一番前にFAXを送信したのが今から
    8分前だとすると今から2分たてばもう1通FAXを送信できます。すでにFAX
    を10通送ってしまっている場合、FAXを送信しようとCGIを実行するとエラー
    メッセージを表示してFAXは送信できません。

    設定は既述の設定ファイルの中に記述します。
    他の設定値と違いHTMLファイルの中のINPUTエレメントに記述することは
    できません。これは不正にCGIを使用しようとする人がこの上限値を都合
    良く設定できないようにするためです。
    設定値として0以下の数字を設定した場合、FAXの送信は無制限に行うこと
    が出来るようになります。
    また、設定値を設定していない場合は10分当り最大10通までFAXを送信で
    きます。

2. 他のWebサイトからリンクされたアクセスを拒否する。

    CGIが呼ばれたWebサイト(URL)がCGIが設置されている場所と違う場合、
    FAXの送信を拒否します。
    不正使用を行おうとしている人が入力ページをどこか他のサイトで立ち上
    げておいて CGIだけを使おうとするのを防止します。
    本CGIを使うことができる人は当然同じサーバにHTMLファイルを設置でき
    るはずですから 必ず同じサイトないに入力ページを置いて下さい。

3. Arcstar InternetFAX の設定情報

    Arcstar InternetFAX の設定情報(ユーザID、パスワード、送信元メール
    アドレス)及びメールの控えを送信するメールアドレスはコンフィグレー
    タから設定する方法とCGIを呼び出すHTMLファイルに記述する方法の2通り
    の方法で指定できます。
    もしHTMLファイルで指定されていなかったり、指定されていても ユーザ
    ID、パスワード、送信元メールアドレスが共に指定されていない場合は
    コンフィグレータから設定した値を使ってFAXを送信します。
    また、単位時間当り許容するFAX送信数はHTMLファイル中に設定すること
    はできません。

