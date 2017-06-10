$(function(){
	var siteUrl = $("#site_url_id").val();

	$("#search_box").click(function(){
        var actionUrl = siteUrl + "items/index/keyword:";
		var keyword =$("#input_keyword_box").val();
		actionUrl += keyword;
		$("#keyword_form").attr('action', actionUrl);
	})


	$("#add_favorite").click(function(){

		var itemId = $("#item_id").val();

		var data = {'item_id':itemId};

		$.ajax({
            type : "POST",
            async:false,
            data: data,
            url: siteUrl +'users/isLoginCheck',
            success:function( res ){
            	if( res === 'fail') {
            	    //ログインしていない場合はセッションに登録して、ログイン画面に飛ばす
                    window.location.href = siteUrl + 'users/login'
            	}else if( res === 'success' ) {
            		window.location.reload();
            	}
            },
            error:function(){

            }

        });
	});

	$("#delete_favorite").click(function(){

		var itemId = $("#item_id").val();

		var data = {'item_id':itemId};

		$.ajax({
            type : "POST",
            async: false,
            data: data,
            url: siteUrl +'users/deleteFavoriteItem',
            success:function( res ){
            	if( res === 'success') {
            		window.location.reload();
            	}
            },
            error:function(){

            }

        });
	});

	$('.contents_block').infinitescroll({
        navSelector : '.navigation',
        nextSelector : '.navigation a',
        itemSelector :'.index_contents_area',
        loading: {
            msg: null,
            msgText: "<strong>動画ページを読み込んでいます。</strong>"
          },
	});
});
