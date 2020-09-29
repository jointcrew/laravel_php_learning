$(function(){
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
            //再検索の際、前検索結果を削除する(タイトル以外削除)
            while( table.rows[ 1 ] ) table.deleteRow( 1 );
            $("#pagination").empty();

            //購入サマリを表示
            $.each(data['response']['original']['data'], function(property, value) {
                //nullの表示を"-"に変える
                if (data['response']['original']['data'][property]['goods_name'] == null) {
                    $('#table').append(
                        '<tr><td>'+
                        data['response']['original']['data'][property]['name']+
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
                        '</tr>'
                    );
                } else {
                    $('#table').append(
                        '<tr><td>'+
                        data['response']['original']['data'][property]['name']+
                        '</td><td>'+
                        data['response']['original']['data'][property]['goods_name']+
                        '</td><td>'+
                        data['response']['original']['data'][property]['purchase_number']+
                        '</td><td>'+
                        data['response']['original']['data'][property]['total_price']+
                        '</td><td>'+
                        data['response']['original']['data'][property]['discount_price']+
                        '</td><td>'+
                        data['response']['original']['data'][property]['created_at']+
                        '</tr>'
                    );
                }
            });

            //ページネーション処理
            var next_page_url = data['response']['original']['next_page_url'];
            var prev_page_url = data['response']['original']['prev_page_url'];
            var last_page = data['response']['original']['last_page'];
            var page = data['response']['original']['current_page'];
            var total  = data['response']['original']['total'];
            //10個前制御
            if(prev_page_url == null){
                $("#pagination").append("<li class='disabled page-item'><a class='page-link' href=''>«</a></li>");
            }else{
                $("#pagination").append("<li class='active'><a class='page-link' href='/api/api_goodsuser?page="+(page-10)+"'>«</a></li>");
            }
            //Prev 制御
            if(prev_page_url == null){
                $("#pagination").append("<li class='disabled page-item'><a class='page-link' href=''><</a></li>");
            }else{
                $("#pagination").append("<li class='active'><a class='page-link' href='/api/api_goodsuser?page="+(page-1)+"'><</a></li>");
            }

            //ページネーション表示
            for(var i=page-4;i<page+5;i++) {
                var link_page = i;
                //last_page以下のページまで
                if (link_page>last_page) {
                    break;
                }
                //ページ1が最小
                if (link_page<1) {
                    continue;
                }
                if(page==link_page)
                {
                    $("#pagination").append("<li  class='active page-item'><a class='page-link' href='/api/api_goodsuser?page="+link_page+"'>"+link_page+"</a></li>");
                }else{
                    $("#pagination").append("<li  class='page-item'><a class='page-link' href='/api/api_goodsuser?page="+link_page+"'>"+link_page+"</a></li>");
                }
                var link_page = i+1;
            }

            //Next制御
            if(next_page_url == null){
                $("#pagination").append("<li class='disabled page-item'><a class='page-link' href=''>>'</a></li>");
            }else{
                $("#pagination").append("<li class='page-item'><a class='page-link' href='/api/api_goodsuser?page="+(page+1)+"'>></a></li>");
            }

            //10個とばし制御
            if(next_page_url == null){
                $("#pagination").append("<li class='disabled page-item'><a class='page-link' href=''>»</a></li>");
            }else if ((page+10)>last_page) {
                $("#pagination").append("<li class='disabled page-item'><a class='page-link' href=''>»</a></li>");
            }else{
                $("#pagination").append("<li class='page-item'><a class='page-link' href='/api/api_goodsuser?page="+(page+10)+"'>»</a></li>");
            }

        }).always(function(data) {
            // 常に実行する処理
            $("#modalForm").modal('hide'); // モーダルを閉じる
        });
    });
});
