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
        console.log(user_id);
		// HTMLでの送信をキャンセル
        event.preventDefault();

        // 操作対象のフォーム要素を取得
        //var $form = $(this);

        // 送信ボタンを取得
        //var $button = $form.find('button');

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

            var data2 = JSON.stringify(data);
				console.log(data2);

            $('#user_name_id').empty();
            $('#goods_name_id').empty();
            $('#purchase_number_id').empty();
            $('#total_price_id').empty();
            $('#discount_price_id').empty();
            $('#created_at_id').empty();

            $.each(data['response'][0][user_id], function(property, value) {
                $('#user_name_id').append(data['response'][0][user_id][property]['name'] + '<br>');
                $('#goods_name_id').append(data['response'][0][user_id][property]['goods_name'] + '<br>');
                $('#purchase_number_id').append(data['response'][0][user_id][property]['purchase_number'] + '<br>');
                $('#total_price_id').append(data['response'][0][user_id][property]['total_price'] + '<br>');
                $('#discount_price_id').append(data['response'][0][user_id][property]['discount_price'] + '<br>');
                $('#created_at_id').append(data['response'][0][user_id][property]['created_at'] + '<br>');
                console.log(property + ':'+value['goods_name']);
                //append複数表示
                 //$('#ttt').append(value + '<br>');
            })

		  	}).always(function(data) {
		  		// 常に実行する処理
		  		$("#modalForm").modal('hide'); // モーダルを閉じる
		  	});
        });
    });



//検索
$("#the-form").click(function() {
    //$('the-form').submit(function(event) {
        alert('ファイルの取得に失敗しました。');


    //});
});
