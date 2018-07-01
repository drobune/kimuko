(function() {
	tinymce.create('tinymce.plugins.pzlinkcard', {
		init: function(ed, url){
			ed.addButton('pz_linkcard',{
				title: 'リンクカード作成',
				image: url + '/button.png',
				cmd: 'insert_pz_linkcard'
			});
			ed.addCommand('insert_pz_linkcard', function() {
				var insert_tag = window.prompt('リンクカードを作成するURLを入力してください', 'http://');
				if (insert_tag !== null) {
					ed.execCommand('mceInsertContent', 0, '[blogcard url="' + insert_tag + '"]');
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('pz_linkcard',tinymce.plugins.pzlinkcard);
})();