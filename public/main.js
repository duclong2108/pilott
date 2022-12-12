var loadfile = function(event) {
    $('#preview').html('');
    for (let i = 0; i < event.target.files.length; ++i) {
        var image = document.createElement('img');
        image.src = URL.createObjectURL(event.target.files[i]);
        image.width = "100";
        image.height = "100";
        document.querySelector("#preview").appendChild(image);
    }
};
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.winner-count').click(function(){
        var date=$('.click-date').val();
        $.ajax({
            url:'/admin/count-date',
            type:'POST',
            data:{
                date:date
            },
            success:function(resp){
                if(resp['status']==1){
                    $('#count-date').val(resp['count_date']);
                }
            },error:function(){
                alert('ERROR');
            }
        })
    })
});