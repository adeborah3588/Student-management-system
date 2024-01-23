<?php
include_once("libs/dbfunctions.php");
//var_dump($_SESSION);
?>
   <div class="card">
    <div class="card-header">
        <h5 class="card-title">Hostel List</h5>
        <h6 class="card-subtitle text-muted">Thee report contains Hostel that are available.</h6>
    </div>

    <div class="card-body">
      <a class="btn btn-outline-primary" onclick="loadModal('setup/hostel_setup.php','modal_div')"  href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">Add hostel</a>
        <div id="datatables-basic_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
    
<!--
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Create Role</label>
                </div>
            </div>
-->
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table id="page_list" class="table table-striped " >
                        <thead>
                            <tr role="row">
                            <th>ID</th>
                            <th> Hostel Type</th>
                                <th>Block</th>
                                <th>Action</th>
                                <!-- <th>Created</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<script src="../js/sweet_alerts.js"></script>-->
<!--<script src="../js/jquery.blockUI.js"></script>-->
<script>
  var table;
  var editor;
  var op = "hostel.hostelList";
  $(document).ready(function() {
    table = $("#page_list").DataTable({
      processing: true,
      columnDefs: [{
        orderable: false,
        targets: 0
      }],
      serverSide: true,
      paging: true,
      oLanguage: {
        sEmptyTable: "No record was found, please try another query"
      },

      ajax: {
        url: "utilities.php",
        type: "POST",
        data: function(d, l) {
          d.op = op;
          d.li = Math.random();
//          d.start_date = $("#start_date").val();
//          d.end_date = $("#end_date").val();
        }
      }
    });
  });

  function do_filter() {
    table.draw();
  }
  function removehostel(id) {
    alert(id);
    let cnf = confirm("Are you sure you want to delete hostel?");
    if (cnf == true) {
      $.blockUI();
      $.ajax({
        url: "utilities.php",
        data: {op: "hostel.removehostel",id: id},
        type: "post",
        dataType: "json",
        success: function(re){
          $.unblockUI();
          alert(re.response_message);
          getpage('hostelList.php', "page");
        },
        error: function(re){
          $.unblockUI();
          alert("Request could not be processed at the moment!");
        }
      });
    }

  }
  
    
    
    function getModal(url,div)
    {
//        alert('dfd');
        $('#'+div).html("<h2>Loading....</h2>");
//        $('#'+div).block({ message: null });
        $.post(url,{},function(re){
            $('#'+div).html(re);
        })
    }
</script>