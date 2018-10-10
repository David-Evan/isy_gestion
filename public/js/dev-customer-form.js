$(function(){    
    // Define some var to qucik access
    var form_sumbitButton = $('._jQ-disableable-submit');
    var form_diableableElements = $('._jQ-disableable');
    var form_changeStatusButton = $('._jQ-unlock-form');
    var form_lockableIcon = $('.addon-lockable .fa-lock');
    var div_avatarCustomer = $('#CustomerAvatar');
    var div_AvatarDropzone = $('.profile-dropzone-container');
    

        // At init : If submit form button is disabled, un-display it and disabled tinymce
    if(form_sumbitButton.attr('readonly')){
        form_sumbitButton.hide();
    }
    // On click : Lock / unclock all elements
    form_changeStatusButton.on('click', ()=>{

        if(form_diableableElements.attr('readonly')){
            form_diableableElements.attr('readonly', false)
            tinymce.get('customer_comment').setMode('design');
            form_lockableIcon.attr('class', 'fas fa-unlock')
            form_changeStatusButton.toggleClass('btn-danger');
            form_changeStatusButton.toggleClass('btn-primary');
            form_sumbitButton.show();
            div_avatarCustomer.toggle();
            div_AvatarDropzone.toggle();

        }
        else{
            tinymce.get('customer_comment').setMode('readonly');
            form_diableableElements.attr('readonly', true)
            form_lockableIcon.attr('class', 'fas fa-lock')
            form_changeStatusButton.addClass('btn-danger');
            form_changeStatusButton.toggleClass('btn-primary');
            form_sumbitButton.hide();
            div_avatarCustomer.toggle();
            div_AvatarDropzone.toggle();
        }
        });
    });

    