
var beforeunload = false;


function slugify (text) {
    return text
        .toString()                   // Cast to string (optional)
        .normalize('NFKD')            // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
        .replace( /[\u0300-\u036f]/g, '' )
        .toLowerCase()                // Convert the string to lowercase letters
        .trim()                       // Remove whitespace from both sides of a string (optional)
        .replace(/\s+/g, '-')         // Replace spaces with -
        .replace(/[^\w\-]+/g, '')     // Remove all non-word chars
        .replace(/_/g,'-')           // Replace _ with -
        .replace(/--+/g, '-')       // Replace multiple - with single -
        .replace(/-$/g, '');         // Remove trailing -
}


function format_date(current_date)
{
    mois = String(parseInt(current_date.getMonth()) + 1).padStart(2, "0");
    jour = String(current_date.getDate()).padStart(2, "0");
    heures = String(current_date.getHours()).padStart(2, "0");
    minutes = String(current_date.getMinutes()).padStart(2, "0");
    date_format = current_date.getFullYear();
    date_format = date_format + "-";
    date_format = date_format + mois;
    date_format = date_format + "-";
    date_format = date_format + jour;
    date_format = date_format + "T";
    date_format = date_format + heures;
    date_format = date_format + ":";
    date_format = date_format + minutes;
    return date_format;
}

function format_date2()
{
    current_date = new Date();
    mois = String(parseInt(current_date.getMonth()) + 1).padStart(2, "0");
    jour = String(current_date.getDate()).padStart(2, "0");
    date_format = current_date.getFullYear();
    date_format = date_format + "-";
    date_format = date_format + mois;
    date_format = date_format + "-";
    date_format = date_format + jour;
    return date_format;
}

function set_onbeforeunload() {
    if (!beforeunload) {
        window.onbeforeunload = function (e) {
            return confirm("Etes vous sur de vouloir quitter ?");
        }
        beforeunload = true;
    }
}






// =======================================================================================================================
//
// NOUVELE PAGE ADMIN - FILMS ----------------------------------------------------------------------------------
//

if (document.getElementById("admin_films"))
{
    var image_destination = "";
    var nom_image = "";
    var film_slug = "";
    var champ_slug = "";
    var champ_date_ajout = "";
    var champ_film_titre = "";
    var image_crop = "";

    if (image_crop !== "")
    {
        image_crop.destroy();
        image_crop = "";
    }

    console.log('Admin Films OK');

    champ_date_ajout = document.getElementById('films_date_ajout');
    const film_age_mini = document.getElementById('films_age_mini');
    champ_film_titre = document.getElementById('films_titre');
    champ_slug = document.getElementById('films_affiche');


    champ_film_titre.addEventListener('input', function()
    {

        titre = this.value;
        console.log("titre : " + titre);
        champ_slug.value = slugify(champ_date_ajout.value + '-' + titre);

    });


    $('button.close').click(function(){
        $('.modale_container').fadeOut("fast");
        image_crop.destroy();
    });


    function type_image()
    {
        image_destination = $("input[name=film_image]:checked").val();
    }

    $('input[name=film_image]:radio').bind("change", function (event, ui) {
        type_image();
    });
    type_image();

    var el = document.getElementById('image_a_recadrer');

    function new_croppie(image_dest, el)
    {
        let viewport_width = 300;
        let viewport_height = 400;

        if (image_dest==="banniere")
        {
            viewport_width = 1000;
            viewport_height = 250;
        }

        return new Croppie(el, {
            enableExif: true,
            viewport: { width:viewport_width, height:viewport_height, type:'square' },
            boundary:{ width:1100, height:600 },
            enableOrientation: false,
            enforceBoundary: true
        });

    }

    $('#file_image').on('change', function()
    {
        image_crop = new_croppie(image_destination, el)

        // console.log(image_destination);
        $('.modale_container').fadeIn("fast");
        var reader = new FileReader();
        reader.onload = function (event) {
            image_crop.bind({
                url: event.target.result,
                orientation: 1
            }).then(function(){
                console.log("croppie attaché a l'image " + image_destination);
            });
        }
        reader.readAsDataURL(elem.files[0]);
        // console.log(elem.files[0]);
    });


    document.onpaste = function (event)
    {
        var items = (event.clipboardData || event.originalEvent.clipboardData).items;
        // console.log(JSON.stringify(items)); // might give you mime types
        for (var index in items)
        {
            var item = items[index];
            if (item.kind === 'file')
            {
                image_crop = new_croppie(image_destination, el)

                var blob = item.getAsFile();
                var reader = new FileReader();

                reader.onload = function (event) {
                    image_crop.bind({
                        url: event.target.result,
                        orientation: 1
                    }).then(function(){
                        console.log("croppie attaché a l'image " + image_destination);
                    });
                }

                $('.modale_container').fadeIn("fast");
                reader.readAsDataURL(blob);
            }
        }
    };


    $('.crop_image').click(function(event){
        image_crop.result({
            type: 'canvas',
            size: 'original',
            format: 'jpeg'
        }).then(function(response){
            $.ajax({
                url: url_upload,
                type: "POST",
                data:{"film_titre":champ_film_titre.value, "film_date_ajout":champ_date_ajout.value, "champ_source_image":image_destination, "image": response},
                dataType: 'json',
                success:function(data)
                {
                    $('.modale_container').fadeOut("fast");
                    console.log(data);
                    let date = new Date();
                    let time = date.getTime();

                    if (data.code === 'ok')
                    {
                        var image_src = "/images" + data.dossier_dest + data.name + "?t=" + time
                        $('#info_image').html(image_src).removeClass('rouge').addClass('vert');

                        if (image_destination === "affiche") updateImage('film_affiche_container', image_src);
                        if (image_destination === "banniere") updateImage('film_banniere_container', image_src);

                        console.log(image_src);
                    }
                    else if (data.code === 'erreur')
                    {
                        $('#info_image').html(data.error).addClass('rouge');
                    }


                }
            });
        });

        image_crop.destroy();
        image_crop = "";

    });

}



function updateImage(image_container, image_src)
{
    var container = document.getElementById(image_container);
    container.innerHTML = '<img class="film_image img-fluid" src="'+image_src+'">';
}







// =======================================================================================================================
//
// NOUVELE PAGE ADMIN - PLANNING SEANCES ----------------------------------------------------------------------------------
//

if (document.getElementById("planning_seances"))
{

    var $sp;
    var choix_film = { };
    var choix_date = "now";
    var choix_date_txt = "Aujourd'hui";
    var choix_cinema = "1";
    var choix_cinema_txt = "Nantes";
    var choix_techno = "";
    var data_clic = {};
    const ajax_url = "/admin2/seances/ajax/";

    const $liste_films = $('#liste_films');

    function addLog(type, message){
        console.log(type, message);
    }
    $(function(){
        $("#logs").append('<table class="table">');
        var isDraggable = true;
        var isResizable = false;
        var $sp = $("#seances_planning").timeSchedule({

            startTime: "10:00", // schedule start time(HH:ii)
            endTime: "23:50",   // schedule end time(HH:ii)
            widthTime: 60 * 10,  // cell timestamp example 10 minutes
            widthTimeX: 17,
            timeLineY: 70,       // height(px)
            verticalScrollbar: 20,   // scrollbar (px)
            timeLineBorder: 2,   // border(top and bottom)
            bundleMoveWidth: 6,  // width to move all schedules to the right of the clicked time line cell
            draggable: isDraggable,
            resizable: isResizable,
            resizableLeft: true,
            rows : data_seances_raw,
        onChange: function(node, data){
            addLog('onChange', data);
            set_onbeforeunload();
        },
        onInitRow: function(node, data){
            addLog('onInitRow', data);
        },
        onClick: function(node, data){
            addLog('onClick', data);
            data_clic = data;
            set_onbeforeunload();
        },
        onAppendRow: function(node, data){
            addLog('onAppendRow', data);
        },
        onAppendSchedule: function(node, data){
            addLog('onAppendSchedule', data);
            if(data.data.class){
                node.addClass(data.data.class);
            }
            if(data.data.image){
                var $img = $('<div class="photo"><img></div>');
                $img.find('img').attr('src', data.data.image);
                node.prepend($img);
                node.addClass('sc_bar_photo');
            }

            $deleteBtn = $('<span style="float: right; padding: 2px; cursor: pointer">❌</span>');

            $deleteBtn.click(function () {
                var $node = $(this).parent();
                var sc_key = $node.data('sc_key');
                addLog('delete : ', sc_key);
                $sp.timeSchedule('deleteEvent', sc_key);
                $node.remove();

                ajax = $.ajax({
                    url: ajax_url,
                    type: "POST",
                    data: JSON.stringify({ mode: "delete_seance", data: data_clic, }),
                }).done(function(data) {
                    console.log(data);
                });


            });

            node.prepend($deleteBtn)

        },
        onScheduleClick: function(node, time, timeline)
        {
            console.log(choix_film);
            set_onbeforeunload();

            if (choix_film.id !== undefined) {
                var start = time;
                let end = $sp.timeSchedule('formatTime', $sp.timeSchedule('calcStringTime', start) + ((choix_film.duree + 10) * 60));
                $(this).timeSchedule('addSchedule', timeline, {
                    start: start,
                    end: end,
                    text:choix_film.titre,
                    data:{
                        class: choix_film.nouveaute,
                        image: '/images/affiches/' + choix_film.affiche + '.jpg',
                        film_id: choix_film.id,
                        technos: choix_techno,
                    }
                });

            }
            addLog('onScheduleClick', time + ' ' + timeline);
        },
    });
        $('#event_timelineData').on('click', function(){
            addLog('timelineData', $sp.timeSchedule('timelineData'));
        });
        $('#btn_seances_planning').on('click', function(){
            let scheduleData = $sp.timeSchedule('timelineData');
            let coche_copier = $("#copier_planning");

            let mode_save = "save_planning";
            if (coche_copier.prop("checked"))
            {
                mode_save = "save_planning_and_copy";
            }

            let valeurs_json = {
                mode: mode_save,
                choix_date: $('#choix_date').val(),
                cinema_id: $('#cinema_id').val(),
                planning: scheduleData,
            };

            ajax = $.ajax({
                url: ajax_url,
                type: "POST",
                data: JSON.stringify(valeurs_json),
            }).done(function(data) {
                console.log(data);
            });

        });

        $('#clear-logs').on('click', function(){
            $('#logs .table').empty();
        });

        $(".lien_choix_cinema, .lien_choix_date").on("click", function()
        {
            let choix_cinema_clic = $(this).data("cinemaId");
            let choix_date_clic = $(this).data("filtreDate");

            var inner_text = $(this).text();

            if (choix_cinema_clic !== undefined)
            {
                choix_cinema_txt = inner_text;
                choix_cinema = choix_cinema_clic;
                $(".lien_choix_cinema").removeClass("active");
                $(this).addClass("active");
            }

            if (choix_date_clic !== undefined)
            {
                choix_date_txt = inner_text;
                choix_date = choix_date_clic;
                $(".lien_choix_date").removeClass("active");
                $(this).addClass("active");
            }

            $('#info_planning').text(choix_cinema_txt + ', ' + choix_date_txt);

            let valeurs_json = {
                mode: "search_cinema_date",
                search_cinema: choix_cinema,
                search_date: choix_date,
            };

            $('#choix_date').val(choix_date);
            $('#cinema_id').val(choix_cinema);

            console.log(valeurs_json);

            ajax = $.ajax({
                url: ajax_url,
                type: "POST",
                data: JSON.stringify(valeurs_json),
            }).done(function(data) {
                console.log(data);
                $sp.timeSchedule('setRows', data);
            });


        })




    });


    $sp = $('#seances_planning');

    console.log(data_films);

    for (i=0; i <= data_films.length - 1; i++ )
    {
        film = data_films[i];
        //console.log(film);
        btn_class = (film.anciennete < 7 ) ? 'text-bg-primary' : 'text-bg-default';
        data_nouveaute = (film.anciennete < 7 ) ? 'nouveau' : '';
        $liste_films.append('<span class="bouton_film '+btn_class+' badge px-2 mx-1" data-film-id="'+ film.id +'"   data-nouveaute="'+ data_nouveaute +'"  data-film-duree="'+ film.duree +'" data-film-duree-minutes="'+ film.duree_minutes +'" data-affiche="'+ film.affiche +'">'+ film.titre +'</span>')
    }

    $('.bouton_film').on("click", function()
    {
        choix_film.titre = $(this).text();
        choix_film.duree = $(this).data("filmDureeMinutes");
        choix_film.id = $(this).data("filmId");
        choix_film.nouveaute = $(this).data("nouveaute");
        choix_film.affiche = $(this).data("affiche");

        $('.bouton_film').removeClass('active');
        $(this).addClass("active");
    });

    $('.badge_choix_techno').on("click", function()
    {
        console.log(choix_techno);
        let choix_techno_clic = $(this).data("choixTechno");
        if (choix_techno_clic === choix_techno)
        {
            choix_techno = "";
            $(".badge_choix_techno").removeClass("active");
        }
        else if (choix_techno_clic !== "")
        {
            console.log("boucle 'choix techno clic' non vide : ");
            console.log(choix_techno_clic);
            choix_techno = choix_techno_clic;
            $(".badge_choix_techno").removeClass("active");
            $(this).addClass("active");
        }
    });


}








// =======================================================================================================================
//
// PAGE SEANCES EASYADMIN ----------------------------------------------------------------------------------
//

if (document.getElementById("ea-new-Seances"))
{

    console.log('DOMContentLoaded');
    const cinema_select = document.getElementById('Seances_cinema_id'); // Remplacez par l'ID réel de votre select salle
    const salle_select = document.getElementById('Seances_salle_id'); // Remplacez par l'ID réel de votre select salle
    const film_select = document.getElementById('Seances_film_id'); // Remplacez par l'ID réel de votre select salle
    const film_label = document.getElementById('Seances_film_id-ts-label'); // Remplacez par l'ID réel de votre select salle
    const seance_duree_film = document.getElementById('Seances_duree_film'); // Remplacez par l'ID réel de votre select salle
    const seance_date_debut = document.getElementById('Seances_date_debut'); // Remplacez par l'ID réel de votre select salle
    const seance_date_fin = document.getElementById('Seances_date_fin'); // Remplacez par l'ID réel de votre select salle

    var date_debut = "";
    var duree_film = "";

    let tomselect_cinema = cinema_select.tomselect;
    let tomselect_salles = salle_select.tomselect;
    let tomselect_film = film_select.tomselect;
    tomselect_cinema.clear();
    tomselect_salles.clear();
    tomselect_salles.clearOptions();

    tomselect_film.on('change', function()
    {
        const film_id = tomselect_film.getValue();
        fetch(`/admin/films/duree_film/${film_id}`)
            .then(response => response.json())
            .then(data => {

                duree_film = data[0].duree_film;
                console.log(data[0].duree_film);
                seance_duree_film.value = duree_film;
                film_label.innerText = "Film (durée : " + duree_film + " minutes)";
                set_date_fin();

            })
            .catch(error => console.error('Error:', error));
    });


    seance_date_debut.addEventListener('change', function()
    {
        date_debut = this.value;
        console.log("date_debut : " + date_debut);
        set_date_fin();

    });

    function set_date_fin()
    {
        if (date_debut != "" && duree_film != "")
        {
            var date_date_debut = Date.parse(date_debut);
            var date_date_fin = new Date(date_date_debut + ((duree_film + 10)*60000));
            date_fin_format = format_date(date_date_fin);
            seance_date_fin.value = date_fin_format;
            console.log(date_date_fin);
            console.log(date_fin_format);
        }
    }



    tomselect_cinema.on('change', function()
    {
        const cinema_id = tomselect_cinema.getValue();
        console.log("Tomselect changé ! " + cinema_id);
        tomselect_salles.clear();
        tomselect_salles.clearOptions();


        fetch(`/admin/salles/salles_by_cinema/${cinema_id}`)
            .then(response => response.json())
            .then(data => {
                salle_select.innerHTML = '';

                data.forEach(salle => {
                    const option = document.createElement('option');
                    option.value = salle.id;
                    option.text = salle.nom;
                    salle_select.add(option);
                });

                tomselect_salles.sync();

            })
            .catch(error => console.error('Error:', error));
    });


}


