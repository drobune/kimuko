(function($) {
	 $.fn.extend({
		snswitchclass: function(_off,_on,_require_off_value) {
			var opts, self;
			self = $.fn.snswitchclass;
		 	opts = $.extend({}, self.default_options, {off:_off,on:_on,require_off_value:_require_off_value || false});
			return $(this).each(function(i, el) {
				self.init(el, opts);
			});
		}
	 });
	$.extend($.fn.snswitchclass, {
		default_options: {
			on: "",
			off: "",
			require_off_value: false
		},
		init: function(el, opts) {
			var on,off;
			on = new RegExp(opts.on);
			off = new RegExp(opts.off);
			if(opts.require_off_value ? off.test($(el).attr("class")) : (off.test($(el).attr("class")) || !on.test($(el).attr("class")))){
				$(el).removeClass(opts.off);
				$(el).addClass(opts.on);
			}else if(on.test($(el).attr("class"))){
				$(el).removeClass(opts.on);
				$(el).addClass(opts.off);
			};
		}
	});
}).call(this, jQuery);

