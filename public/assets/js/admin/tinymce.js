$(document).ready(function () {
    if ($('.tinymce').length) {
    	
    	function getImagesData () {
    		var path = $('.tinymce').data('path');
    		var imagesData;
    		
        	return $.ajax({
                url: path,
                type: 'POST',
                dataType: 'json',
                async: false,
                success: function (data) {
                	imagesData = data;
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    console.log(textStatus);
                }
            });
        	
        	return imagesData;
    	}
    	
    	var images = getImagesData();
    	
        tinymce.init({
            selector: '.tinymce',
            toolbar: ['undo redo | code | image | formatselect fontsizeselect | bold italic underline strikethrough link | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | subscript superscript | blockquote removeformat'],
            plugins: ['code link lists image'],
            menubar: false,
            relative_urls: false,
            image_list: images.responseJSON,
            image_caption: true,
            image_advtab: true,
            style_formats: [
            	{title: 'Image Left', selector: 'img', styles: {'float' : 'left', 'margin': '0 15px 0 0'}},
            	{title: 'Image Right', selector: 'img', styles: {'float' : 'right','margin': '0 0 0 15px'}}
            ]
        });
    }

    if ($('.tinymce-short').length) {
        tinymce.init({
            selector: '.tinymce-short',
            toolbar: ['undo redo | code | bold italic underline strikethrough link'],
            plugins: ['code link'],
            menubar: false
        });
    }
});