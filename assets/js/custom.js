$('#q').on('keyup paste', function() {
    $('#search').not(this).val($(this).val());
});