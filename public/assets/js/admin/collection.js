$(document).ready(function () {
    //collection autocomplete
    $('.collection').on('change', function (event) {
        var id = 0;
        if ($(this).val().length > 0) {
            id = $(this).val();
        }
        
        var signatureId = 0;
        if ($(this).data('signature') > 0) {
            signatureId = $(this).data('signature');
        }
        
        var path = $(this).data('url') + '/' + id + '/' + signatureId;
        
        $.ajax({
            url: path,
            type: 'POST',
            dataType: 'json',
            async: true,

            success: function (data, status) {
                $('.signature-autocomplete').val(data.signature);
                $('.donor_description-autocomplete').val(data.donor_description);
                
                // if (!$('.donor-autocomplete').val()) {
                    $('.donor-autocomplete').val(data.donor);
                // }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
            }
        });
    });
});