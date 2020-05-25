//デフォルトのAPIURL
const url = "/api/api_itemuser";

//getのidを変えた時に、URLのパラメータに付与
function changeGetUrl() {
    //idがget_idの値を取得
    var get_id = document.getElementById('get_id');
    id_val = get_id.value;

    //値があれば付与。なければデフォルト。
    if (id_val) {
        document.getForm.action = url+'/'+id_val;
    } else {
        document.getForm.action = url;
    }
}

//postのidを変えた時に、URLのパラメータに付与
// function changePostUrl() {
//     var post_id = document.getElementById('post_id');
//     id_val = post_id.value;
//
//     if (id_val) {
//         document.postForm.action = url+'/'+id_val;
//     } else {
//         document.postForm.action = url;
//     }
// }

//putのidを変えた時に、URLのパラメータに付与
function changePutUrl() {
    var put_id = document.getElementById('put_id');
    id_val = put_id.value;

    if (id_val) {
        document.putForm.action = url+'/'+id_val;
    } else {
        document.putForm.action = url+'/null';
    }
}

//deleteのidを変えた時に、URLのパラメータに付与
function changeDeleteUrl() {
    var put_id = document.getElementById('delete_id');
    id_val = delete_id.value;

    if (id_val) {
        document.deleteForm.action = url+'/'+id_val;
    } else {
        document.deleteForm.action = url+'/null';
    }
}
