// 遅延処理
$(function(){
    //document.getElementById("t1").innerHTML = "Hello world!!";
    //チェックボックス(userid)情報をモーダルに渡す
    $('#Modal').on('show.bs.modal', function (event) {
        const arr = [];
	    const summary = document.getElementsByName("summary");

    	for (let i = 0; i < summary.length; i++){
    		if(summary[i].checked){ //(summary[i].checked === true)と同じ
    			arr.push(summary[i].value);
    		}
    	}
        document.getElementById( "user_id" ).value = arr ;
	});

    //モーダル検索ボタン
    $('#form_buttum').click(function() {
		var category    = $('#category').val();
		var goods_name  = $('#goods_name').val();
		var price_start = $('#price_start').val();
		var price_end   = $('#price_end').val();
		var date_start  = $('#date_start').val();
		var date_end    = $('#date_end').val();
        var user_id     = $('#user_id').val();

		// HTMLでの送信をキャンセル
        event.preventDefault();

        // 送信
        $.ajax({
            url: 'api/api_goodsuser',
            type: 'GET',
			dataType: "json",
            data: { // 送信するデータ
					category: category,
					goods_name: goods_name,
					price_start: price_start,
					price_end: price_end,
					date_start: date_start,
					date_end: date_end,
                    user_id: user_id,
				  },
	    }).done(function(data) {
	  		// 通信成功時の処理
            console.log(data);
            //再検索の際、前検索結果を削除する(タイトル以外削除)
            while( table.rows[ 1 ] ) table.deleteRow( 1 );

            $.each(data['response']['original']['names'], function(user_id,user_name) {

                //購入履歴なし
                $('#table').append(
                   '<tr><td>'+
                   user_name+
                   '</td><td>'+
                   '-'+
                   '</td><td>'+
                   '-'+
                   '</td><td>'+
                   '-'+
                   '</td><td>'+
                   '-'+
                   '</td><td>'+
                   '-'+
                   '</td></tr>'
                );

                $.each(data['response']['original'][user_id], function(property, value) {
                    $('#table').append(
                       '<tr><td>'+
                       data['response']['original'][user_id][property]['name']+
                       '</td><td>'+
                       data['response']['original'][user_id][property]['goods_name']+
                       '</td><td>'+
                       data['response']['original'][user_id][property]['purchase_number']+
                       '</td><td>'+
                       data['response']['original'][user_id][property]['total_price']+
                       '</td><td>'+
                       data['response']['original'][user_id][property]['discount_price']+
                       '</td><td>'+
                       data['response']['original'][user_id][property]['created_at']+
                       '</td></tr>'
                    );
                });
            });

	  	}).always(function(data) {
	  		// 常に実行する処理
	  		$("#modalForm").modal('hide'); // モーダルを閉じる
	  	});
    });
});
