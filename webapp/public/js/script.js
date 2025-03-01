var nombre_filtres = 0;
var jour_filtre = "Aujourd'hui";
var titre_bouton_cinema_defaut = ": Veuillez choisir un cinéma";
var titre_bouton_cinema = titre_bouton_cinema_defaut;

$(document).ready(function(){

    const dropdown_cinemas = $('.dropdown_cinemas');
    const dropdown_filtres = $('.dropdown_filtres');
    const lien_voir_tout = $('.lien_voir_tout');

    $(".lien_filtre_cinema, .lien_filtre_date, .badge_genre_filtres, .lien_voir_tout").on("click", function(){
        var filtre_cinema = $(this).data("cinemaId");
        var filtre_date = $(this).data("filtreDate");
        var filtre_nom_jour = $(this).data("nomJour");
        var filtre_technologie = $(this).data("filtreTechno");
        var filtre_genre = $(this).data("filtreGenre");

        var inner_text = $(this).text();

        // bootstrap.Dropdown.hide();
        $('.dropdown-menu').slideUp('400');
        setTimeout(hide_dropdown, 400);
        setTimeout(function() { $('.dropdown-menu').attr("style", "1"); }, 450);

        console.log(" ");
        console.log("Texte élément : " + inner_text);
        if (filtre_cinema !== undefined)
        {
            console.log("filtre_cinema : " + filtre_cinema);
            titre_bouton_cinema = inner_text;
            dropdown_cinemas.text(jour_filtre + " dans votre " + titre_bouton_cinema);
            $(".dropdown-item").removeClass("active");
            $(this).addClass("active");

        }
        if (filtre_date !== undefined)
        {
            console.log("filtre_date : " + filtre_nom_jour + " " + filtre_date);
            jour_filtre = inner_text;
            $(".lien_filtre_date").removeClass("active");
            $(this).addClass("active");

            dropdown_cinemas.text(jour_filtre + " dans votre " + titre_bouton_cinema);
        }
        if (filtre_technologie !== undefined)
        {
            nombre_filtres++
            console.log("filtre_technologie : " + filtre_technologie);
        }
        if (filtre_genre !== undefined)
        {
            nombre_filtres++
            console.log("filtre_genre : " + filtre_genre);
        }

        if (inner_text === "Voir tout") nombre_filtres = 0;
        if (nombre_filtres > 0)
        {
            dropdown_filtres.text("Filtres ("+nombre_filtres+")");
            dropdown_filtres.addClass("active");
            lien_voir_tout.removeClass("active");
        }
        else
        {
            dropdown_filtres.text("Filtres");
            dropdown_filtres.removeClass("active");
            lien_voir_tout.addClass("active");
        }




    })

    function hide_dropdown(){
        bootstrap.Dropdown.getOrCreateInstance(dropdown_cinemas).hide();
        bootstrap.Dropdown.getOrCreateInstance(dropdown_filtres).hide();
    }
})

