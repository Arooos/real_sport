$(document).ready(function(){
    $('#formSearch').on('click', function(e){
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "adminsearch/tourSearch.php",
            data: $(this).serialize(),
            success:function(data){
                $('#serch_result').html(data);
            }
        });
    });
    return false;
});