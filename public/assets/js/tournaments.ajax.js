const initAjaxRoute = function(route, csrfToken) {
    
    $(document).ready(function () {
        console.log('here');
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
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'no_of_teams', name: 'no_of_teams'},
                {data: 'Start Date', name: 'start_date'},
                {data: 'Organized By', name: 'organizer_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });

}
