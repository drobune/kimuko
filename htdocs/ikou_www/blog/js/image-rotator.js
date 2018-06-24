$(document).ready(function(){
	
	//This keeps track of the slideshow's current location
	var current_panel = 1;
	//Controlling the duration of animation by variable will simplify changes
	var animation_duration = 2200;
	
	$.timer(3000, function (timer) {
		//Determine the current location, and transition to next panel
		switch(current_panel){
			case 1:
				$("#slideshow").stop().animate({left: "-454px", top: "0px"});
				current_panel = 2;
			break;
			case 2:
				$("#slideshow").stop().animate({left: "0px", top: "-130px"}, {easing: 'easeOutBack', duration: animation_duration});
				current_panel = 3;
			break;
			case 3:
				$("#slideshow").stop().animate({left: "0px", top: "0px"});
				current_panel = 1;
				break;
//			case 4:
//				$("#slideshow").stop().animate({left: "0px", top: "0px"}, {easing: 'easeOutBack', duration: animation_duration});
//				current_panel = 1;
//			break;	
	  		timer.reset(24000);
		}
	});
	
});