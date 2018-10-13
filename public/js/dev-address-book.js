/**
 * Ajax Search form for address book
 */
$(function(){

    var searchForm = $('#_jQ_SearchForm');
    var pagination = $('.pagination');
    var addressBookContainer = $('#_jQ_AddressBook');
    var searchField = $('#_jQ_SearchField');
    var loader = $('#_jQ_loader_searchAddressBook');

    searchForm.on('submit', function(event){

        // Prevent form submit to load ajax data
        event.preventDefault();

        if(searchField.val() != '')
        {
            let searchURL = '/crm/address-book/search/'+searchField.val();
            // Change elements status during loading
            addressBookContainer.html('');
            loader.toggle();
            pagination.remove();

            console.log('XHR request in progress ...');

            $.get( searchURL, function( data ) {

                console.log('Request success');
                addressBookContainer.html(data);
                loader.toggle();

            }).fail(function(){
                console.log('Request fail. See more detail below.');
                addressBookContainer.html('<div class="text-center">Une erreur est survenue durant votre recherche. Veuillez réessayer.</div>')
                loader.remove();

            })
        }

    })
});