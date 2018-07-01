(function($) {
	 $.fn.extend({
		snforcehorizontal: function(options) {
			var opts, self;
			self = $.fn.snforcehorizontal;
		 	opts = $.extend({}, self.default_options, options);
			return $(this).each(function(i, el) {
				self.init(el, opts);
			});
		}
	 });
	$.extend($.fn.snforcehorizontal, {
		default_options: {
			//watch height target element
			target: null,
			//base height
			origin_height: null,
			height_origin: null,
			//this is more element container
			container: null,
			container_origin: null,
			limit_min_width: 0
		},
		init: function(el, opts) {
			opts.target = opts.target || el;
			if(this.getDocumentWidth() > opts.limit_min_width){
				opts.origin_height = this.referenceOriginHeight(el, opts);
				this.horizontalContent(el,opts);
				this.rollbackContainer(el,opts);
			}
			this.arize(el,opts);
			var that = this;
			$(window).bind("resize",function(e){
				that.resizeHandler(e,el,opts);
			});
		},
		arize: function(el,opts){
			if(opts.container && opts.container.children().size() > 0){
				$(opts.container_origin).show()
			}else{
				$(opts.container_origin).hide()
			}
		},
		referenceOriginHeight: function(el,opts){
			return opts.height_origin ? opts.height_origin.outerHeight() : opts.origin_height || $(el.children[0]).outerHeight();
		},
		resizeHandler: function(e,el,opts){
			if(this.getDocumentWidth() > opts.limit_min_width){
				if(opts.origin_height == null || opts.origin_height == undefined){
					opts.origin_height = this.referenceOriginHeight(el, opts);
				}
				$(opts.container_origin).show();
				this.horizontalContent(el,opts);
				this.rollbackContainer(el,opts);
				this.arize(el,opts);
			}else{
				this.rollbackContainer(el,opts,true);
				$(opts.container_origin).hide();
			}
		},
		horizontalContent: function(el,opts){
			while(this.isWrapbreak(opts.target,opts.origin_height)){
				var content = $(el).find("> *:last-child");
				if(opts.container){
					$(opts.container).prepend(content);
				}
			}
		},
		rollbackContainer: function(el,opts,force){
			var that = this;
			$(opts.container).children().each(function(i,content){
				$(el).append(content);
				if(force) return true
				if(that.isWrapbreak(opts.target,opts.origin_height)){
					$(opts.container).prepend(content);
					return false
				}
			});
		},
		isWrapbreak: function(target,origin_height){
			return $(target).innerHeight() > origin_height
		},
		getDocumentWidth: function(){
			return (/WebKit/.test(navigator.userAgent)) ? document.body.clientWidth : document.body.clientWidth + (window.innerWidth - document.body.clientWidth);
		}
	});
}).call(this, jQuery);

