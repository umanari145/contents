$(function(){

	var siteUrl = $("#site_url_id").val();
    $(".resize").click(function(){
        var buttonElementId = $(this).attr("id");

        var dataSize ={
            'width': "",
            'height':""
        };

        switch( buttonElementId ){
            case 'large_size':
                dataSize['width']  = 640;
                dataSize['height'] = 480;
                break;
            case 'middle_size':
                dataSize['width']  = 448;
                dataSize['height'] = 336;
                break;
            case 'small_size':
                dataSize['width']  = 256;
                dataSize['height'] = 192;
                break;
            default:
                break;
        }

        if( dataSize['width'] !== "" && dataSize['height'] !== "" ) {
            $.ajax({
                type : "POST",
                async:false,
                data:dataSize,
                url: siteUrl +'items/updateMovieSize',
                success:function( data ){
                    if( data !== undefined && data !== "" && data ==="success" ) {
                        window.location.reload();
                    }
                },
                error:function(){

                }

            });
        }
    })
});
