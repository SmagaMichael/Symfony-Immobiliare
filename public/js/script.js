
$('#ajax-properties').click(function() {
    $.get('/property.json').then(function(properties) {
        console.log(properties);
    })
});

/**
 * On écoute l'evenement sur le range
 * Les deux premieres lignes servent à avoir l'affichage tout de suite au chargement
 * de la page
 */
$('#real_estate_surface').after('<div id="result">'+$('#real_estate_surface').val()+'m²</div>')

$('#real_estate_surface').on('input', function() {

    $('#result').remove();
   //je récupere la valeur du input et l'ajoute directement en dessous de celui-ci
    $(this).after('<div id="result">'+$(this).val()+'m²</div>')
});

$('[type="file"]').on('change', function(){
    let label = $(this).val().split('\\').pop();
    $(this).next().text(label);



    let reader = new FileReader();
    reader.addEventListener('load', function(file){
        $('.custom-file img').remove();

        let base64 = file.target.result;
        let img = $('<img class="img-fluid mt-5" width="250" />');

        img.attr('src', base64);

        $('.custom-file').prepend(img);
       console.log(file.target.result);
    });
    reader.readAsDataURL(this.files[0]);

})