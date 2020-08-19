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
            while( table.rows[ 1 ] ) table.deleteRow( 1 );

            $.each(data['response'][0], function(user_id) {
                $.each(data['response'][0][user_id], function(property, value) {
                    $('#table').append(
                       '<tr><td>'+
                       data['response'][0][user_id][property]['name']+
                       '</td><td>'+
                       data['response'][0][user_id][property]['goods_name']+
                       '</td><td>'+
                       data['response'][0][user_id][property]['purchase_number']+
                       '</td><td>'+
                       data['response'][0][user_id][property]['total_price']+
                       '</td><td>'+
                       data['response'][0][user_id][property]['discount_price']+
                       '</td><td>'+
                       data['response'][0][user_id][property]['created_at']+
                       '</tr>'
                   );
                })
            })

		  	}).always(function(data) {
		  		// 常に実行する処理
		  		$("#modalForm").modal('hide'); // モーダルを閉じる
		  	});
        });
    });
