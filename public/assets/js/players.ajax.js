const PlayersAjaxRoute = function(route, csrfToken) {

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: route,
                type: "POST",
                data: function(d) {
                    d._token = csrfToken;
                }
            },
            columns: [
                {data: 'Profile', name: 'photo_path', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'Date of birth', name: 'dob'},
                {data: 'State', name: 'state'},
                {data: 'Specialization', name: 'specialization'},
                {data: 'Jersey no', name: 'jersey_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

}
