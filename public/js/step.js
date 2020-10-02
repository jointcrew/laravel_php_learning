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
    //プラン選択時、対応した説明を表示させる
    $('#plan_type').on('change', function(){
        //同じcategory_idの種別を取得
        $.ajax({
            url: '/api/step', //データベースを繋げるファイル
            type:"POST",
            data:{
                plan_id: $(this).val(),
                flag: 'category_id' //選択されたデータ取得
            }
        }).done(function(data){
            console.log(data);
            var fee = data['response'][0]['plan_fee'];
            var description = data['response'][0]['description'];
            //前結果の表示を削除
             $('#plan_fee ').empty();
             $('#plan_discription ').empty();
            // //画面に表示
             $("#plan_fee").append(fee);
             $("#plan_discription").append(description);
        }).fail(function(data) {
            alert("error"); //通信失敗時
        });
    });
});
