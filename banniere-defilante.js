    (function($){

     $('.banniere').each(function(){

     var element = $(this);
     var nombre_enfant = $(this).children("img").length;

     if(nombre_enfant>1){

     var en_cours = 0;
     element.children("img").hide();
     element.children("img").eq(en_cours).show();

     element.append("<div class='banniere_suivant'>&gt;</div><div class='banniere_precedent'>&lt;</div>");
     var suivant = $(".banniere_suivant");
     var precedent = $(".banniere_precedent");
     suivant.show();

     element.everyTime(10000, "banniere" , function(i) {

     element.children("img").eq(en_cours).fadeOut(500);

     en_cours++;
     if(en_cours==nombre_enfant) en_cours = 0;

     element.children("img").eq(en_cours).fadeIn(500);

     });

     suivant.click(function(){

     element.stopTime("banniere");
     precedent.show();

     element.children("img").eq(en_cours).fadeOut(500);

     en_cours++;
     if((en_cours+1)==nombre_enfant) suivant.hide();

     element.children("img").eq(en_cours).fadeIn(500);

     });

     precedent.click(function(){

     element.stopTime("banniere");
     suivant.show();

     element.children("img").eq(en_cours).fadeOut(500);

     en_cours--;
     if(en_cours===0) precedent.hide();

     element.children("img").eq(en_cours).fadeIn(500);

     });

     }

     });

    })(jQuery);
