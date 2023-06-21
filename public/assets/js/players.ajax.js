const initAjaxRoute = function(route, csrfToken , tournamentId, teamId) {

    $(document).ready(function () {
        console.log(teamId);
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: route,
                type: "POST",
                data: function(d) {
                    d._token = csrfToken;
                    d._tournamentId = tournamentId;
                    d._teamId = teamId;
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'Specialization', name: 'specialization'},
                {data: 'Batting Hand', name: 'batting_hand'},
                {data: 'Balling Hand', name: 'balling_hand'},
                {data: 'Balling Type', name: 'balling_type'},
                {data: 'Fav Playing Spot', name: 'fav_playing_spot'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });

}
