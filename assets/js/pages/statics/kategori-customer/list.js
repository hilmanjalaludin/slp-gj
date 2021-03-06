//js for datatable list.
var lists = function () {
    var table_id = "#dataTable";
    var ajax_source = "/statics/kategori-customer/list-all-data";
    var columns = [
        {"data": "kategori_name" },
        {"data": "is_active_name" },
        {"data": "version" },
        {
            "class": "text-center",
            "data": null,
            "sortable": false,
            "render": function(data, type, full) {

                //action buttons.
                var buttons =  '<td>';
                buttons +=  ' <a href="/statics/kategori-customer/edit/' + full.kategori_customer_id + '" class="btn btn-primary btn-circle" rel="tooltip" title="Edit Kategori Customer" data-placement="top" ><i class="fa fa-pencil"></i></a>';
                if (full.is_active == "1") {
                    buttons +=  ' <a href="/statics/kategori-customer/delete" data-id ="' + full.kategori_customer_id + '" data-name ="' + full.kategori_name + '" class="btn btn-danger btn-circle delete-confirm" rel="tooltip" title="Delete Kategori Customer" data-placement="top" ><i class="fa fa-trash-o"></i></a>';
                } else {
                    buttons +=  ' <a href="/statics/kategori-customer/reactivate" data-id ="' + full.kategori_customer_id + '" data-name ="' + full.kategori_name + '" class="btn btn-danger btn-circle reactivate-confirm" rel="tooltip" title="Reactivate Kategori Customer" data-placement="top" ><i class="fa fa-power-off"></i></a>';
                }
                buttons +=  '</td>';

                return buttons;
            }
        },
    ];

    //setup datepicker for advanced search.
    setup_daterangepicker(".date-range-picker");

    //begin initialize datatable.
    init_datatables (table_id, ajax_source, columns);

    //on delete action button click.
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

    //on reactivate action button click.
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

    //on popup confirm trigger success.
    $(document).on("popup-confirm:success", function (e, url, data_id){
        $("#dataTable").dataTable().fnClearTable();
    });
};

$(document).ready(function() {
    lists();
});
