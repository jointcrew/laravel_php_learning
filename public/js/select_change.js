$(function(){
    //old()または編集時、type_valueを取得して、種別を表示させる処理
    var type_value = $('#type_value').val();
    if (type_value) {
        //同じcategory_idの種別を取得
        $.ajax({
            url: '/api/api_goodsuser', //データベースを繋げるファイル
            type:"POST",
            data:{
                type_value: type_value,
                flag: 'type_value' //選択されたデータ取得
            }
        }).done(function(data){
            //画面に表示
            $("#select_type").append(data['response']);
        }).fail(function(data) {
            alert("error"); //通信失敗時
        });
    };
    //カテゴリ選択時、対応した種別を表示させる
    $('#select_category').on('change', function(){
        //同じcategory_idの種別を取得
        $.ajax({
            url: '/api/api_goodsuser', //データベースを繋げるファイル
            type:"POST",
            data:{
                category: $(this).val(),
                flag: 'category_id' //選択されたデータ取得
            }
        }).done(function(data){
            //前結果の表示を削除
            $('#type ').remove();
            //画面に表示
            $("#select_type").append(data['response']);
        }).fail(function(data) {
            alert("error"); //通信失敗時
        });
    });


});
