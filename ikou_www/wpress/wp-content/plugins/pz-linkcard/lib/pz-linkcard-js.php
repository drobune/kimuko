<?php if (!function_exists("get_option")) die; ?>
<?php
	$temp_file	= $this->plugin_dir_path.'templete/mce-pz-lkc-templete.js';
	$js_file	= $this->plugin_dir_path.'js/mce-pz-lkc.js';

	$file_text = file_get_contents($temp_file);
	if ($file_text) {
		$file_text = str_replace('/*TITLE*/',	__('Insert Pz-LinkCard', $this->text_domain),	$file_text );
		$file_text = str_replace('/*PROMPT*/',	__('Input URL', $this->text_domain),			$file_text );
		$file_text = str_replace('/*CODE*/',	$this->options['code1'],						$file_text );

		$result = file_put_contents($js_file, $file_text );
		global $pagenow;
		if (isset($pagenow) && $pagenow == 'options-general.php') {
			if ($result == true) {
				echo '<div class="updated fade"><p><strong>'.__('Editor button JS saved.', $this->text_domain).'</strong></p></div>';
			} else {
				echo '<div class="error fade"><p><strong>'.__('Editor button JS failed.', $this->text_domain).'</strong></p></div>';
			}
		}
	}
	unset($temp_file);
	unset($js_file);
	unset($file_text);
	unset($result);
