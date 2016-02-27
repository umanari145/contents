$(function(){

	$("#search_box").click(function(){
		var actionUrl = "http://localhost/contents/items/index/keyword:";
		var keyword =$("#input_keyword_box").val();
		actionUrl += keyword;
		$("#keyword_form").attr('action', actionUrl);
	})
});
