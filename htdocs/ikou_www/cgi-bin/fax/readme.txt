#
#   $Id: readme.txt,v 1.6 2000/11/30 07:02:30 takatera Exp $
#
#   Copyright (c) 2000, First Server. All rights reserverd.
#

FAX�����ȥ�����

�� �Ϥ����

���Υ�����ץȤ�FORM�ǻ��ꤷ���ե�����򸵤�NTT���ߥ�˥��������(��)
�������ӥ����󶡤��Ƥ����Arcstar InternetFAX��(���: ���󥿡��ͥå�
FAX�����ӥ� �ƥ��륹)�����Ѥ���FAX����������CGI�Ǥ���
�ޤ������ΤȤ��̤�FAX�����ȥ������������Ԥ��ġ�����Ѱդ��Ƥ��ޤ���
�� �ѥ���ɤ�桼��ID���ѹ��������ˤ��Ѱդ��б����뤳�Ȥ�����ޤ���

�ʤ�����CGI�����Ѥ���ˤ�ͽ�� Arcstar InternetFAX �˿�������Ǥ���ɬ��
������ޤ���  Arcstar InternetFAX �ξܺ٤� http://www.ntt.com/iFAX/ 
�򻲾Ȥ��Ʋ�������

�� �ե�����ꥹ��

����CGI�ϰʲ��ξ��ˤ���ޤ���

/www/cgi-bin/fax/common.ph       perl�Υإå��ե�����
                 common.pl       perl�ζ��̥��֥롼����ե�����
                 fax.cgi         FAX�����Ƥ��ǧ/����/�������롣
                 fax_form.cgi    �ƥ����ȥե��������������Ϥ��줿ʸ�̤�
                                 FAX���������롣
                 fax_conf.cgi    FAX�����ȥ���������CGI

                 readme.txt      ���Υե�����

�� ��CGI������

1. fax.cgi

    1) ��ǽ

       �ʲ��λ��ꤷ��ʸ��� Arcstar InternetFAX �����ݡ��Ȥ���ǡ�����
       ���ꤷ�� FAX���������ޤ���

    (1) FAX�ֹ�     : FAX�������������������ֹ�Ǥ���
                      �����ʳ��˵���Ȥ��ơ�-()�פ����ѤǤ��ޤ���
    (2) FAX������� : �ƥ����ȥե��������ꤷ�ޤ���
                      ʸ�������ɤ�JIS,���ե�JIS,���ܸ�EUC�ʤɤ����ѤǤ��ޤ���
    (3) ź�եե�����: �����ե�����ʤ� Arcstar InternetFAX �ǻ��Ѳ�ǽ��
                      �ե��������ꤷ�ޤ���

    2) ɬ�ܹ���

        �ʲ��ΤȤ�����ꤷ�ޤ���

    (1) FAX��������
        ʣ��������������Ǥ��ޤ���
        INPUTʸ�����NAME�ˤ� FAX�� �Ȼ��ꤷ�Ʋ�������
        TYPE�ˤϲ�����ꤷ�Ƥ⹽���ޤ��󤬡�ɬ��FAX�ֹ椬CGI���Ϥ�褦
        �˵��Ҥ��Ʋ��������̾�� TEXT �ʤɤ���ꤷ�Ƥ���������ʤ��Ǥ��礦��
    (2) FAX�������
        INPUTʸ�����NAME�ˤ� MSG:�� �Ȼ��ꤷ�Ʋ�������
        VALUE�ˤ�������Ȥ��ƻ��Ѥ���ƥ����ȥե��������ꤷ�Ʋ�������
        �ƥ����ȥե������/cgi-data/fax/��������Хѥ��ǻ��ꤷ�ޤ���
        ʣ���Υƥ����ȥե������CGI���Ϥ����Ȥ��ǽ�Ǥ������ξ�� ����
        �����ƥ����ȥե���������Ƥ�HTML�ե�����˵��Ҥ������1�Ĥ�ʸ��
        �ˤĤʤ���蘆�줿���������ˤʤ�ޤ���
    (3) ź�եե�����
        INPUTʸ�����NAME�ˤ� FILE:�� �Ȼ��ꤷ�Ʋ�������
        VALUE�ˤ�ź�եե�����Ȥ��ƻ��Ѥ���ե��������ꤷ�Ʋ�������
        �ե������/cgi-data/fax/��������Хѥ��ǻ��ꤷ�ޤ���
        ʣ���Υե������CGI���Ϥ����Ȥ��ǽ�Ǥ���

    3) Arcstar InternetFAX ������

    Arcstar InternetFAX ���׵᤹���������ϰʲ��ΤȤ�����ꤷ�ޤ���
    ���ꤷ�ʤ����ϡ������Фˤ�������ե����뤫���ͤ����ޤ���

    (1) �桼��ID
        INPUTʸ�����NAME�� userid �Ȼ��ꤷ�Ʋ�������
    (2) �ѥ����
        INPUTʸ�����NAME�� passwd �Ȼ��ꤷ�Ʋ�������
    (3) �������᡼�륢�ɥ쥹
        INPUTʸ�����NAME�� from �Ȼ��ꤷ�Ʋ�������

    �ޤ��ʲ����������ꤹ�뤳�Ȥ�����ޤ���

    (4) Arcstar InternetFAX ������᡼��ι�����������᡼�륢�ɥ쥹
        INPUTʸ�����NAME�� cc �Ȼ��ꤷ�Ʋ�������

    4) ����¾������

    (1) confirm_file : ��ǧ���̤ʤɤ�CGI�ν��Ϸ�̤�Ϥ����HTML�ե�����
    (2) ok_url       : FAX�������������ɽ������ڡ����λ���
    (3) ng_file      : �������Ƥ����꤬�������ɽ������ե�����λ���
    (4) subject      : FAX����������Ȥ��˥᡼��Υ��֥������Ȥ���ꤹ�롣
    (5) html_kanji   : HTMLʸ��δ��������ɤλ���[euc,sjis]

    5) HTML�ե��������

	 <HTML>
	 <BODY>
	 <FORM METHOD="POST" ACTION="./fax.cgi">
	 FAX�ֹ�  <INPUT SIZE="50" TYPE="text" NAME="FAX">BR>
	 FAX�ֹ�2 <INPUT SIZE="50" TYPE="text" NAME="FAX1"><BR>
	 <P>
	 �����(�귿ʸ)<BR>
	 <INPUT TYPE="radio" NAME="MSG:�����1" VALUE="header1.txt">�����1<BR>
	 <INPUT TYPE="radio" NAME="MSG:�����2" VALUE="header2.txt">�����2<BR>
	 <INPUT TYPE="radio" NAME="MSG:�����3" VALUE="header3.txt">�����3<BR>
	 <INPUT TYPE="radio" NAME="MSG:�����4" VALUE="header4.txt">�����4<BR>
	 <INPUT TYPE="radio" NAME="MSG:�����5" VALUE="header5.txt">�����5<BR>
	 <P>
	 �귿ʸ��<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:�귿ʸ1" VALUE="test.doc">�귿ʸ1<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:�귿ʸ2" VALUE="test.doc">�귿ʸ2<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:�귿ʸ3" VALUE="test.doc">�귿ʸ3<BR>
	 <INPUT TYPE="checkbox" NAME="FILE:�귿ʸ4" VALUE="test.doc">�귿ʸ4<BR>
	 <P>
	 <INPUT TYPE="submit" VALUE="OK">
	 <INPUT TYPE="reset" VALUE="clear">

	 <INPUT TYPE="hidden" NAME="confirm_file" VALUE="confirm.html">
	 <INPUT TYPE="hidden" NAME="ok_url" VALUE="http://www.firstserver.ne.jp/">
	 <INPUT TYPE="hidden" NAME="ng_file" VALUE="ng.html">
	 <INPUT TYPE="hidden" NAME="subject" VALUE="FAX�����ȥ�����">
	 <INPUT TYPE="hidden" NAME="html_kanji" VALUE="sjis">

	 <INPUT TYPE="hidden" NAME="passwd" VALUE="pass_word">
	 <INPUT TYPE="hidden" NAME="from" VALUE="support@firstserver.ne.jp">
	 <INPUT TYPE="hidden" NAME="cc" VALUE="info@firstserver.ne.jp">
     <INPUT TYPE="hidden" NAME="userid" VALUE="user_id">

	 </FORM>
	 </BODY>
	 </HTML>

2. fax_form.cgi

    1) ��ǽ

       ���ꤷ��ʸ�̤ǻ��ꤷ��FAX�ֹ��FAX���������ޤ���

    2) ɬ�ܹ���

    (1) FAX��������
        ʣ��������������Ǥ��ޤ���
        INPUTʸ�����NAME�ˤ� FAX�� �Ȼ��ꤷ�Ʋ�������
        TYPE�ˤϲ�����ꤷ�Ƥ⹽���ޤ��󤬡�ɬ��FAX�ֹ椬CGI���Ϥ�褦
        �˵��Ҥ��Ʋ��������̾�� TEXT �ʤɤ���ꤷ�Ƥ���������ʤ��Ǥ��礦��
    (2) FAX��ʸ��
        TEXTAREA�������NAME�ˤ� MSG �Ȼ��ꤷ�Ʋ�������
        �ƥ����ȥե����फ�����Ϥ��뤳�Ȥ����ꤷ�Ƥ��ޤ�����INPUTʸ��hidden
        °���ʤɤ��Ѥ��ƥ���ƥ�Ĥ���Ū�˵��Ҥ��Ƥ⹽���ޤ���

    3) Arcstar InternetFAX ������

    Arcstar InternetFAX ���׵᤹���������ϰʲ��ΤȤ�����ꤷ�ޤ���
    ���ꤷ�ʤ����ϡ������Фˤ�������ե����뤫���ͤ����ޤ���

    (1) �桼��ID
        INPUTʸ�����NAME�� userid �Ȼ��ꤷ�Ʋ�������
    (2) �ѥ����
        INPUTʸ�����NAME�� passwd �Ȼ��ꤷ�Ʋ�������
    (3) �������᡼�륢�ɥ쥹
        INPUTʸ�����NAME�� from �Ȼ��ꤷ�Ʋ�������

    �ޤ��ʲ����������ꤹ�뤳�Ȥ�����ޤ���

    (4) Arcstar InternetFAX ������᡼��ι�����������᡼�륢�ɥ쥹
        INPUTʸ�����NAME�� cc �Ȼ��ꤷ�Ʋ�������

    4) ����¾������

    (1) confirm_file : ��ǧ���̤ʤɤ�CGI�ν��Ϸ�̤�Ϥ����HTML�ե�����
    (2) ok_url       : FAX�������������ɽ������ڡ����λ���
    (3) ng_file      : �������Ƥ����꤬�������ɽ������ե�����λ���
    (4) subject      : FAX����������Ȥ��˥᡼��Υ��֥������Ȥ���ꤹ�롣
    (5) html_kanji   : HTMLʸ��δ��������ɤλ���[euc,sjis]

    5) HTML�ե��������

	  <HTML>
	  <BODY>

	  <FORM METHOD=POST ACTION="./fax_form.cgi">
	  FAX�ֹ�1 <INPUT SIZE="50" TYPE="text" NAME="FAX"><BR>
	  FAX�ֹ�2 <INPUT SIZE="50" TYPE="text" NAME="FAX2"><BR>
	  �����(�귿ʸ)<BR>
	  <TEXTAREA name="MSG" rows="20" cols="80"></TEXTAREA>
	  <P>
	  <INPUT TYPE="submit" VALUE="OK">
	  <INPUT TYPE="reset" VALUE="clear"><BR>

	  <INPUT TYPE="hidden" NAME="ok_url" VALUE="http://www.firstserver.ne.jp/">
	  <INPUT TYPE="hidden" NAME="confirm_file" VALUE="confirm.html">
	  <INPUT TYPE="hidden" NAME="ng_file" VALUE="ng.html">
	  <INPUT TYPE="hidden" NAME="html_kanji" VALUE="sjis">
	  <INPUT TYPE="hidden" NAME="subject" VALUE="FAX�����ȥ������Υƥ���">

	  <INPUT TYPE="hidden" NAME="passwd" VALUE="pass_word">
	  <INPUT TYPE="hidden" NAME="from" VALUE="support@firstserver.ne.jp">
	  <INPUT TYPE="hidden" NAME="cc" VALUE="info@firstserver.ne.jp">
	  <INPUT TYPE="hidden" NAME="userid" VALUE="user_id">
	  </FORM>

	  </BODY>
	  </HTML>

3. fax_conf.cgi

    1) ��ǽ

       fax.cgi/fax_form.cgi �ǻ��Ѥ��� Arcstar InternetFAX �δ�������
       ��ͽ�᥵���Ф����ꤷ�ޤ�(����ե���������/��������)��

    2) ��ħ

    (1) ��CGI������ե�����򤷤Ƥ⥳��ƥ�Ĥ˥ѥ���ɤʤɤ����ꤵ
        ��Ƥ����� ���������ꤷ�����Ƥ�̵�뤵��ޤ���
    (2) �����Ф�����ե�������֤������ʤ�������CGI���������뤳��
        ���Ǥ��ޤ���
    (3) ��CGI�Ǻ�����������ե�����ϥƥ����ȥե�����Ǥ���
        ���ä� ����Ū�ʥƥ����ȥ��ǥ����ǥե�������������FTP�ǥ�����
        �˥��åץ��ɤ��Ƥ���CGI���Ѥ���Τ�Ʊ�ͤη�̤������ޤ���

    3) ����ե�����

    (1) �ե�����̾�ڤӥѥ�
        �ե�����̾: fax_mail.conf
        �ѥ�      : /cgi-data/fax
    (2) �����ȹ�
        ��Ƭ����#�פιԤϥ����ȹԤȤ��ư����ץ����Ū�ˤϰ�̣��
        �����ޤ���
    (3) �Ԥι�¤
        �����ȹ԰ʳ��γƹԤϼ��Τ褦�ʹ�¤�򤷤Ƥ��ޤ���
            [�������]:[����ʸ��][������]
        ��������ܤ�ɬ����:��(�����)�ǽ�λ���ޤ���
        ������ʸ����Ⱦ�ѥ��ڡ��������֤ʤɤǤ���
          ���ѥ��ڡ����϶���ʸ���Ȥ��ư����ޤ���
        �������ͤˤϳ�������ܤ��ͤ������ޤ���
    (4) �����ͤ�����
        ��passwd	Arcstar InternetFAX �Υѥ����
        ��userid	Arcstar InternetFAX �Υ桼��ID
        ��from      Arcstar InternetFAX �˥᡼�����������Ȥ���ȯ����
                    �᡼�륢�ɥ쥹
        ��cc        Arcstar InternetFAX ������᡼��ι���������������
                    �Υ᡼�륢�ɥ쥹
        ��fax_count 10ʬ���� Arcstar InternetFAX ������᡼����ξ��
                    0�ʲ������ꤹ���̵���¤ˤʤ롣
					���ꤷ�Ƥ��ʤ���� ����10ʬ����10�̤ˤʤ롣

    4) ����ե��������

        passwd:    pass_word
        from:      support@firstserver.ne.jp
        userid:    user_id
        cc:        info@firstserver.ne.jp
		fax_count: 20

�� �������ƥ��ˤĤ���

��CGI�Ǥ� Arcstar InternetFAX �˽���Υ᡼����������뤳�Ȥ�FAX������
���뤳�Ȥ�¸����Ƥ��ޤ���Arcstar InternetFAX �����Ѥ���Ȼ�������ʧ��
�ʤ���Фʤ�ޤ��󡣽��äơ��տޤ��ʤ��������̤�FAX���������Ƥ��ޤ��
���褦�ˤ���ɬ�פ�����ޤ���

��CGI�Ǥϰʲ���2�������ˡ�Ǥ������� FAX������������������Ȥߤ��Ѱդ�
�Ƥ��ޤ���

1. ñ�̻��������FAX�������ξ��

    Ϣ³����CGI�򲿲��¹Ԥ���Ƥ��ޤ�����̤Ȥ������̤�FAX����������
    ���Ȥ򤢤������ɻߤ��뤳�Ȥ���Ū�Ǥ���
    �ºݤˤϲ��10ʬ�δ֤�CGI���� Arcstar InternetFAX �˲��̥᡼�����
    �������������Ƥ��ޤ���
    �㤨�� Ʊ���ۥ���(IP���ɥ쥹)������10ʬ�֤�9��FAX���������Ƥ���
    ��� ����1�̤���FAX�������Ǥ��ޤ�����������FAX�����������Τ�������
    8ʬ�����Ȥ���Ⱥ�����2ʬ���ƤФ⤦1��FAX�������Ǥ��ޤ������Ǥ�FAX
    ��10�����äƤ��ޤäƤ����硢FAX���������褦��CGI��¹Ԥ���ȥ��顼
    ��å�������ɽ������FAX�������Ǥ��ޤ���

    ����ϴ��Ҥ�����ե��������˵��Ҥ��ޤ���
    ¾�������ͤȰ㤤HTML�ե���������INPUT������Ȥ˵��Ҥ��뤳�Ȥ�
    �Ǥ��ޤ��󡣤����������CGI����Ѥ��褦�Ȥ���ͤ����ξ���ͤ��Թ�
    �ɤ�����Ǥ��ʤ��褦�ˤ��뤿��Ǥ���
    �����ͤȤ���0�ʲ��ο��������ꤷ����硢FAX��������̵���¤˹Ԥ�����
    �������褦�ˤʤ�ޤ���
    �ޤ��������ͤ����ꤷ�Ƥ��ʤ�����10ʬ�������10�̤ޤ�FAX��������
    ���ޤ���

2. ¾��Web�����Ȥ����󥯤��줿������������ݤ��롣

    CGI���ƤФ줿Web������(URL)��CGI�����֤���Ƥ�����Ȱ㤦��硢
    FAX����������ݤ��ޤ���
    �������Ѥ�Ԥ����Ȥ��Ƥ���ͤ����ϥڡ�����ɤ���¾�Υ����Ȥ�Ω����
    ���Ƥ����� CGI������Ȥ����Ȥ���Τ��ɻߤ��ޤ���
    ��CGI��Ȥ����Ȥ��Ǥ���ͤ�����Ʊ�������Ф�HTML�ե���������֤Ǥ�
    ��Ϥ��Ǥ����� ɬ��Ʊ�������Ȥʤ������ϥڡ������֤��Ʋ�������

3. Arcstar InternetFAX ���������

    Arcstar InternetFAX ���������(�桼��ID���ѥ���ɡ��������᡼��
    ���ɥ쥹)�ڤӥ᡼��ι�������������᡼�륢�ɥ쥹�ϥ���ե����졼
    ���������ꤹ����ˡ��CGI��ƤӽФ�HTML�ե�����˵��Ҥ�����ˡ��2�̤�
    ����ˡ�ǻ���Ǥ��ޤ���
    �⤷HTML�ե�����ǻ��ꤵ��Ƥ��ʤ��ä��ꡢ���ꤵ��Ƥ��Ƥ� �桼��
    ID���ѥ���ɡ��������᡼�륢�ɥ쥹�����˻��ꤵ��Ƥ��ʤ�����
    ����ե����졼���������ꤷ���ͤ�Ȥä�FAX���������ޤ���
    �ޤ���ñ�̻���������Ƥ���FAX��������HTML�ե�����������ꤹ�뤳��
    �ϤǤ��ޤ���

