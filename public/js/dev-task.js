/**
 * Ajax query to delete or change task status.
 * Using hidden field to quick access REST API actions for each field
 */
$(function(){

    // Delete Function
    $('.delete-task').on('click', function(){
        // hide tooltip to avoid persistence after removing element
        $('.tooltip').tooltip('hide');

        let APIUrl = $(this).children('._jQ_URL_Delete').val();
        let taskItemElement = $(this).parent('div.list-tasks-item')
       
        // Call API to delete Task
        $.get(APIUrl, function(data){
            console.log(data);
        });
        
        // Delete element from DOM
        taskItemElement.remove();

        // Reload page if < 1
        if($('div.list-tasks-item').length < 1)
            $('.list-task.no-task').toggle();
    });

    // Update Status function
    $('div.list-tasks-item').on('click', function(event){
        // This line prevent both event on label and on checkbox.
        if (event.target.tagName.toUpperCase() === "LABEL") {
            return;
          }
        let APIUrl = $(this).children('._jQ_URL_ChangeStatus').val();

        // Call API to update task status
        $.get(APIUrl, function(data){
            console.log(data);
        });
    });
});