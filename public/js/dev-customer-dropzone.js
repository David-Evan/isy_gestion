// Disabled Dropzone Autodiscover 
Dropzone.autoDiscover = false;

var div_avatarCustomer = $('#CustomerAvatar');
var div_AvatarDropzone = $('.profile-dropzone-container');


var avatarCustomerDropzone = new Dropzone("form#CustomerAvatarDropzone", {
    acceptedFiles: 'image/*,.png,.jpeg,.jpg',
    
    success: (file, response)=>{
        $('#CustomerAvatar').attr('src', response.uploadFileURL);
        div_avatarCustomer.toggle();
        div_AvatarDropzone.toggle();
        avatarCustomerDropzone.removeAllFiles( true );
    }
});