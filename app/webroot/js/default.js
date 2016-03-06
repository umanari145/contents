$(function(){

	$("#search_box").click(function(){
		var siteUrl = $("#site_url_id").val();
        var actionUrl = siteUrl + "items/index/keyword:";
		var keyword =$("#input_keyword_box").val();
		actionUrl += keyword;
		$("#keyword_form").attr('action', actionUrl);
	})
});
