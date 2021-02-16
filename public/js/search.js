$('#search').keyup(function(){
   let value = $(this).val();
   //console.log(value);

   $.ajax('/api/search/'+value,{type: 'GET'}).then(function(response){
      console.log(response);
   $('#real-estate-list').html(response.html);
   });

});