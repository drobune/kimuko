// TEXTAREA や INPUT の初期値をクリックで消す
// http://gmr.blog.shinobi.jp/Entry/527/

// 名称が思い浮かばない、ClearDefaultValue とか長すぎる。
// なぜか「説明」という意味の、Description を略して、Des になった。

function setupDes() {
	// 種付け作業
	var textarea = document.getElementsByTagName("textarea");
	for (i = 0; i < textarea.length; i++) {
		if (textarea[i].className.search("nodes") < 0) {
			if (textarea[i].value == textarea[i].defaultValue) {textarea[i].className += " ondes"; }
			textarea[i].onfocus = function() {offDes(this); }
			textarea[i].onblur = function() {onDes(this); }
		}
	}
	var input = document.getElementsByTagName("input");
	for (i = 0; i < input.length; i++) {
		if ((input[i].className.search("nodes") < 0) && ((input[i].getAttribute("type") == "text")||(input[i].getAttribute("type") == null))) {
			if (input[i].value == input[i].defaultValue) {input[i].className += " ondes"; }
			input[i].onfocus = function() {offDes(this); }
			input[i].onblur = function() {onDes(this); }
		}
	}
	return;
}

function offDes(from) {
	if (from.className.search("ondes") < 0) {return 0;}
	from.className = from.className.replace(/ondes/, "");
	from.value = "";
	return 1;
}
function onDes(from) {
	if (from.value != "") {return 0;}
	from.className += " ondes";
	from.value = from.defaultValue;
	return 1;
}