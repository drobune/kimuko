<?php

// ====================================
// ■ My関数 : Build.xml 作成
//      [ dir ] : 保存パス
//      [ maxpage ] : ページ数 ( 1ベースカウント )
// ====================================
function myBuildXml($args){
  // 初期化
  $ret = "";
  $Dir = $args["dir"];
  $MaxPage = $args["maxpage"];
  $w = $args["w"];
  $h = $args["h"];

  // 処理
  $BuildXml = '﻿<?xml version="1.0" encoding="UTF-8"?>
<EBookRoot>
  <SETEnvUserSetParam>
    <ProjectName>d</ProjectName>
    <PageSizeFlag>1</PageSizeFlag>
    <LastPageNumber>' . $MaxPage . '</LastPageNumber>
    <MediaWidth>' . $w . '</MediaWidth>
    <MediaHeight>' . $h . '</MediaHeight>
    <PageThick_Flag>0</PageThick_Flag>
    <LoadingMsg>Now Loading...</LoadingMsg>
    <SpecificationProjectName>
    </SpecificationProjectName>
  </SETEnvUserSetParam>
</EBookRoot>';

    // ファイル書き出し
  creFile($BuildXml,$Dir."Build.xml");

  // リターン
  return $ret;
}


// ====================================
// ■ My関数 : 目次.xml 作成
//      [ dir ] : 保存パス
//      [ maxpage ] : ページ数 ( 1ベースカウント )
// ====================================
function myCreEBookIndexTextParam($args){
  $xmldata = "";
  $xmldata .= '<?xml version="1.0" encoding="UTF-8"?>
  <EBookRoot>
  <!-- Index Text Parameter -->
  <PageDataCount>'.$args["cnt"].'</PageDataCount>';

  foreach((array)$args["lst"] as $k => $v){
  if(empty($v)) continue;
  $_ary = explode(",", $v);
  $xmldata .= '
  <IndexText PageNo="'.$_ary[0].'">
  <IndexTextData>'.htmlspecialchars($_ary[1]).'</IndexTextData>
  </IndexText>';
  }
  $xmldata .= '</EBookRoot>';

  creFile($xmldata,$args["path"]);
}

// ====================================
// ■ My関数 : PDFLib Data 作成
//      [ dir ] : 保存パス
//      [ page ]
//      [ data ]
// ====================================
function myPDFLibXml($args){
  // 初期化
  $ret = "";
  $SizeTyp = $args["sizetyp"];
  $Dir = $args["dir"];
  $Page = $args["page"];
  $Data = $args["data"];
  $_ChkJpg = $args["sample_jpg"];
  $_pdf_base_size = $args["pdf_base_size"];

  list($w, $h, $type, $attr) = getimagesize($_ChkJpg);
  $GazouW = $w;
  $GazouH = $h;

  // 定数 A4ベース比率
  $w_A4 = "1587";
  $h_A4 = "2245";

  $w_base_hiritsu = "1240";
  $h_base_hiritsu = "1754";

  // 比率 定義
  $w_hiritsu = $_pdf_base_size["w"] / $w_base_hiritsu;
  $h_hiritsu = $_pdf_base_size["h"] / $h_base_hiritsu;

  // 比率を基準にベース値作成
  (int)$w_A4 = $w_A4 * $w_hiritsu;
  (int)$h_A4 = $h_A4 * $h_hiritsu;

  $MyTekitouConv = $GazouW / $w_A4;

  // 処理
  // タテヨコでページ数 変更
  if($SizeTyp == "T"){
    $Page = $Page + 1;
  }else{
    // 横のとき
    $Page = $Page + 1;
  }

  // 追加で csvファイルを書き出す
  foreach($Data as $v){
    $txt = str_replace(" ","",$v["text"])."\r\n";
    // $txt = mb_convert_encoding($txt, "SJIS-win", "UTF-8");
    // テキストcsv
    // ファイル書き出し
    creFile($txt, $Dir . "search_key.csv", "a");
    creFile($txt, $Dir . "search_key.txt", "a");
    
    // 右下？
    $_ed_x = $v["pos_x"];
    $_ed_y = $v["pos_y"];

    // 左上？
    $_st_x = $v["st_pos_x"];
    $_st_y = $v["st_pos_y"];

    // フォントの大きさ？
    $_fnt = $v["_fontsize"];

    // 幅？
    $_w = $v["_width"];

    // 画像の変換率に合わせて テキスト幅
    $w =  ( $_w / 72 * 192 );

    //
    $x_px =  $_ed_x / 72 * 192;
    $y_px =  $_ed_y / 72 * 192;

    $st_x_px =  $_st_x / 72 * 192;
    $st_y_px =  $_st_y / 72 * 192;

    $f_px =  $_fnt / 72 * 192;

    $top = ( $h_A4 - $y_px - $f_px ) * $MyTekitouConv;
    $left = ( $st_x_px ) * $MyTekitouConv;
    // $width =  ( $x_px - $st_x_px + $w )  * $MyTekitouConv;
    $width =  ( $w )  * $MyTekitouConv;
    $height = ( $f_px ) * $MyTekitouConv;

    $_x = (int)$left;
    $_y = (int)$top;
    $_x2 = (int)($left + $width);
    $_y2 = (int)($top + $height);

    $pos = "{$_x};{$_y};{$_x2};{$_y2};{$Page}\r\n";
    creFile($pos, $Dir . "search_pnt.csv" , "a");
    creFile($pos, $Dir . "search_pnt.txt" , "a");
  }

  // リターン
  return $ret;
}


// ====================================
// ■ My関数 : PDFLib Data 作成
//      [ dir ] : 保存パス
//      [ page ]
//      [ data ]
// ====================================
function myPDFLibXmlSearchKey($args){

  // 初期化
  $ret = "";
  $Dir = $args["dir"];
  $Page = $args["page"];
  $Data = $args["data"];

  // 処理
  // XML生成
  $XML = "";

  foreach($Data as $_d){

    $XML .= implode("\t",$_d);
    $XML .= "\n";
  }

  // ファイル書き出し
  creFile($XML,$Dir."PDFLib".$Page.".xml");

  // リターン
  return $ret;
}

// ====================================
// ■ My関数 : Build.xml 作成
//      [ dir ] : 保存パス
//      [ maxpage ] : ページ数 ( 1ベースカウント )
// ====================================
function myEBookLinkDataParamXml($args){

  // 初期化
  $ret = "";
  $Dir = $args["dir"];
  $MaxPage = $args["maxpage"];
  $No = $args["no"];
  $PageName = "EBookLinkDataParam_".sprintf("%04d", $No).".xml";// ファイル名

  // 処理
  $BuildXml = '<?xml version="1.0" encoding="UTF-8"?>
<EBookRoot>
  <!-- PageData Link Parameter -->
  <PageDataCount>'.$MaxPage.'</PageDataCount>
  <LinkDataPageBlock PageNo="'.$No.'" />
</EBookRoot>';

  // ファイル書き出し
  creFile($BuildXml,$Dir.$PageName);

  // リターン
  return $ret;
}


// EBookLinkDataParamXml Make Test
function myEBookLinkDataParamXmlOnLink($args, $link_list){

    // 初期化
    $ret = "";
    $exp_dir = $args["dir"]; // Export Directory
    $pdf_maxpage = $args["maxpage"]; // PDF MaxPage
    $page_no = $args["no"] + 1; // PDF PageNumber
    $pdf_w = $args["pdf_w"];
    $pdf_h = $args["pdf_h"];
    $file_name = "EBookLinkDataParam_".sprintf("%04d", $page_no).".xml"; // XML FileName
    $url_list = $link_list["url_list"]; // Link Url
    $rect_list = $link_list["rect_list"]; // Link Point

    // Link Setting
    //$linkcolor_mouseout = "0080FF";
    //$linkcolor_mouseover = "0080FF";

    //$book_w = 401; 
    //$book_h = 591; 
    $book_w = $args["book_w"];
    $book_h = $args["book_h"];
    $resize = $book_h / $pdf_h; 

    // Make XMLData
    $link_data_xml = "";

    for ($link_cnt = 0; $link_cnt < count($link_list["url_list"]); $link_cnt++) {

    	// 初期化
    	$url_flag = true;
    	$page_unm = 0;
        $_tmp_str_info = array();
    	
    	// Make LinkData
        $point_x = floor($rect_list[$link_cnt * 4] * $resize);
        $point_y = floor((floor($pdf_h) - $rect_list[($link_cnt * 4) + 3]) * $resize);
        $length_x = floor(($rect_list[($link_cnt * 4) + 2] - $rect_list[$link_cnt * 4]) * $resize);
        $length_y = floor(($rect_list[($link_cnt * 4) + 3] - $rect_list[($link_cnt * 4) + 1]) * $resize);

        // URLチェック
        if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url_list[$link_cnt])) {

        	// URLではない場合
        	$url_flag = false;
        	
        	// ページ数が入っている前提でページ数を取り出す
        	$_tmp_str_info = explode("/", $url_list[$link_cnt]);
        	$page_num = $_tmp_str_info[count($_tmp_str_info) - 1];
        }

        // XML put
        $link_data_xml .= '    <LinkData>' . "\n";

        if ($url_flag === true) {
            $link_data_xml .= '      <LinkURLFlag>True</LinkURLFlag>' . "\n";
            $link_data_xml .= '      <LinkURL>' . htmlspecialchars($url_list[$link_cnt]) . '</LinkURL>' . "\n";
        } else {
        	$link_data_xml .= '      <LinkURLFlag>False</LinkURLFlag>' . "\n";
        	$link_data_xml .= '      <LinkURL></LinkURL>' . "\n";        	
        }
        $link_data_xml .= '      <LinkTARGET>_blank</LinkTARGET>' . "\n";
        $link_data_xml .= '      <LinkALT></LinkALT>' . "\n";
        $link_data_xml .= '      <LinkAreaFlag>True</LinkAreaFlag>' . "\n";
        $link_data_xml .= '      <LinkImagePath></LinkImagePath>' . "\n";
        $link_data_xml .= '      <LinkAreaXStr>' . $point_x . '</LinkAreaXStr>'."\n";
        $link_data_xml .= '      <LinkAreaYStr>' . $point_y . '</LinkAreaYStr>'."\n";
        $link_data_xml .= '      <LinkAreaXLen>' . $length_x . '</LinkAreaXLen>'."\n";
        $link_data_xml .= '      <LinkAreaYLen>' . $length_y . '</LinkAreaYLen>'."\n";
        $link_data_xml .= '      <LinkAreaMouseOutColor>' . LINK_COLOR_MOUSE_OUT . '</LinkAreaMouseOutColor>' . "\n";
        $link_data_xml .= '      <LinkAreaMouseOutTransparent>' . LINK_TRANSPARENT_MOUSE_OUT . '</LinkAreaMouseOutTransparent>' . "\n";
        $link_data_xml .= '      <LinkAreaMouseOverColor>' . LINK_COLOR_MOUSE_OVER . '</LinkAreaMouseOverColor>' . "\n";
        $link_data_xml .= '      <LinkAreaMouseOverTransparent>' . LINK_TRANSPARENT_MOUSE_OVER . '</LinkAreaMouseOverTransparent>' . "\n";
        $link_data_xml .= '      <LinkPopupFlag>False</LinkPopupFlag>' . "\n";
        $link_data_xml .= '      <LinkPopupHeight>100</LinkPopupHeight>' . "\n";
        $link_data_xml .= '      <LinkPopupWidth>100</LinkPopupWidth>' . "\n";
        $link_data_xml .= '      <LinkPage>' . $page_num . '</LinkPage>' . "\n";
        $link_data_xml .= '      <LinkAreaMouseOutOutLineColor>' . LINK_LINE_COLOR_MOUSE_OUT . '</LinkAreaMouseOutOutLineColor>' . "\n";
        $link_data_xml .= '      <LinkAreaMouseOutOutLineWidth>' . LINK_LINE_WIDTH_MOUSE_OUT . '</LinkAreaMouseOutOutLineWidth>' . "\n";
        $link_data_xml .= '      <LinkAreaMouseOverOutLineColor>' . LINK_LINE_COLOR_MOUSE_OVER . '</LinkAreaMouseOverOutLineColor>' . "\n";
        $link_data_xml .= '      <LinkAreaMouseOverOutLineWidth>' . LINK_LINE_WIDTH_MOUSE_OVER . '</LinkAreaMouseOverOutLineWidth>' . "\n";
        $link_data_xml .= '      <LinkHighlight></LinkHighlight>' . "\n";
        $link_data_xml .= '    </LinkData>';
    }

    $build_xml = '<?xml version="1.0" encoding="UTF-8"?>
<EBookRoot>
  <!-- PageData Link Parameter -->
  <PageDataCount>' . $pdf_maxpage . '</PageDataCount>
  <LinkDataPageBlock PageNo="' . $page_no . '">
'. $link_data_xml . '
  </LinkDataPageBlock>
</EBookRoot>';

    creFile($build_xml, $exp_dir . $file_name);

}


// ====================================
// ■ My関数 : EBookSetBaseParam.xml 作成
//      [ dir ] : 保存パス
//      [ PageActionCover ]
//      [ PageActionEndCover ]
// ====================================
function myEBookSetBaseParamXml($args){

  // 初期化
  $ret = "";
  $Dir = $args["dir"];
  $GenponUrl = $args["genpon_url"];
  $PageActionCover = $args["PageActionCover"];
  $PageActionEndCover = $args["PageActionEndCover"];
  $PageAction = (empty($args["PageAction"]))? 2 : $args["PageAction"] ;
  $spell = $args["spell"];

  // <PageAction>'.$PageAction.'</PageAction>
  // <PageActionCover>'.$PageActionCover.'</PageActionCover>
  // <PageActionEndCover>'.$PageActionEndCover.'</PageActionEndCover>



  // 処理
  $Xml = '﻿<?xml version="1.0" encoding="UTF-8"?>
<EBookRoot>
  <ProgramParam>
    <!-- Program Version -->
    <ProgramVersion>2.7.001</ProgramVersion>
    <!-- Program Defauld Full Path -->
    <ProgramPath></ProgramPath>
    <!-- Data Defauld Full Path -->
    <DataPath></DataPath>
    <DBBookProject>False</DBBookProject>
    <SpecificationProjectName>
    </SpecificationProjectName>
  </ProgramParam>
  <!-- 設定タブ　選択パラメータ -->
  <SETEnvParam>
    <!-- ページめくり -->
    <SETEnvPage>
      <!-- ページめくりアクション選択 -->
      <!-- 1:右とじ  2:左とじ  3:上めくり  4:下めくり  5:右スライド  6:左スライド -->
      <PageAction>' . $spell . '</PageAction>
      <!-- 連続めくり -->
      <PageActionContinuousness>True</PageActionContinuousness>
      <!-- めくりアクション中にページを歪ませる -->
      <PageActionAnimation>False</PageActionAnimation>
      <!-- ページめくりのタイミング 紙面をクリック -->
      <PageTimmingPaper>True</PageTimmingPaper>
      <!-- ページめくりのタイミング ボタンをクリック -->
      <PageTimmingButton>True</PageTimmingButton>
      <!-- ページめくりのタイミング ←→キーを押下 -->
      <PageTimmingRLKey>False</PageTimmingRLKey>
      <!-- ページめくりのタイミング 自動ページめくり -->
      <PageTimmingAutoPage>True</PageTimmingAutoPage>
      <!-- ページめくりのタイミング 自動ページめくり 秒数 -->
      <PageTimmingAutoPageSec>0</PageTimmingAutoPageSec>
      <!-- ページめくりの速さ -->
      <PageSpeed>19</PageSpeed>
      <!-- 開始ページ番号表示 ページ番号表示 -->
      <PageDisp>False</PageDisp>
      <!-- 開始ページ番号表示 開始ページ -->
      <PageDispStartPage>2</PageDispStartPage>
      <!-- 開始ページ番号表示 開始番号 -->
      <PageDispStartCont>1</PageDispStartCont>
      <!-- 開始ページ番号表示 色番号 -->
      <PageDispColor>000000</PageDispColor>
      <!-- 表紙の対向ページを非表示 -->
      <PageActionCover>' . $PageActionCover . '</PageActionCover>
      <!-- 裏表紙の対向ページを非表示 -->
      <PageActionEndCover>' . $PageActionEndCover . '</PageActionEndCover>
      <!-- ページめくり時に音を鳴らす -->
      <PageActionSound>False</PageActionSound>
      <!-- ページめくり時に音を鳴らす (サウンドファイル名) -->
      <PageActionSoundFileName>pageflip.mp3</PageActionSoundFileName>
      <!-- ページ端のめくれるアニメーション -->
      <PageActionBothEndsAnimation>False</PageActionBothEndsAnimation>
      <!-- ページ端のめくれるアニメーション (アイコン名:左) -->
      <PageActionBothEndsAnimationLFileName>PageFlip-L_icon.swf</PageActionBothEndsAnimationLFileName>
      <!-- ページ端のめくれるアニメーション (アイコン名:右) -->
      <PageActionBothEndsAnimationRFileName>PageFlip-R_icon.swf</PageActionBothEndsAnimationRFileName>
      <!-- ページ番号表示位置(上端) -->
      <PageDispPageTop>10</PageDispPageTop>
      <!-- ページ番号表示位置(両端) -->
      <PageDispPageSide>10</PageDispPageSide>
      <!-- ページ番号表示(フォントサイズ) -->
      <PageDispFontSize>10</PageDispFontSize>
      <PageStartPage>0</PageStartPage>
      <PageStartPageEditFlag>0</PageStartPageEditFlag>
    </SETEnvPage>
    <!-- インデックス -->
    <SETEnvIndex>
      <!-- インデックスの有無 -->
      <!-- True:インデックス有 -->
      <!-- False:インデックス無 -->
      <IndexEnabled>False</IndexEnabled>
      <!-- インデックスのアクション選択 -->
      <!-- 1:フレーム内に埋込む。 -->
      <!-- 2:インデックスボタン押すとポップアップする。 -->
      <!-- 3:インデックスボタン押す、または、
             紙面の左端にマウスオーバーするとスライドインする。 -->
      <IndexAction>0</IndexAction>
      <!-- インデックスメニューを押した後のアクション -->
      <!-- 1:メニューを押した後も継続して表示する。 -->
      <!-- 2:メニューを押した後、自動で閉じる。 -->
      <IndexActionAfter>2</IndexActionAfter>
      <!-- インデックスの指定方法 -->
      <!-- 1:デザインで指定する。 -->
      <!-- 2:テキストで指定する。 -->
      <IndexKindDesign>2</IndexKindDesign>
      <VisIndexEnabled>True</VisIndexEnabled>
      <VisIndexAction>2</VisIndexAction>
      <VisIndexActionAfter>2</VisIndexActionAfter>
    </SETEnvIndex>
    <!-- 検索 -->
    <SETEnvSearch>
      <!-- 検索の有無 -->
      <!-- True:検索有 -->
      <!-- False:検索無 -->
      <SearchEnabled>False</SearchEnabled>
      <!-- 検索のアクション選択 -->
      <!-- X:フレーム内に埋込む。 -->
      <!-- 1:検索ボタン押すとポップアップする。 -->
      <!-- 2:検索ボタン押す、または、
             紙面の左端にマウスオーバーするとスライドインする。 -->
      <SearchAction>0</SearchAction>
      <!-- 検索メニューを押した後のアクション -->
      <!-- 1:メニューを押した後も継続して表示する。 -->
      <!-- 2:メニューを押した後、自動で閉じる。 -->
      <SearchActionAfter>2</SearchActionAfter>
      <SearchALLEnabled>True</SearchALLEnabled>
      <SearchALLAction>2</SearchALLAction>
      <SearchALLActionAfter>2</SearchALLActionAfter>
      <SearchFullText>True</SearchFullText>
      <SearchNumber>False</SearchNumber>
      <SearchName>False</SearchName>
    </SETEnvSearch>
    <!-- 拡大・縮小 -->
    <SETEnvZoom>
      <!-- 基本設定 -->
      <!-- 基本設定 拡大回数 -->
      <ZoomInCount>2</ZoomInCount>
      <!-- 基本設定 紙面全体拡大 -->
      <ZoomAll>True</ZoomAll>
      <!-- 拡大時の全画面表示 -->
      <!-- 1:全画面表示しない -->
      <!-- 2:全画面表示する -->
      <PageAction>' . $spell . '</PageAction>
      <!-- 拡大時の全画面表示 全画面表示のタイミング -->
      <PageActionTimming>2</PageActionTimming>
      <!-- 拡大時のツール -->
      <!-- ナビゲート機能 -->
      <ZoomNavi>True</ZoomNavi>
      <!-- ページめくり機能 -->
      <ZoomPage>False</ZoomPage>
      <!-- 上下左右スクロール機能 -->
      <Zoom4>True</Zoom4>
      <!-- 中央８方向スクロール機能 -->
      <Zoom9>False</Zoom9>
      <!-- 拡大倍率(200%) -->
      <ZoomZoomScale02>False</ZoomZoomScale02>
      <!-- 拡大倍率(400%) -->
      <ZoomZoomScale03>True</ZoomZoomScale03>
      <!-- 拡大倍率(600%) -->
      <ZoomZoomScale04>False</ZoomZoomScale04>
      <!-- 拡大倍率(800%) -->
      <ZoomZoomScale05>False</ZoomZoomScale05>
      <!-- 拡大倍率(1000%) -->
      <ZoomZoomScale06>True</ZoomZoomScale06>
    </SETEnvZoom>
    <!-- 付箋・メモ帳機能 -->
    <SETEnvMemo>
      <!-- 付箋設定 -->
      <!-- 付箋設定 設定数 -->
      <MemoNoteCount>10</MemoNoteCount>
      <!-- 付箋設定 ローカル保存機能 -->
      <MemoNoteSave>True</MemoNoteSave>
      <!-- 付箋設定 色数 -->
      <MemoNoteColor>10</MemoNoteColor>
      <!-- 付箋設定 ページ数 -->
      <MemoPage>True</MemoPage>
      <!-- 付箋設定 ページ数コメント1 -->
      <MemoPageText1>goto </MemoPageText1>
      <!-- 付箋設定 ページ数コメント2 -->
      <MemoPageText2>page.</MemoPageText2>
      <!-- 付箋設定 テキスト -->
      <MemoText>True</MemoText>
      <!-- 付箋設定 サムネイル -->
      <MemoThumbnail>True</MemoThumbnail>
      <!-- 付箋設定 任意テキスト -->
      <MemoFreeText>True</MemoFreeText>
      <!-- メモ帳設定 -->
      <!-- メモ帳設定 設定数 -->
      <MemoMemoCount>0</MemoMemoCount>
      <!-- メモ帳設定 ローカル保存機能 -->
      <MemoMemoSave>True</MemoMemoSave>
      <!-- メモ帳設定 色数 -->
      <MemoMemoColor>5</MemoMemoColor>
      <!-- メモ帳設定 情報配信機能（管理者・閲覧者） -->
      <MemoMemoInfo>False</MemoMemoInfo>
    </SETEnvMemo>
    <!-- 印刷 -->
    <SETEnvPrint>
      <!-- 印刷設定 -->
      <!-- 印刷設定 品質 -->
      <PrintKind>標準品質</PrintKind>
      <!-- 印刷設定 PDFから印刷機能 -->
      <PrintPDF>False</PrintPDF>
      <!-- 印刷設定 PDFから印刷機能 Path -->
      <PrintPDFPath>
      </PrintPDFPath>
      <!-- 印刷設定 PDFから印刷機能 PDFファイル名 -->
      <PrintPDFFiles>
      </PrintPDFFiles>
      <!-- 表示設定 -->
      <!-- 1:印刷コンボボックス -->
      <!-- 2:印刷ボタン -->
      <!-- 3:印刷ボタン　→　ダイアログ -->
      <PrintDisp>3</PrintDisp>
    </SETEnvPrint>
    <!-- 出力型式 -->
    <SETEnvOutput>
      <!-- HTMLタイトル -->
      <OutputHTMLTitle></OutputHTMLTitle>
      <!-- ビュワーの選択 -->
      <!-- 1:実行ファイル形式 -->
      <!-- 2:FLASHビューワー -->
      <!-- 3:JAVAビューワー -->
      <OutputViewer>2</OutputViewer>
      <!-- 出力品質(JPEGの圧縮率) -->
      <OutputJPGQualty>100</OutputJPGQualty>
      <!-- ターゲット -->
      <!-- 1:CDROM -->
      <!-- 2:WEB -->
      <OutputTarget>2</OutputTarget>
      <!-- コンテンツセキュリティ 1:キャプチャー  2:CDROMコピー -->
      <!-- 1:キャプチャー -->
      <!-- 2:CDROMコピー -->
      <OutputSecurity>2</OutputSecurity>
      <!-- ローディング・メッセージ -->
      <OutputLoadingMsg>デジタルブックを読み込んでいます。</OutputLoadingMsg>
      <OutputLoadingBackColor>FFFFFF</OutputLoadingBackColor>
      <OutputCatalogName>
      </OutputCatalogName>
      <OutputCatalogNameURLEnc>
      </OutputCatalogNameURLEnc>
      <OutputCatalogTitle></OutputCatalogTitle>
      <OutputPrintScreen>False</OutputPrintScreen>
      <OutputHighQualityPrint>False</OutputHighQualityPrint>
      <OutputMediaID>
      </OutputMediaID>
    </SETEnvOutput>
    <!-- マウスクリック -->
    <SETEnvMouse>
      <!-- 左クリック -->
      <!-- ページめくり -->
      <MouseLPage>True</MouseLPage>
      <!-- 右クリック -->
      <!-- ページめくり -->
      <MouseRPage>False</MouseRPage>
      <!-- 拡大縮小 -->
      <MouseRZoom>False</MouseRZoom>
      <!-- 付箋 -->
      <MouseRNote>False</MouseRNote>
      <!-- 印刷 -->
      <MouseRPrint>False</MouseRPrint>
    </SETEnvMouse>
    <SETEnvFunction>
      <FunctionCapture>True</FunctionCapture>
      <FunctionPDFPrint>True</FunctionPDFPrint>
      <FunctionCatalog>True</FunctionCatalog>
      <FunctionWebNative>True</FunctionWebNative>
      <FunctionKeepFactor>True</FunctionKeepFactor>
      <FunctionCatalogList>True</FunctionCatalogList>
      <FunctionPenTool>True</FunctionPenTool>
      <FunctionPageEdgePicked>True</FunctionPageEdgePicked>
    </SETEnvFunction>
  </SETEnvParam>
  <!-- レイアウトタブ　選択パラメータ -->
  <LayoutParam>
    <!-- 全体デザイン -->
    <LayoutALL>
      <!-- 全体画像 通常時 -->
      <ImageNorm>skin.jpg</ImageNorm>
      <!-- 全体画像 マウスオーバー時 -->
      <ImageMouseOver>skin.jpg</ImageMouseOver>
    </LayoutALL>
    <!-- インデックス -->
    <LayoutIndex>
      <!-- 全体画像 通常時 -->
      <ImageNorm>
      </ImageNorm>
      <!-- 全体画像 マウスオーバー時 -->
      <ImageMouseOver>
      </ImageMouseOver>
      <!-- 全体画像(Bild時にImageDIRにコピー) 通常時 -->
      <BildIndexLaouyImageNorm>
      </BildIndexLaouyImageNorm>
      <!-- 全体画像(Bild時にImageDIRにコピー) マウスオーバー時 -->
      <BildIndexLaouyImageNormMouseOver>
      </BildIndexLaouyImageNormMouseOver>
    </LayoutIndex>
    <!-- 全画面表示操作パネルデザイン -->
    <LayoutFullScreen>
      <!-- 全画面表示操作パネル画像 通常時 -->
      <ImageNorm>
      </ImageNorm>
      <!-- 全画面表示操作パネル画像 マウスオーバー時 -->
      <ImageMouseOver>
      </ImageMouseOver>
    </LayoutFullScreen>
    <!-- 全体デザイン 背景 -->
    <LayoutBack>
      <LayoutBackData No="1">
        <ImageNameMouseOut>LayoutBackMouseOut1.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>187</ImageXLen>
        <ImageYLen>17</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="2">
        <ImageNameMouseOut>LayoutBackMouseOut2.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>187</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>806</ImageXLen>
        <ImageYLen>17</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="3">
        <ImageNameMouseOut>LayoutBackMouseOut3.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>993</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>17</ImageXLen>
        <ImageYLen>17</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="4">
        <ImageNameMouseOut>LayoutBackMouseOut4.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>17</ImageYStr>
        <ImageXLen>187</ImageXLen>
        <ImageYLen>601</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="5">
        <ImageNameMouseOut>LayoutBackMouseOut5.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>993</ImageXStr>
        <ImageYStr>17</ImageYStr>
        <ImageXLen>17</ImageXLen>
        <ImageYLen>601</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="6">
        <ImageNameMouseOut>LayoutBackMouseOut6.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>618</ImageYStr>
        <ImageXLen>187</ImageXLen>
        <ImageYLen>17</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="7">
        <ImageNameMouseOut>LayoutBackMouseOut7.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>187</ImageXStr>
        <ImageYStr>618</ImageYStr>
        <ImageXLen>806</ImageXLen>
        <ImageYLen>17</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="8">
        <ImageNameMouseOut>LayoutBackMouseOut8.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>993</ImageXStr>
        <ImageYStr>618</ImageYStr>
        <ImageXLen>17</ImageXLen>
        <ImageYLen>17</ImageYLen>
      </LayoutBackData>
      <LayoutBackData No="9">
        <ImageNameMouseOut>LayoutBackMouseOut9.swf</ImageNameMouseOut>
        <ImageNameMouseOver>
        </ImageNameMouseOver>
        <ImageXStr>187</ImageXStr>
        <ImageYStr>17</ImageYStr>
        <ImageXLen>806</ImageXLen>
        <ImageYLen>601</ImageYLen>
      </LayoutBackData>
    </LayoutBack>
    <!-- 拡大時の設定 -->
    <LayoutZoom>
      <!-- 拡大ボックス -->
      <!-- 塗りつぶし -->
      <ZoomPaintColor>808080</ZoomPaintColor>
      <ZoomPaintTransparent>30</ZoomPaintTransparent>
      <!-- 線 -->
      <ZoomLineColor>5D5D5D</ZoomLineColor>
      <ZoomLineWidth>2 pix</ZoomLineWidth>
      <!-- ナビゲートボックス -->
      <!-- 大きさ -->
      <ZoomNaviXLen>170</ZoomNaviXLen>
      <ZoomNaviYLen>130</ZoomNaviYLen>
      <!-- 表示位置 -->
      <!-- 0:表示しない -->
      <!-- 1:左上に表示 -->
      <!-- 2:左下に表示 -->
      <!-- 3:右上に表示 -->
      <!-- 4:右下に表示 -->
      <ZoomNaviPosition>3</ZoomNaviPosition>
      <!-- 線 -->
      <ZoomNaviColor>5D5D5D</ZoomNaviColor>
      <ZoomNaviWidth>3 pix</ZoomNaviWidth>
    </LayoutZoom>
    <!-- 付箋・メモの設定 -->
    <LayoutMemo>
      <!-- チップ色設定 -->
      <!-- 背景 -->
      <NoteBackColor>FFFF80</NoteBackColor>
      <NoteBackTransparent>246</NoteBackTransparent>
      <!-- 枠 -->
      <NoteLineColor>5D5D5D</NoteLineColor>
      <NoteLineWidth>1 pix</NoteLineWidth>
      <!-- 文字 -->
      <NoteTextColor>5D5D5D</NoteTextColor>
      <!-- 付箋の太さ -->
      <NoteWidth>20 pix</NoteWidth>
      <!-- 付箋の色 -->
      <NoteColor01>C00000</NoteColor01>
      <NoteColor02>C0C000</NoteColor02>
      <NoteColor03>FFFF00</NoteColor03>
      <NoteColor04>00C000</NoteColor04>
      <NoteColor05>8080FF</NoteColor05>
      <NoteColor06>0000FF</NoteColor06>
      <NoteColor07>804000</NoteColor07>
      <NoteColor08>FFC0C0</NoteColor08>
      <NoteColor09>FFFFC0</NoteColor09>
      <NoteColor10>FFFF80</NoteColor10>
      <NoteColor11>C0FFC0</NoteColor11>
      <NoteColor12>C0FFFF</NoteColor12>
      <NoteColor13>C0C0FF</NoteColor13>
      <NoteColor14>FFC0FF</NoteColor14>
      <NoteColor15>404040</NoteColor15>
      <!-- メモ帳 -->
      <!-- タイトル -->
      <MemoTitle>メモ帳一覧</MemoTitle>
      <!-- タイトルバー -->
      <MemoTitleBarColor>5D5D5D</MemoTitleBarColor>
      <!-- タイトル文字 -->
      <MemoTitleTextColor>FFFFFF</MemoTitleTextColor>
      <!-- 文字 -->
      <MemoCharColor>5D5D5D</MemoCharColor>
      <!-- メモの色 -->
      <MemoColor01>FFFFC0</MemoColor01>
      <MemoColor02>C0FFC0</MemoColor02>
      <MemoColor03>C0FFFF</MemoColor03>
      <MemoColor04>C0C0FF</MemoColor04>
      <MemoColor05>FFC0FF</MemoColor05>
      <MemoBodyInitDefText>入力して下さい。</MemoBodyInitDefText>
      <MemoBodyResize>False</MemoBodyResize>
      <MemoBodyMiniX>0</MemoBodyMiniX>
      <MemoBodyMiniY>0</MemoBodyMiniY>
      <MemoBodyBodyTransparent>246</MemoBodyBodyTransparent>
      <MemoBodyMiniIconTransparent>246</MemoBodyMiniIconTransparent>
      <PenColor01>68E468</PenColor01>
      <PenColor02>7FCEFF</PenColor02>
      <PenColor03>1F6AFF</PenColor03>
      <PenColor04>963FFF</PenColor04>
      <PenColor05>FF7FAD</PenColor05>
      <PenColor06>FF495F</PenColor06>
      <PenColor07>FFA81F</PenColor07>
      <PenColor08>BF6700</PenColor08>
      <PenColor09>5D5D5D</PenColor09>
      <PenColor10>000000</PenColor10>
    </LayoutMemo>
    <!-- 紙面内ボタンの設定 -->
    <LayoutPButton>
      <!-- ページめくりボタン -->
      <!-- 戻る Normal -->
      <PButtonPageRevN>Layout_PButton_RevN.png</PButtonPageRevN>
      <!-- 戻る MouseOver -->
      <PButtonPageRevM>Layout_PButton_RevM.png</PButtonPageRevM>
      <!-- 次へ Normal -->
      <PButtonPageNextN>Layout_PButton_NextN.png</PButtonPageNextN>
      <!-- 次へ MouseOver -->
      <PButtonPageNextM>Layout_PButton_NextM.png</PButtonPageNextM>
      <!-- 上下左右４方向移動ボタン -->
      <!-- 上方向 Normal -->
      <PButtonVect4UpN>Layout_PButton_UpN.png</PButtonVect4UpN>
      <!-- 上方向 MouseOver -->
      <PButtonVect4UpM>Layout_PButton_UpM.png</PButtonVect4UpM>
      <!-- 下方向 Normal -->
      <PButtonVect4DownN>Layout_PButton_DownN.png</PButtonVect4DownN>
      <!-- 下方向 MouseOver -->
      <PButtonVect4DownM>Layout_PButton_DownM.png</PButtonVect4DownM>
      <!-- 左方向 Normal -->
      <PButtonVect4LeftN>Layout_PButton_LeftN.png</PButtonVect4LeftN>
      <!-- 左方向 MouseOver -->
      <PButtonVect4LeftM>Layout_PButton_LeftM.png</PButtonVect4LeftM>
      <!-- 右方向 Normal -->
      <PButtonVect4RightN>Layout_PButton_RightN.png</PButtonVect4RightN>
      <!-- 右方向 MouseOver -->
      <PButtonVect4RightM>Layout_PButton_RightM.png</PButtonVect4RightM>
      <!-- 中央表示８方向移動ボタン -->
      <!-- ８方向 Normal -->
      <PButtonVect8N>Layout_PButton_Vict8RoundN.png</PButtonVect8N>
      <!-- ８方向 MouseOver -->
      <PButtonVect8M>Layout_PButton_Vict8RoundM.png</PButtonVect8M>
    </LayoutPButton>
    <!-- 検索ウィンドウの設定 -->
    <LayoutSearch>
      <!-- 検索ウィンドウの色設定 -->
      <!-- タイトル -->
      <SearchTitle>検索・Title</SearchTitle>
      <!-- タイトルバー -->
      <SearchTitleBarColor>5D5D5D</SearchTitleBarColor>
      <!-- タイトル文字 -->
      <SearchTitleTextColor>5D5D5D</SearchTitleTextColor>
      <!-- 背景 -->
      <SearchBackColor>EFEFEF</SearchBackColor>
      <!-- 文字 -->
      <SearchCharColor>5D5D5D</SearchCharColor>
      <!-- 外部ファィルの読込 -->
      <!-- ファィルパス -->
      <SearchImportPath>
      </SearchImportPath>
    </LayoutSearch>
    <!-- インデックスウィンドウの設定 -->
    <LayoutIndexWin>
      <!-- ウィンドウの色設定 -->
      <!-- タイトル -->
      <IndexWinTitle>もくじ</IndexWinTitle>
      <!-- タイトルバー -->
      <IndexWinTitleBarColor>5D5D5D</IndexWinTitleBarColor>
      <!-- タイトル文字 -->
      <IndexWinTitleTextColor>5D5D5D</IndexWinTitleTextColor>
      <!-- 背景 -->
      <IndexWinBackColor>EFEFEF</IndexWinBackColor>
      <!-- 文字 -->
      <IndexWinCharColor>5D5D5D</IndexWinCharColor>
      <!-- 外部ファィルの読込 -->
      <!-- ファィルパス -->
      <IndexWinImportPath>
      </IndexWinImportPath>
    </LayoutIndexWin>
    <!-- 全画面表示操作パネル背景色の設定 -->
    <LayoutFullScreenCtrl>
      <!-- 操作パネル背景色 -->
      <FullScreenCtrlBackColor>5D5D5D</FullScreenCtrlBackColor>
      <!-- 全体背景色 -->
      <FullScreenHTMLBackColor>000000</FullScreenHTMLBackColor>
    </LayoutFullScreenCtrl>
    <!-- ビジュアルインデックスウィンドウの設定 -->
    <LayoutVisIndex>
      <!-- ウィンドウの色設定 -->
      <!-- タイトル -->
      <VisIndexTitle>ページ一覧</VisIndexTitle>
      <!-- タイトル文字 -->
      <VisIndexTitleTextColor>5D5D5D</VisIndexTitleTextColor>
      <!-- 背景 -->
      <VisIndexBackColor>EFEFEF</VisIndexBackColor>
      <!-- 文字 -->
      <VisIndexCharColor>5D5D5D</VisIndexCharColor>
    </LayoutVisIndex>
    <!-- 全体デザイン 紙面枠 -->
    <DesignPaper>
      <!-- 紙面枠 Topの位置 (X座標) -->
      <ImageXStr>58</ImageXStr>
      <!-- 紙面枠 Topの位置 (Y座標) -->
      <ImageYStr>12</ImageYStr>
      <!-- 紙面枠 大きさ (X座標) -->
      <ImageXLen>894</ImageXLen>
      <!-- 紙面枠 大きさ (Y座標) -->
      <ImageYLen>570</ImageYLen>
      <!-- イメージ 通常時 -->
      <ImageMouseOut>ALLDesignPaper_MouseOut.jpg</ImageMouseOut>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignPaper_MouseOver.jpg</ImageMouseOver>
    </DesignPaper>
    <!-- 全体デザイン 拡大枠 -->
    <DesignFrame>
      <!-- 検索表示位置 Topの位置 (X座標) -->
      <ImageXStr>58</ImageXStr>
      <!-- 検索表示位置 Topの位置 (Y座標) -->
      <ImageYStr>12</ImageYStr>
      <!-- 検索表示位置 大きさ (X座標) -->
      <ImageXLen>894</ImageXLen>
      <!-- 検索表示位置 大きさ (Y座標) -->
      <ImageYLen>570</ImageYLen>
    </DesignFrame>
    <!-- 全体デザイン 右ページめくりボタン -->
    <DesignPageR>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>94</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>159</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>76</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignPageR_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignPageR_MouseOver.swf</ImageMouseOver>
    </DesignPageR>
    <!-- 全体デザイン 左ページめくりボタン -->
    <DesignPageL>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>17</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>159</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>76</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignPageL_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignPageL_MouseOver.swf</ImageMouseOver>
    </DesignPageL>
    <!-- 全体デザイン 自動ページめくりボタン -->
    <DesignAutoPage>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignAutoPage_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignAutoPage_MouseOver.jpg</ImageMouseOver>
    </DesignAutoPage>
    <!-- 全体デザイン 自動ページめくりボタン(戻る) -->
    <DesignAutoPageBack>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignAutoPageBack_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignAutoPageBack_MouseOver.jpg</ImageMouseOver>
    </DesignAutoPageBack>
    <!-- 全体デザイン 拡大ボタン -->
    <DesignZoomIn>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>94</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>241</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>76</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignZoomIn_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignZoomIn_MouseOver.swf</ImageMouseOver>
    </DesignZoomIn>
    <!-- 全体デザイン 縮小ボタン -->
    <DesignZoomOut>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignZoomOut_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignZoomOut_MouseOver.jpg</ImageMouseOver>
    </DesignZoomOut>
    <!-- 全体デザイン 再読込(拡大解除)ボタン -->
    <DesignReload>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>17</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>241</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>76</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignReload_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignReload_MouseOver.swf</ImageMouseOver>
    </DesignReload>
    <!-- 全体デザイン 印刷ボタン -->
    <DesignPrint>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>17</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>400</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>76</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignPrint_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignPrint_MouseOver.swf</ImageMouseOver>
      <!-- 印刷ボタン種別 -->
      <!-- 0:左ページ印刷 -->
      <!-- 1:右ページ印刷 -->
      <!-- 2:両ページ印刷 -->
      <!-- 3:全ページ印刷 -->
      <!-- 4:プルダウンメニュー -->
      <!-- 5:印刷ダイアログ表示 -->
      <PrintKind>4</PrintKind>
      <PrintPullDownL>True</PrintPullDownL>
      <PrintPullDownR>True</PrintPullDownR>
      <PrintPullDownLR>True</PrintPullDownLR>
      <PrintPullDownAll>True</PrintPullDownAll>
      <PrintHighQualityPrint>False</PrintHighQualityPrint>
    </DesignPrint>
    <!-- 全体デザイン ヘルプボタン -->
    <DesignHelp>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>17</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>482</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>153</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>28</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignHelp_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignHelp_MouseOver.swf</ImageMouseOver>
      <HelpAutoMakeFlag>False</HelpAutoMakeFlag>
    </DesignHelp>
    <!-- 全体デザイン ヘルプイメージ -->
    <DesignHelpImage>
      <!-- ヘルプファイル名 -->
      <ImageFileName>help.jpg</ImageFileName>
      <!-- ヘルプファイルの大きさ (幅) -->
      <ImageSizeX>150</ImageSizeX>
      <!-- ヘルプファイルの大きさ (高さ) -->
      <ImageSizeY>150</ImageSizeY>
    </DesignHelpImage>
    <!-- 全体デザイン インデックスボタン -->
    <DesignIndex>
      <DesignIndexData No="0">
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>0</ImageXLen>
        <ImageYLen>0</ImageYLen>
        <ImageKind>0</ImageKind>
        <ImageNormLoadFlag>True</ImageNormLoadFlag>
        <ImageNorm>ALLDesignIndex_MouseOut_000.jpg</ImageNorm>
        <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
        <ImageMouseOver>ALLDesignIndex_MouseOver_000.jpg</ImageMouseOver>
        <IndexNumb>0</IndexNumb>
        <IndexKind>0</IndexKind>
      </DesignIndexData>
    </DesignIndex>
    <!-- 全体デザイン 目次表示位置 -->
    <DesignIndexPos>
      <!-- 目次表示位置 Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- 目次表示位置 Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 目次表示位置 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 目次表示位置 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
    </DesignIndexPos>
    <!-- 全体デザイン リンクボタン -->
    <DesignLink>
    </DesignLink>
    <!-- 全体デザイン Gotoボタン -->
    <DesignGoto>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>94</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>125</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>28</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignGoto_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignGoto_MouseOver.swf</ImageMouseOver>
    </DesignGoto>
    <!-- 全体デザイン GotoTextボタン -->
    <DesignGotoText>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>23</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>130</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>63</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>16</ImageYLen>
      <!-- GotoText 色 -->
      <TextColor>808080</TextColor>
    </DesignGotoText>
    <!-- 全体デザイン スライダーボタン -->
    <DesignSlid>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>
      </ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>
      </ImageMouseOver>
      <!-- イメージ つまみ 通常時 -->
      <ImageSwitchNorm>
      </ImageSwitchNorm>
      <!-- イメージ つまみ マウスオーバー時 -->
      <ImageSwitchMouseOver>
      </ImageSwitchMouseOver>
      <ImageFontSize>10</ImageFontSize>
      <ImageNormBackColor1>EFEFEF</ImageNormBackColor1>
      <ImageNormBackColor2>5D5D5D</ImageNormBackColor2>
      <ImageSwitchBackColor1>EFEFEF</ImageSwitchBackColor1>
      <ImageSwitchBackColor2>5D5D5D</ImageSwitchBackColor2>
    </DesignSlid>
    <!-- 全体デザイン 検索ボタン -->
    <DesignSearch>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>13</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>222</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>43</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>107</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignSearch_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignSearch_MouseOver.jpg</ImageMouseOver>
    </DesignSearch>
    <!-- 全体デザイン 検索表示位置 -->
    <DesignSearchPos>
      <!-- 検索表示位置 Topの位置 (X座標) -->
      <ImageXStr>79</ImageXStr>
      <!-- 検索表示位置 Topの位置 (Y座標) -->
      <ImageYStr>12</ImageYStr>
      <!-- 検索表示位置 大きさ (X座標) -->
      <ImageXLen>335</ImageXLen>
      <!-- 検索表示位置 大きさ (Y座標) -->
      <ImageYLen>593</ImageYLen>
    </DesignSearchPos>
    <!-- 全体デザイン 付箋左右ボタン -->
    <DesignNoteLR>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>17</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>323</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>76</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignNoteLR_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignNoteLR_MouseOver.swf</ImageMouseOver>
    </DesignNoteLR>
    <!-- 全体デザイン 付箋左ボタン -->
    <DesignNoteL>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>
      </ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>
      </ImageMouseOver>
    </DesignNoteL>
    <!-- 全体デザイン 付箋右ボタン -->
    <DesignNoteR>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>
      </ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>
      </ImageMouseOver>
    </DesignNoteR>
    <!-- 全体デザイン メモボタン -->
    <DesignMemo>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignMemo_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignMemo_MouseOver.jpg</ImageMouseOver>
    </DesignMemo>
    <!-- 全体デザイン メモ表示位置 -->
    <DesignMemoPos>
      <!-- メモ表示位置 Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- メモ表示位置 Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- メモ表示位置 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- メモ表示位置 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
    </DesignMemoPos>
    <!-- 全体デザイン 閉じるボタン -->
    <DesignClose>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignClose_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignClose_MouseOver.jpg</ImageMouseOver>
    </DesignClose>
    <!-- 全体デザイン ページ数 -->
    <DesignPageNumber>
      <!-- ページ数 Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- ページ数 Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- ページ数 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- ページ数 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- ページ数 色 -->
      <TextColor>525252</TextColor>
    </DesignPageNumber>
    <!-- 全体デザイン ペンツールボタン -->
    <DesignPen>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignPen_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignPen_MouseOver.jpg</ImageMouseOver>
    </DesignPen>
    <!-- 全体デザイン 全画面表示ボタン -->
    <DesignFullScreen>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignFullScreen_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignFullScreen_MouseOver.jpg</ImageMouseOver>
    </DesignFullScreen>
    <!-- Indexデザイン インデックスボタン -->
    <IndexDesignIndex>
    </IndexDesignIndex>
    <!-- Indexデザイン リンクボタン -->
    <IndexDesignLink>
    </IndexDesignLink>
    <!-- Indexデザイン 閉じるボタン -->
    <IndexDesignClose>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>
      </ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>
      </ImageMouseOver>
    </IndexDesignClose>
    <!-- 全体デザイン ビジュアル目次ボタン -->
    <DesignVIndex>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>94</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>323</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>76</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>76</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignVisIndex_MouseOut.swf</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignVisIndex_MouseOver.swf</ImageMouseOver>
    </DesignVIndex>
    <!-- 全体デザイン ビジュアル目次表示位置 -->
    <DesignVIndexPos>
      <!-- メモ表示位置 Topの位置 (X座標) -->
      <ImageXStr>187</ImageXStr>
      <!-- メモ表示位置 Topの位置 (Y座標) -->
      <ImageYStr>17</ImageYStr>
      <!-- メモ表示位置 大きさ (X座標) -->
      <ImageXLen>185</ImageXLen>
      <!-- メモ表示位置 大きさ (Y座標) -->
      <ImageYLen>601</ImageYLen>
    </DesignVIndexPos>
    <!-- 全体デザイン ページめくり 最初のページへボタン -->
    <DesignGotoStartPage>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignGotoStrPage_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignGotoStrPage_MouseOver.jpg</ImageMouseOver>
    </DesignGotoStartPage>
    <!-- 全体デザイン ページめくり 最後のページへボタン -->
    <DesignGotoEndPage>
      <!-- Topの位置 (X座標) -->
      <ImageXStr>0</ImageXStr>
      <!-- Topの位置 (Y座標) -->
      <ImageYStr>0</ImageYStr>
      <!-- 大きさ (X座標) -->
      <ImageXLen>0</ImageXLen>
      <!-- 大きさ (Y座標) -->
      <ImageYLen>0</ImageYLen>
      <!-- イメージ種別 -->
      <!-- 0:範囲指定 -->
      <!-- 1:イメージ -->
      <ImageKind>0</ImageKind>
      <!-- イメージ 通常時 別ファィル指定フラッグ -->
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <!-- イメージ 通常時 -->
      <ImageNorm>ALLDesignGotoEndPage_MouseOut.jpg</ImageNorm>
      <!-- イメージ マウスオーバー時 別ファィル指定フラッグ -->
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <!-- イメージ マウスオーバー時 -->
      <ImageMouseOver>ALLDesignGotoEndPage_MouseOver.jpg</ImageMouseOver>
    </DesignGotoEndPage>
    <LayoutPenTool>
      <ImageNorm>PenToolDesignBack_MouseOut.png</ImageNorm>
      <ImageMouseOver>PenToolDesignBack_MouseOver.png</ImageMouseOver>
      <ImageSizeX>431</ImageSizeX>
      <ImageSizeY>98</ImageSizeY>
    </LayoutPenTool>
    <LayoutMemoToolPanel>
      <ImageNorm>MemoToolPanelDesignBack_MouseOut.png</ImageNorm>
      <ImageMouseOver>MemoToolPanelDesignBack_MouseOver.png</ImageMouseOver>
      <ImageSizeX>391</ImageSizeX>
      <ImageSizeY>141</ImageSizeY>
    </LayoutMemoToolPanel>
    <LayoutMemoToolBody>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOver>
      </ImageMouseOver>
      <ImageSizeX>0</ImageSizeX>
      <ImageSizeY>0</ImageSizeY>
    </LayoutMemoToolBody>
    <LayoutMemoBodyBack>
      <LayoutMemoBodyBackData No="1">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut1.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="2">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut2.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="3">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut3.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="4">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut4.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="5">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut5.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="6">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut6.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="7">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut7.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="8">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut8.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
      <LayoutMemoBodyBackData No="9">
        <MemoBodyImageNameMouseOut>LayoutMemoBodyBackMouseOut9.jpg</MemoBodyImageNameMouseOut>
        <MemoBodyImageNameMouseOver>
        </MemoBodyImageNameMouseOver>
        <ImageXStr>0</ImageXStr>
        <ImageYStr>0</ImageYStr>
        <ImageXLen>1</ImageXLen>
        <ImageYLen>1</ImageYLen>
      </LayoutMemoBodyBackData>
    </LayoutMemoBodyBack>
    <LayoutSearchALL>
      <SearchTitle>文字検索</SearchTitle>
      <SearchTitleBarColor>5D5D5D</SearchTitleBarColor>
      <SearchTitleTextColor>5D5D5D</SearchTitleTextColor>
      <SearchBackColor>EFEFEF</SearchBackColor>
      <SearchCharColor>5D5D5D</SearchCharColor>
      <SearchImportPath>
      </SearchImportPath>
    </LayoutSearchALL>
    <DesignSearchALL>
      <ImageXStr>94</ImageXStr>
      <ImageYStr>400</ImageYStr>
      <ImageXLen>76</ImageXLen>
      <ImageYLen>76</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>ALLDesignSearchALL_MouseOut.swf</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>ALLDesignSearchALL_MouseOver.swf</ImageMouseOver>
    </DesignSearchALL>
    <DesignSearchALLPos>
      <ImageXStr>187</ImageXStr>
      <ImageYStr>17</ImageYStr>
      <ImageXLen>335</ImageXLen>
      <ImageYLen>601</ImageYLen>
    </DesignSearchALLPos>
    <DesignCapture>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </DesignCapture>
    <DesignHistBK>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </DesignHistBK>
    <DesignHistFF>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </DesignHistFF>
    <DesignPDFPrint>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </DesignPDFPrint>
    <DesignCatalog>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </DesignCatalog>
    <PenToolDesignClose>
      <ImageXStr>399</ImageXStr>
      <ImageYStr>14</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignClose_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignClose_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignClose>
    <PenToolDesignALLHide>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </PenToolDesignALLHide>
    <PenToolDesignWidthS>
      <ImageXStr>216</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignWidthS_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignWidthS_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignWidthS>
    <PenToolDesignWidthM>
      <ImageXStr>247</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignWidthM_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignWidthM_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignWidthM>
    <PenToolDesignWidthL>
      <ImageXStr>278</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignWidthL_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignWidthL_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignWidthL>
    <PenToolDesignLine>
      <ImageXStr>27</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignLine_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignLine_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignLine>
    <PenToolDesignRect>
      <ImageXStr>57</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignRect_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignRect_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignRect>
    <PenToolDesignOval>
      <ImageXStr>88</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignOval_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignOval_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignOval>
    <PenToolDesignPencil>
      <ImageXStr>118</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignPencil_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignPencil_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignPencil>
    <PenToolDesignDelete>
      <ImageXStr>149</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignDelete_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignDelete_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignDelete>
    <PenToolDesignALLDelete>
      <ImageXStr>180</ImageXStr>
      <ImageYStr>50</ImageYStr>
      <ImageXLen>32</ImageXLen>
      <ImageYLen>32</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignALLDelete_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignALLDelete_MouseOver.jpg</ImageMouseOver>
    </PenToolDesignALLDelete>
    <DesignPenToolColor01>
      <ImageXStr>315</ImageXStr>
      <ImageYStr>51</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor01_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor01_MouseOver.jpg</ImageMouseOver>
      <Color>68E468</Color>
    </DesignPenToolColor01>
    <DesignPenToolColor02>
      <ImageXStr>331</ImageXStr>
      <ImageYStr>51</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor02_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor02_MouseOver.jpg</ImageMouseOver>
      <Color>7FCEFF</Color>
    </DesignPenToolColor02>
    <DesignPenToolColor03>
      <ImageXStr>346</ImageXStr>
      <ImageYStr>51</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor03_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor03_MouseOver.jpg</ImageMouseOver>
      <Color>1F6AFF</Color>
    </DesignPenToolColor03>
    <DesignPenToolColor04>
      <ImageXStr>362</ImageXStr>
      <ImageYStr>51</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor04_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor04_MouseOver.jpg</ImageMouseOver>
      <Color>963FFF</Color>
    </DesignPenToolColor04>
    <DesignPenToolColor05>
      <ImageXStr>378</ImageXStr>
      <ImageYStr>51</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor05_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor05_MouseOver.jpg</ImageMouseOver>
      <Color>FF7FAD</Color>
    </DesignPenToolColor05>
    <DesignPenToolColor06>
      <ImageXStr>315</ImageXStr>
      <ImageYStr>67</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor06_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor06_MouseOver.jpg</ImageMouseOver>
      <Color>FF495F</Color>
    </DesignPenToolColor06>
    <DesignPenToolColor07>
      <ImageXStr>331</ImageXStr>
      <ImageYStr>67</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor07_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor07_MouseOver.jpg</ImageMouseOver>
      <Color>FFA81F</Color>
    </DesignPenToolColor07>
    <DesignPenToolColor08>
      <ImageXStr>346</ImageXStr>
      <ImageYStr>67</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor08_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor08_MouseOver.jpg</ImageMouseOver>
      <Color>BF6700</Color>
    </DesignPenToolColor08>
    <DesignPenToolColor09>
      <ImageXStr>362</ImageXStr>
      <ImageYStr>67</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor09_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor09_MouseOver.jpg</ImageMouseOver>
      <Color>5D5D5D</Color>
    </DesignPenToolColor09>
    <DesignPenToolColor10>
      <ImageXStr>378</ImageXStr>
      <ImageYStr>67</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>PenToolDesignColor10_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>PenToolDesignColor10_MouseOver.jpg</ImageMouseOver>
      <Color>000001</Color>
    </DesignPenToolColor10>
    <MemoToolPanelDesignClose>
      <ImageXStr>362</ImageXStr>
      <ImageYStr>15</ImageYStr>
      <ImageXLen>16</ImageXLen>
      <ImageYLen>16</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignClose_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignClose_MouseOver.jpg</ImageMouseOver>
    </MemoToolPanelDesignClose>
    <MemoToolPanelDesignALLHide>
      <ImageXStr>249</ImageXStr>
      <ImageYStr>79</ImageYStr>
      <ImageXLen>108</ImageXLen>
      <ImageYLen>19</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignALLHide_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignALLHide_MouseOver.jpg</ImageMouseOver>
    </MemoToolPanelDesignALLHide>
    <MemoToolPanelDesignALLDelete>
      <ImageXStr>249</ImageXStr>
      <ImageYStr>101</ImageYStr>
      <ImageXLen>108</ImageXLen>
      <ImageYLen>19</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignALLDelete_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignALLDelete_MouseOver.jpg</ImageMouseOver>
    </MemoToolPanelDesignALLDelete>
    <MemoToolPanelDesignMemoList>
      <ImageXStr>249</ImageXStr>
      <ImageYStr>57</ImageYStr>
      <ImageXLen>108</ImageXLen>
      <ImageYLen>19</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignMemoList_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignMemoList_MouseOver.jpg</ImageMouseOver>
    </MemoToolPanelDesignMemoList>
    <DesignMemoToolPanelColor01>
      <ImageXStr>35</ImageXStr>
      <ImageYStr>91</ImageYStr>
      <ImageXLen>40</ImageXLen>
      <ImageYLen>31</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignColor01_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignColor01_MouseOver.jpg</ImageMouseOver>
      <Color>FFFFC0</Color>
    </DesignMemoToolPanelColor01>
    <DesignMemoToolPanelColor02>
      <ImageXStr>76</ImageXStr>
      <ImageYStr>91</ImageYStr>
      <ImageXLen>40</ImageXLen>
      <ImageYLen>31</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignColor02_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignColor02_MouseOver.jpg</ImageMouseOver>
      <Color>C0FFC0</Color>
    </DesignMemoToolPanelColor02>
    <DesignMemoToolPanelColor03>
      <ImageXStr>117</ImageXStr>
      <ImageYStr>91</ImageYStr>
      <ImageXLen>40</ImageXLen>
      <ImageYLen>31</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignColor03_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignColor03_MouseOver.jpg</ImageMouseOver>
      <Color>C0FFFF</Color>
    </DesignMemoToolPanelColor03>
    <DesignMemoToolPanelColor04>
      <ImageXStr>158</ImageXStr>
      <ImageYStr>91</ImageYStr>
      <ImageXLen>40</ImageXLen>
      <ImageYLen>31</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignColor04_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignColor04_MouseOver.jpg</ImageMouseOver>
      <Color>C0C0FF</Color>
    </DesignMemoToolPanelColor04>
    <DesignMemoToolPanelColor05>
      <ImageXStr>199</ImageXStr>
      <ImageYStr>91</ImageYStr>
      <ImageXLen>40</ImageXLen>
      <ImageYLen>31</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>True</ImageNormLoadFlag>
      <ImageNorm>MemoToolPanelDesignColor05_MouseOut.jpg</ImageNorm>
      <ImageMouseOverLoadFlag>True</ImageMouseOverLoadFlag>
      <ImageMouseOver>MemoToolPanelDesignColor05_MouseOver.jpg</ImageMouseOver>
      <Color>FFC0FF</Color>
    </DesignMemoToolPanelColor05>
    <MemoToolBodyDesignClose>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </MemoToolBodyDesignClose>
    <MemoToolBodyDesignMini>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageKind>0</ImageKind>
      <ImageNormLoadFlag>False</ImageNormLoadFlag>
      <ImageNorm>
      </ImageNorm>
      <ImageMouseOverLoadFlag>False</ImageMouseOverLoadFlag>
      <ImageMouseOver>
      </ImageMouseOver>
    </MemoToolBodyDesignMini>
    <MemoToolBodyDesignMakeDate>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <FontColor>5D5D5D</FontColor>
      <FontSize>10 pt</FontSize>
    </MemoToolBodyDesignMakeDate>
    <MemoToolBodyDesignDocText>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <BackColor>5D5D5D</BackColor>
      <FontColor>5D5D5D</FontColor>
      <FontSize>10 pt</FontSize>
      <BorderColor>5D5D5D</BorderColor>
      <BorderWidth>2 pix</BorderWidth>
    </MemoToolBodyDesignDocText>
    <MemoToolBodyDesignMemoIcon>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageFileName>
      </ImageFileName>
    </MemoToolBodyDesignMemoIcon>
    <MemoToolBodyDesignMiniIcon>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageFileName>
      </ImageFileName>
    </MemoToolBodyDesignMiniIcon>
    <MemoToolBodyDesignResizeIcon>
      <ImageXStr>0</ImageXStr>
      <ImageYStr>0</ImageYStr>
      <ImageXLen>0</ImageXLen>
      <ImageYLen>0</ImageYLen>
      <ImageFileName>
      </ImageFileName>
    </MemoToolBodyDesignResizeIcon>
  </LayoutParam>
</EBookRoot>';

  // ファイル書き出し
  creFile($Xml,$Dir."EBookSetBaseParam.xml");

  // リターン
  return ;
}

// ====================================
// ■ My関数 : book.html 作成
//      [ dir ] : 保存パス
//      [ tit ] : タイトル
// ====================================
function myBookHtml($args){

  // 初期化
  $ret = "";
  $Dir = $args["dir"];
  $Tit = $args["tit"];
  $PageName = "book_swf".".html";// ファイル名

  // 処理
  $BuildXml = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>'.$Tit.'</title>';

  $BuildXml .= <<<EOF
<script src="scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<!-- DRM OFF -->
<link rel="stylesheet" href="css/default.css" type="text/css" />
</head>
<body bgcolor="#FFFFFF" onLoad="initWindow()" onResize="resizeWindow()">
<div class="crawler">
    <p>SAMPLE規程</p>
    <p>ページ&nbsp;
</p>
</div>
<script type="text/javascript">

AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','1010','height','655 ','align','middle','src','book','FlashVars','000000','loop','false','menu','true','quality','high','salign','lt','bgcolor','#FFFFFF','allowscriptaccess','sameDomain','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','book' ); //end AC code>>

</script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1010" height="655" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="book.swf" />
<param name="loop" value="false" />
<param name="menu" value="true" />
<param name="quality" value="high" />
<param name="salign" value="lt" />
<param name="bgcolor" value="#FFFFFF" />
<embed src="book.swf" loop="false" menu="true" quality="high" salign="lt" bgcolor="#FFFFFF" width="1010" height="655" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></noscript>
</body>
</html>

EOF;

  // ファイル書き出し
  creFile($BuildXml,$Dir."/".$PageName);
  // リターン
  return $ret;
}

//a.kaneda 2011/07/11
// ===========================================
// ■ My関数 : EBookPageShadowParam.xml 作成
//      [ dir ] :
//      [ tit ] :
// ===========================================
function myEBookPageShadowParam($args,$flag,$size,$PageCnt){

  // 初期化
  $ret = "";
  $Dir = $args;
  $PageName = "EBookPageShadowParam".".xml";// ファイル名
  $i = 0;
  $xml = "";
  $xml_temp = array();


  if (NODO_FLAG == 1 and $size == "Y"){

      for ($i = 0; $i <= $PageCnt;$i++){

          // のどを削除して処理
          $xml_temp[$i] = execEBookPageShadowParamXmlYoko($PageCnt,$i);

      };

      //xmlをつなげる
      $xml = execXmlBind($xml_temp);

  } else {

      // 処理
      for ($i = 0; $i <= $PageCnt;$i++){

          // のどを削除しないで処理
          $xml_temp[$i] = execEBookPageShadowParamXmlTate($PageCnt,$i);

      };

      //xmlをつなげる
      $xml = execXmlBind($xml_temp);


  }

  // ファイル書き出し
  creFile($xml,$Dir."EBookPageShadowParam.xml");

  // リターン
  return;

}
//a.kaneda 2011/07/11
// ===========================================
// ■ exec関数 : myEBookPageShadowParamXmlYoko 作成
//      [ 内容 ] : 縦紙面の場合、紙面ののど削除
//      [ tit ] : タイトル
// ===========================================
function execEBookPageShadowParamXmlYoko($page,$count){

     $xml = "";

     $xml =
         '<!-- Page Shadow Parameter -->
         <PageDataCount>'.$page.'</PageDataCount>
         <PageShadow PageNo="'.$count.'">
           <PageShadowDispFlag>True</PageShadowDispFlag>
           <PageShadowColor>000000</PageShadowColor>
           <PageShadowWidth>20</PageShadowWidth>
           <PageShadowTransparent>0</PageShadowTransparent>
         </PageShadow>'
     ;

     return $xml;

}
//a.kaneda 2011/07/11
// ===========================================
// ■ exec関数 : myEBookPageShadowParamXmlTate 作成
//      [ 内容 ] : 縦紙面の場合、紙面ののどあり
//      [ tit ] : タイトル
// ===========================================
function execEBookPageShadowParamXmlTate($page,$count){

     $xml = "";

     $xml =
         '<!-- Page Shadow Parameter -->
         <PageDataCount>'.$page.'</PageDataCount>
         <PageShadow PageNo="'.$count.'">
           <PageShadowDispFlag>True</PageShadowDispFlag>
           <PageShadowColor>000000</PageShadowColor>
           <PageShadowWidth>20</PageShadowWidth>
           <PageShadowTransparent>30</PageShadowTransparent>
         </PageShadow>'
     ;

     return $xml;

}
//a.kaneda 2011/07/11
// ===========================================
// ■ exec関数 : execXmlBind 作成
//      [ 内容 ] : XMLのヘッダとフッタを結ぶ
//      [ tit ] : タイトル
// ===========================================
function execXmlBind($xml_temp){

      //xmlをつなげる

      $xml_header = '<?xml version="1.0" encoding="UTF-8"?>
         <EBookRoot>';
      $xml_footer = '</EBookRoot>';
      $xml = implode(" ",$xml_temp);

      $xml =$xml_header.$xml.$xml_footer;

      return $xml;
}
?>