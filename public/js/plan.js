$(function(){

    //プラン登録
    $('#regist').click(function() {
        $.ajax({
            url: '/api/plan', //データベースを繋げるファイル
            type:"POST",
            data:{
                plan_name: $('#plan_name').val(),
                plan_fee: $('#plan_fee').val(),
                description: $('#description').val(),
            }
        }).done(function(data){
            //保存データを表に追加
            $('#tbl1').append("<tr id=rowNo" + (data['response']['id']) +"><td>"+ (data['response']['id']) +'</td><td>' + (data['response']['plan_name']) +'</td><td>'+ (data['response']['plan_fee']) +'</td><td>' + (data['response']['description']) +'</td></tr>');
        }).fail(function(data) {
            alert("error"); //通信失敗時
        });
    });

    //プラン削除
    $('#delete').click(function() {
        $.ajax({
            url: '/api/plan/' +  $('#id').val(), //データベースを繋げるファイル
            type:"POST",
            data:{
                id: $('#id').val(),
                "_method": "DELETE"
            }
        }).done(function(data){
            console.log(data);
            var number = $('#id').val();
            $("#rowNo" + number).remove();
        }).fail(function(data) {
            alert("error"); //通信失敗時
        });
    });
});
