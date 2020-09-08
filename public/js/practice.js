$(function(){
    var jyoyjo = [
        'ジョナサン・ジョースター',
        'ジョセフ・ジョースター',
        '空条承太郎',
        '東方仗助',
        'ジョルノ・ジョバァーナ'
    ];
    var lengths = jyoyjo.length
    $.each(jyoyjo,function(key,val){
        $("ul.q42").append('<li>'+val+'</li>');
        console.log(key + ':' + val);
    })

});
