import '../css/app.scss';

var timer;

$('#register_searchAddress').on( 'keydown', function(){
    clearTimeout( timer );
    timer = setTimeout( function(){
        $.ajax('ajax/address', {
            method: 'get',
            data: 'address=' + $('#register_searchAddress').val(),
        }).done( updateAutocomplete );
    }, 600);
});

$('#autocompleter').on( 'click', 'li', function(){
    let data = JSON.parse( decodeURIComponent( $(this).attr( 'data-address' ) ) );
    $('#register_address').val( data.address );
    $('#register_zipcode').val( data.zipcode );
    $('#register_city').val( data.city );
    $('#register_country').val( data.country );

    $('#register_searchAddress').val( $(this).text() );
    $('#autocompleter').html( '' );
});

function updateAutocomplete( response ){
    $('#autocompleter').html( '' );
    for( let i in response.results ){
        let data = {
            'address': response.results[i].properties.name,
            'zipcode': response.results[i].properties.postcode,
            'city': response.results[i].properties.city,
            'country': 'France',
        };
        $('#autocompleter').append( '<li data-address="' + encodeURIComponent( JSON.stringify( data ) ) + '">' + response.results[i].properties.label + '</li>' );
    }
}
