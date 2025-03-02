var nombre_filtres = 0;
var jour_filtre = "Aujourd'hui";
var titre_bouton_cinema_defaut = ": Veuillez choisir un cinéma";
var titre_bouton_cinema = titre_bouton_cinema_defaut;
var ajax = false;

var search_date = search_technologie = search_genre = search_cinema = "";

$(document).ready(function(){

    const dropdown_cinemas = $('.dropdown_cinemas');
    const dropdown_filtres = $('.dropdown_filtres');
    const lien_voir_tout = $('.lien_voir_tout');

    $(".lien_filtre_cinema, .lien_filtre_date, .badge_genre_filtres, .lien_voir_tout").on("click", function(){
        let filtre_cinema = $(this).data("cinemaId");
        let filtre_date = $(this).data("filtreDate");
        let filtre_nom_jour = $(this).data("nomJour");
        let filtre_technologie = $(this).data("filtreTechno");
        let filtre_genre = $(this).data("filtreGenre");


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
            search_cinema = filtre_cinema;
        }
        else
        {
            search_cinema = "tous";
        }

        if (filtre_date !== undefined)
        {
            console.log("filtre_nom_jour : " + filtre_nom_jour);
            console.log("filtre_date : " + filtre_date);
            jour_filtre = inner_text;
            $(".lien_filtre_date").removeClass("active");
            $(this).addClass("active");
            dropdown_cinemas.text(jour_filtre + " dans votre " + titre_bouton_cinema);
            if (filtre_nom_jour == "j1") search_date = "now";
            else search_date = filtre_date;
        }
        else if (search_date == "")
        {
            search_date = "now";
        }

        if (filtre_technologie !== undefined)
        {
            if (search_technologie == "" || search_technologie == "tous") nombre_filtres++
            console.log("filtre_technologie : " + filtre_technologie);
            search_technologie = filtre_technologie;
            $(".badge_filtre_techno").removeClass("active");
            $(this).addClass("active");
        }
        else if (search_technologie == "")
        {
            search_technologie = "tous";
        }

        if (filtre_genre !== undefined)
        {
            if (search_genre == "" || search_genre == "tous") nombre_filtres++
            console.log("filtre_genre : " + filtre_genre);
            search_genre = filtre_genre;
            $(".badge_filtre_genre").removeClass("active");
            $(this).addClass("active");

        }
        else if (search_genre == "")
        {
            search_genre = "tous";
        }

        if (inner_text === "Voir tout")
        {
            nombre_filtres = 0;
            search_technologie = "tous";
            search_genre = "tous";
        }
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

        let valeurs_json = {
            search_cinema: search_cinema,
            search_date: search_date,
            search_technologie: search_technologie,
            search_genre: search_genre
        };
        console.log(valeurs_json);

        if (ajax) ajax.abort();
        $('.div_film').fadeOut('fast');
        ajax = $.ajax({
            url: "/films_ajax/",
            type: "POST",
            data: JSON.stringify(valeurs_json),
        }).done(function(message) {
            console.log(message);
            render_liste_films(message);
        }).always(function() {
            ajax = false;
        });


    })

    function hide_dropdown(){
        bootstrap.Dropdown.getOrCreateInstance(dropdown_cinemas).hide();
        bootstrap.Dropdown.getOrCreateInstance(dropdown_filtres).hide();
    }

    function render_liste_films(data_ajax)
    {
        $conteneur_liste_films = $('.row.liste_films');
        $conteneur_liste_films.html("");

        for (var i = 0; i < data_ajax.length; i++)
        {
            var film = data_ajax[i];

            let badge_nouveau = "";
            if (film.nombre_jours < 7)
                badge_nouveau = '<span class="badge text-bg-danger fs-5 position-absolute top-0 start-0 mt-4 ms-2">NOUVEAU</span>';

            let badges_informations = "";
            let mention_age_public = "";
            let badge_class = ""
            let badge_title = ""

            if (film.age_mini > 0 || film.avertissement !== null || film.coup_de_coeur)
            {
                mention_age_public = "-" + film.age_mini;

                if (film.age_mini < 12)
                {
                    badge_class = "text-bg-primary";
                    badge_title = "A partir de ";
                }
                else if (film.age_mini >= 12)
                {
                    badge_class = "text-bg-warning";
                    badge_title = "Interdit aux moins de ";
                    if (film.age_mini >= 18) badge_class = "text-bg-danger";
                }
                badge_title = badge_title + film.age_mini + " ans";

                badges_informations = '<span class="fs-5 position-absolute bottom-0 end-0 mb-4 me-2">';

                if (film.age_mini > 0)
                    badges_informations = badges_informations + '<span class="badge rounded-pill ' + badge_class + '" title="' + badge_title + '">' + mention_age_public + '</span>';

                if (film.avertissement !== null)
                    badges_informations = badges_informations + '<i class="bi-exclamation-circle-fill" title="Avertissement : ' + film.avertissement + '"></i>';

                if (film.coup_de_coeur)
                    badges_informations = badges_informations + '<i class="bi-heart-fill text-danger" title="Coup de coeur Cinéphoria !"></i>';


                badges_informations = badges_informations + '</span>';

            }



            var div_film =
                '<div class="col div_film">' +
                    '<a href="/film/'+ film.id +'" class="films_lien_details">' +
                        '<div class="card">' +
                            '<img src="images/affiches/' + film.affiche + '.jpg" class="card-img-top" alt="' + film.titre + '">' +
                            '<div class="film_hover">INFOS ET<br><b>SEANCES</b></div>' +
                            badge_nouveau +
                            badges_informations +
                            '<div class="card-body">' +
                                '<h5 class="card-title">' + film.titre + '</h5>' +
                            '</div>' +
                        '</div>' +
                    '</a>' +
                '</div>';

            $conteneur_liste_films.append(div_film);

        }
    }

})

