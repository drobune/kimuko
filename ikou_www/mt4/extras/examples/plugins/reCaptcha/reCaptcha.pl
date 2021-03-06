# reCaptcha plugin for Movable Type
# Author: Six Apart (http://www.sixapart.com)
# Released under the Artistic License
#
# $Id: reCaptcha.pl 57867 2007-07-06 07:17:31Z fyoshimatsu $

package MT::Plugin::reCaptcha;

use strict;
use warnings;

use MT;
use base qw(MT::Plugin);

my $plugin = MT::Plugin::reCaptcha->new({
    description => 'CAPTCHA plugin powered by reCaptcha',
    name => 'reCaptcha',
    author_name => 'Six Apart, Ltd.',
    author_link => 'http://www.movabletype.com/',
	system_config_template => <<TMPL,
<dl>
<dt>reCaptcha public key<dt>
<dd><input name="recaptcha_publickey" size="40" /></dd>
<dt>reCaptcha private key<dt>
<dd><input name="recaptcha_privatekey" size="40" /></dd>
</dl>
TMPL
    settings => new MT::PluginSettings([
        ['recaptcha_publickey'],
        ['recaptcha_privatekey'],
    ]),
    version => '0.1',
});

MT->add_plugin($plugin);
sub instance { $plugin }

sub init_registry {
    my $plugin = shift;
    $plugin->registry({
        'captcha_providers' => {
            'sixapart_rc' => {
                'label' => 'reCaptcha',
				'class' => 'reCaptcha',
            },
        },
    });
}

1;
