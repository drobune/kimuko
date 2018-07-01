package MT::Plugin::FS_Template;

use strict;
use MT::Plugin;
@MT::Plugin::FS_Template::ISA = qw(MT::Plugin);

use vars qw($PLUGIN_NAME $VERSION);
$PLUGIN_NAME = 'FS_Template';
$VERSION = '1.11';

use MT;
my $plugin = new MT::Plugin::FS_Template({
    name => $PLUGIN_NAME,
    version => $VERSION,
    description => 'ファーストサーバ テンプレートキング配布。 Movable Type 4 ビジネスサイト・テンプレート・セット',
    author_name => 'ファーストサーバ テンプレートキング',
    author_link => 'http://www.templateking.jp/',
});

MT->add_plugin($plugin);

sub init_registry {
    my $plugin = shift;
    $plugin->registry({
        template_sets => {
            my_set => {
                label => "Firstserver Template",
                base_path => 'templates/',
                base_css => 'themes-base/blog.css',
                order => 1,
                templates => {
                    index => {
                        'main_index' => {
                            label => 'メインページ',
                            outfile => 'index.html',
                            rebuild_me => '1',
                        },
                        'atom' => {
                            label => 'Atom',
                            outfile => 'atom.xml',
                            rebuild_me => '1',
                        },
                        'rsd' => {
                            label => 'RSD',
                            outfile => 'rsd.xml',
                            rebuild_me => '1',
                        },
                        'rss' => {
                            label => 'RSS',
                            outfile => 'rss.xml',
                            rebuild_me => '1',
                        },
                        'archive_index' => {
                            label => 'サイトマップ',
                            outfile => 'sitemap.html',
                            rebuild_me => '1',
                        },
                        'styles' => {
                            label => 'スタイルシート(メイン)',
                            outfile => 'styles.css',
                            rebuild_me => '1',
                        },
                        'javascript' => {
                            label => 'JavaScript',
                            outfile => 'mt.js',
                            rebuild_me => '1',
                        },
                        'free_area_header' => {
                            label => 'フリーエリア ヘッダー',
                            outfile => 'include/free_area_header.txt',
                            rebuild_me => '1',
                        },
                        'free_area_header_main' => {
                            label => 'フリーエリア ヘッダーメイン',
                            outfile => 'include/free_area_header_main.txt',
                            rebuild_me => '1',
                        },
                        'free_area_side' => {
                            label => 'フリーエリア サイド',
                            outfile => 'include/free_area_side.txt',
                            rebuild_me => '1',
                        },
                        'free_area_main' => {
                            label => 'フリーエリア メイン',
                            outfile => 'include/free_area_main.txt',
                            rebuild_me => '1',
                        },
                        'company_summary' => {
                            label => '会社概要',
                            outfile => 'include/company_summary.txt',
                            rebuild_me => '1',
                        },
                    },
                    individual => {
                        'entry' => {
                            label => 'ブログ記事',
                            mappings => {
                                entry_archive => {
                                    archive_type => 'Individual',
                                    file_template => '%c/%f',
                                },
                            },
                        },
                        'page' => {
                            label => 'ウェブページ',
                            mappings => {
                                page_archive => {
                                    archive_type => 'Page',
                                },
                            },
                        },
                    },
                    archive => {
                        'entry_listing' => {
                            label => 'ブログ記事リスト',
                            mappings => {
                                category => {
                                    archive_type => 'Category',
                                },
                            },
                        },
                    },
                    system => {
                        'comment_preview' => {
                            label => 'コメントプレビュー',
                            description_label => '',
                        },
                        'comment_response' => {
                            label => 'コメント完了',
                            description_label => '',
                        },
                        'popup_image' => {
                            label => 'ポップアップ画像',
                            description_label => '',
                        },
                        'search_results' => {
                            label => '検索結果',
                            description_label => '',
                        },
                    },
                    module => {
                        'page_detail' => {
                            label => 'ウェブページの詳細',
                        },
                        'categories' => {
                            label => 'カテゴリ',
                        },
                        'comments' => {
                            label => 'コメント',
                        },
                        'comment_form' => {
                            label => 'コメント入力フォーム',
                        },
                        'comment_detail' => {
                            label => 'コメント詳細',
                        },
                        'sidebar_2col' => {
                            label => 'サイドバー (2カラム)',
                        },
                        'sidebar_3col' => {
                            label => 'サイドバー (3カラム)',
                        },
                        'tags' => {
                            label => 'タグ',
                        },
                        'trackbacks' => {
                            label => 'トラックバック',
                        },
                        'footer' => {
                            label => 'フッター',
                        },
                        'entry_metadata' => {
                            label => 'ブログ記事のメタデータ',
                        },
                        'entry_summary' => {
                            label => 'ブログ記事の概要',
                        },
                        'entry_detail' => {
                            label => 'ブログ記事の詳細',
                        },
                        'header' => {
                            label => 'ヘッダー',
                        },
                    },
                    widget => {
                        'h_sitename_logo' => {
                            label => 'ヘッダー左 サイト名(ロゴ画像)',
                        },
                        'h_sitemap' => {
                            label => 'ヘッダー右 サイトマップ・お問合せリンク',
                        },
                        'h_search' => {
                            label => 'ヘッダー右 検索フォーム',
                        },
                        'h_free_area' => {
                            label => 'ヘッダー右 フリーエリア',
                        },
                        'hm_top_main_image' => {
                            label => 'ヘッダーメイン トップメイン画像',
                        },
                        'hm_free_area' => {
                            label => 'ヘッダーメイン フリーエリア',
                        },
                        'f_footer_menu' => {
                            label => 'フッター フッターメニュー',
                        },
                        'f_copyright' => {
                            label => 'フッター copyright',
                        },
                        's_company_summary' => {
                            label => 'サイド 会社概要',
                        },
                        's_free_area' => {
                            label => 'サイド フリーエリア',
                        },
                        's_main_menu' => {
                            label => 'サイド メインメニュー',
                        },
                        's_rss' => {
                            label => 'サイド rss',
                        },
                        's_search' => {
                            label => 'サイド 検索フォーム',
                        },
                        's_calendar' => {
                            label => 'サイド カレンダー',
                        },
                        's_webpage_list' => {
                            label => 'サイド ウェブページ一覧',
                        },
                        'm_category_archive_list' => {
                            label => 'メイン カテゴリ記事一覧',
                        },
                        'm_free_area' => {
                            label => 'メイン フリーエリア',
                        },
                        'm_main_image' => {
                            label => 'メイン メイン画像',
                        },
                        'm_top_archive' => {
                            label => 'メイン トップ表示記事',
                        },
                        'm_welcome_massege' => {
                            label => 'メイン ウェルカムメッセージ',
                        },
                        'm_new_archive_list' => {
                            label => 'メイン 新着記事一覧',
                        },
                        'meta_description' => {
                            label => 'メタタグ 要約',
                        },
                        'meta_keywords' => {
                            label => 'メタタグ キーワード',
                        },
                    },
                    widgetset => {
                        'ヘッダー左' => {
                            order => 1000,
                            label   => 'ヘッダー左',
                            widgets => [
                            'ヘッダー左 サイト名(ロゴ画像)',
                            ],
                        },
                        'ヘッダー右' => {
                            order => 1000,
                            label   => 'ヘッダー右',
                            widgets => [
                            'ヘッダー右 サイトマップ・お問合せリンク',
                            'ヘッダー右 検索フォーム',
                            ],
                        },
                        'ヘッダーメイン' => {
                            order => 1000,
                            label   => 'ヘッダーメイン',
                            widgets => [
                            'ヘッダーメイン トップメイン画像',
                            ],
                        },
                        'フッター' => {
                            order => 1000,
                            label   => 'フッター',
                            widgets => [
                            'フッター フッターメニュー',
                            'フッター copyright',
                            ],
                        },
                        '2カラム(サイドバー)' => {
                            order => 1000,
                            label   => '2カラム(サイドバー)',
                            widgets => [
                            'サイド メインメニュー',
                            'サイド 会社概要',
                            'サイド rss',
                            ],
                        },
                        '3カラム(サイドバー：左)' => {
                            order => 1000,
                            label   => '3カラム(サイドバー：左)',
                            widgets => [
                            'サイド メインメニュー',
                            'サイド 会社概要',
                            'サイド rss',
                            ],
                        },
                        '3カラム(サイドバー：右)' => {
                            order => 1000,
                            label   => '3カラム(サイドバー：右)',
                            widgets => [
                            ],
                        },
                        'TOPページ：メイン' => {
                            order => 1000,
                            label   => 'TOPページ：メイン',
                            widgets => [
                            'メイン メイン画像',
                            'メイン ウェルカムメッセージ',
                            'メイン カテゴリ記事一覧',
                            'メイン トップ表示記事',
                            'メイン 新着記事一覧',
                            ],
                        },
                        'メタタグ：キーワード' => {
                            order => 1000,
                            label   => 'メタタグ：キーワード',
                            widgets => [
                            'メタタグ キーワード',
                            ],
                        },
                        'メタタグ：要約' => {
                            order => 1000,
                            label   => 'メタタグ：要約',
                            widgets => [
                            'メタタグ 要約',
                            ],
                        },
                    },
                },
            },
        },
    });
}

1;
