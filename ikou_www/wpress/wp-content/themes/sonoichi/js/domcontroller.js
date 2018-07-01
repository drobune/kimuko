(function($){
	$(function(){
		//external link
		$('a[rel~="external"]').click(function(){
			window.open(this.href, '_blank');
			return false;
		});
	});
})(jQuery);