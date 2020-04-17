import '../css/app.scss';

$('#register_searchAddress').on( 'keyup', function(){
    $.ajax('ajax/address', {
        method: 'get',
        data: 'address=' + $(this).val(),
    }).done( function( response ){
        console.log( response );
    });
});