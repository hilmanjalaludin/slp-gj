<script>
	var lists = function () {
    var table_id = "#dataTable";
    var ajax_source = "<?= site_url('user/list_all_data_dipo'); ?>";
    var url = "<?= site_url('user'); ?>";        
    var columns = [
        {"data": "user_id" },
        {"data": "user_full_name" },
        {"data": "user_nik" },
        {"data": "user_email" },
        {"data": "user_position" },
        {
            "data": "user_last_login",
            "render":function(data, type, full) {
                if (data != null && data != "") {
                    return moment(data).format("DD MMM YYYY HH:mm:ss");
                }

                return "";
            }
        },
        {
            "title": "Action",
            "class": "text-center",
            "data": null,
            "sortable": false,
            "render": function(data, type, full) {
                var edit =  '<td>';
                    // edit +=  ' <a href="' + url +'/user/view/' + full.user_id + '" class="btn btn-info btn-circle" rel="tooltip" title="View Admin" data-placement="top" ><i class="fa fa-eye"></i></a>';
                     edit +=  ' <a href="' + url + '/edit/' + full.user_id + '" class="btn btn-primary btn-circle" rel="tooltip" title="Edit User" data-placement="top" ><i class="fa fa-pencil"></i></a>&nbsp;';
                    edit += '<a href="'+ url +'/delete-user" data-id ="' + full.user_id + '" data-name ="' + full.user_full_name + '" class="btn btn-danger btn-circle delete-confirm" rel="tooltip" title="Delete Slip" data-placement="top" ><i class="fa fa-trash-o"></i></a> &nbsp;';
                    edit += '<a href="'+ url +'/change_pass_default" data-id ="' + full.user_id + '" data-name ="' + full.user_full_name + '" class="btn btn-warning btn-circle reset-confirm" rel="tooltip" title="Reset Password" data-placement="top" ><i class="fa fa-key"></i></a>';
                    edit +=  '</td>';
                    // edit +=  ' <a href="' + url + '/edit/' + full.user_id + '" class="btn btn-primary btn-circle" rel="tooltip" title="Edit User" data-placement="top" ><i class="fa fa-pencil"></i></a>';
                    // edit +=  '</td>';

                return edit;
            }
        },
    ];
    setup_daterangepicker(".date-range-picker");
    init_datatables (table_id, ajax_source, columns);

    $(document).on("click", ".delete-confirm", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var url = $(this).attr("href");
        var data_id = $(this).data("id");
        var data_name = $(this).data("name");

        title = 'Delete Confirmation';
        content = 'Do you really want to delete ' + data_name + ' ?';

        popup_confirm (url, data_id, title, content);

    });

    $(document).on("click", ".reactivate-confirm", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var url = $(this).attr("href");
        var data_id = $(this).data("id");
        var data_name = $(this).data("name");

        title = 'Re-activate Confirmation';
        content = 'Do you really want to re-activate ' + data_name + ' ?';

        popup_confirm (url, data_id, title, content);

    });

    $(document).on("click", ".reset-confirm", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var url = $(this).attr("href");
        var data_id = $(this).data("id");
        var data_name = $(this).data("name");

        title = 'Reset Konfirmasi';
        content  = 'Apakah anda yakin akan mereset password user ' + data_name + '?';
        content += 'User Password Default (1234)';

        popup_confirm (url, data_id, title, content);

    });

    $(document).on("popup-confirm:success", function (e, url, data_id){
        $("#dataTable").dataTable().fnClearTable();
    });
};

$(document).ready(function() {
    lists();
});

</script>