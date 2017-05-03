(function($) { 
// Uploading files
var file_frame;
var imageField;
var previewImage;

  $('.upload-image-button').live('click', function( event ){
	  
    event.preventDefault();
    
    // Get the correct image field
     imageField = $(this).prev(".box-image-field");
	 previewImage = $(this).next(".preview-image");


    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: $( this ).data( 'uploader_title' ),
      button: {
        text: $( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
      console.log(attachment);

      // Add attachment URL to image field
      imageField.val(attachment.id);
      // Change preview image
      previewImage.attr("src", attachment.url).removeAttr("srcset sizes");      
    });

    // Finally, open the modal
    file_frame.open();
  });
})(jQuery);