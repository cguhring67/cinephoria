document.addEventListener('DOMContentLoaded', function()
{

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

});