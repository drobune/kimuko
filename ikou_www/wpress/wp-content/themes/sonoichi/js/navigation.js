(function($){

	$(function(){
		var limit_min_width = 503;

		$(window).bind("resize",function(e){
			redraw();
		});

		redraw();

		function redraw(){
			if(document.body.clientWidth > limit_min_width){
				$(".mod-navGlobal-toggleContent").removeClass("close");
				stripTemplate($(".mod-navGlobal-nav .mod-navGlobal-expansion"));
				applyTemplate();
				bindMouseHoverHandler();
			}else{
				$(".mod-navGlobal-toggleContent").addClass("close");
				stripTemplate($(".mod-navGlobal-nav .mod-navGlobal-expansion"));
				unbindMouseHoverHandler();
			}
		}
		//The root menu will does accordion.
		$(".toggle a").click(function(e){
			if(document.body.clientWidth > limit_min_width && $(this).is(".mod-navGlobal-nav > li.mod-navGlobal-label > span.toggle > a ")){
				return
			}
			e.stopPropagation();
		});


		//This is gp accordion method.
		$(".toggle,.more").click(function(){
			//open and remove toggle
			$(this).parent().snswitchclass("close","open");
			//inactive rogic
			$(this).parents(".children .active").snswitchclass("inactive","active",true);
			if(! /open/.test($(this).parent().attr("class"))){//close
				$(this).parents(".open").not(".current_page_origin").snswitchclass("inactive","active",true);
				forceCloseChildren($(this).parent());
			}else{
				$(this).parent().snswitchclass("inactive","active",true);
			}
		})

		function forceCloseChildren(li){
			$(li).find("> .children .open").addClass("inactive close");
			$(li).find("> .children .open").removeClass("active open");
		}

		//template
		function applyTemplate(){
			if($(".mod-navGlobal-nav .mod-navGlobal-expansion").size() == 0 && $("li.mod-navGlobal-label").size() > 0){
				$(".mod-navGlobal-nav li.mod-navGlobal-label").each(function(i,content){
					var templ = _.template($("#templ-mod-navGlobal-expansion").html(),createContentData(content))
					$(this).append(templ).find(".mod-navGlobal-expansion li:first-child").append($(content).find("> .children"));
				})
			}
			function createContentData(content){
				var content_anchor = $(content).find("> span.toggle a");
				return {
					content_title: $(content_anchor).text(),
					content_url: $(content_anchor).attr("href")
				}
			}
		}

		function stripTemplate(target){
			target.each(function(i,content){
				var child = $(content).find("> li > .children");
				$(content).parent().append(child);
				$(content).remove();
			});
		}

		//The global navigation force horizontal.
		$("#wrapper .mod-navGlobal-toggleContent .mod-navGlobal-nav").snforcehorizontal({
			target:$("#wrapper .mod-navGlobal-toggleContent"),
			height_origin:$("#wrapper .mod-navGlobal-toggleContent .mod-navGlobal-nav > li > a"),
			container:$(".mod-navGlobal-moreList .mod-navGlobal-expansion"),
			container_origin:$(".mod-navGlobal-moreList"),
			limit_min_width: limit_min_width
		});

		//The root accordion menu show only one in the global.
		var othreMenuCloseUnbind = otherMenuClose();
		stripTemplate($(".mod-navGlobal-moreList > li > .mod-navGlobal-expansion .mod-navGlobal-expansion"));
		$(window).bind("resize",function(e){
			othreMenuCloseUnbind();
			othreMenuCloseUnbind = otherMenuClose();
			stripTemplate($(".mod-navGlobal-moreList > li > .mod-navGlobal-expansion .mod-navGlobal-expansion"));
		});

		//The RollOver feature
		var intervalTimer = null;
		var mouseHoverHandler = {
			mouseenter: function(){
				var target;
				if(intervalTimer){
					clearInterval(intervalTimer);
					intervalTimer = null;
				}
				if(/mod-navGlobal-moreList/.test(this.getAttribute("class"))){
					if(/close/.test($(this).children(":first-child").attr("class"))){
						target = $(this).find(".more");
					}
				}else{
					if(/close/.test($(this).attr("class"))){
						target = $(this).find(".toggle:eq(0)");
					}
				}
				if(target){
					target.click();
				}
			},
			mouseleave:function(){
				if(intervalTimer){
					clearInterval(intervalTimer);
					intervalTimer = null;
				}
				var target = $(this).find(".toggle,.more").eq(0)
				if(/open/.test(target.parent().attr("class"))){
					intervalTimer = setInterval(function(){
						target.click();
						clearInterval(intervalTimer);
					},250)
				}
			}
		};

		if(document.body.clientWidth > limit_min_width){
			bindMouseHoverHandler();
		}

		function bindMouseHoverHandler(){
			unbindMouseHoverHandler();
			$("ul.mod-navGlobal-nav > li.mod-navGlobal-label, .mod-navGlobal-moreList").bind(mouseHoverHandler);
		}

		function unbindMouseHoverHandler(){
			$("li.mod-navGlobal-label, .mod-navGlobal-moreList").unbind(mouseHoverHandler);
		}


		function otherMenuClose(){
			var target = $("ul.mod-navGlobal-nav > li.mod-navGlobal-label > span.toggle, li > span.more");
			target.bind("click",onClickMenuHandler);
			return function(){
				target.unbind("click",onClickMenuHandler)
			};

			function onClickMenuHandler(e){
				var that = $(this).parent().get(0);
				$("li.mod-navGlobal-label").add(".mod-navGlobal-moreList > li").each(function(i,sib){
					if(this != that){//other menu is close
						$(sib).removeClass("open");
						$(sib).addClass("close");
						//and children while close
						forceCloseChildren(sib);
					}
				});
			}
		}

		//for smartphone feature.
		//this is menu toggle.
		$(".mod-navGlobal-toggle").click(function(){
			$(".mod-navGlobal-toggleContent").snswitchclass("close","open");
		})
	});

})(jQuery);