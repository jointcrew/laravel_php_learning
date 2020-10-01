$(function(){
    //PDF表示時の現在時刻をsessionに保存
    $('#pdf_display').click(function() {
        $.ajax({
            url: '/api/step', //データベースを繋げるファイル
            type:"GET"
        }).done(function(data){
            console.log(data)
        }).fail(function(data) {
            alert("error"); //通信失敗時
        });
    });
});
