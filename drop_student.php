<?php
include_once("../libs/dbfunctions.php");
include_once("../class/room.php");
$dbobject = new dbobject();
//$sql = "SELECT DISTINCT(State) as state,stateid FROM lga order by State";
//$states = $dbobject->db_query($sql);
//
//$sql2 = "SELECT bank_code,bank_name FROM banks WHERE bank_type = 'commercial' order by bank_name";
//$banks = $dbobject->db_query($sql2);
//
//$sql_pastor = "SELECT username,firstname,lastname FROM userdata WHERE role_id = '003'";
//$pastors = $dbobject->db_query($sql_pastor);



$id = $_REQUEST['id'];
$sql = "SELECT * FROM room WHERE id = '$id' LIMIT 1";
file_put_contents("deborah.txt", $sql);
$room = $dbobject->db_query($sql);

$sql = "SELECT * FROM font_awsome ORDER BY code ";
$fonts = $dbobject->db_query($sql);

$sql = "SELECT concat(first_name, ' ', last_name) as first_name, matric_no FROM student order by first_name";
$first_name = $dbobject->db_query($sql);

$onepay_merchant=$dbobject->getitemlabel("parameter","parameter_name","ONEPAY_MERCHANT_CODE","parameter_value");
$onepay_url=$dbobject->getitemlabel("parameter","parameter_name","ONEPAY_PAYMENT_URL","parameter_value");
// $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
// $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
// var_dump($id);
//  var_dump($id);



// $sql = "SELECT DISTINCT(course) as course,id FROM course order by course";
// $course = $dbobject->db_query($sql);


// $room = [];
// if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
//     $operation = 'edit';
//     $id = $_REQUEST['id'];
//     $sql_menu = "SELECT * FROM room WHERE id = '$id' LIMIT 1";
//     file_put_contents("deborah.txt", $sql_menu);
//     $room = $dbobject->db_query($sql_menu);
// } else {
//     $operation = 'new';
// }
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- <script>
    doOnLoad();
    var myCalendar;
function doOnLoad()
{
   myCalendar = new dhtmlXCalendarObject(["start_date"]);
    myCalendar.setSensitiveRange(null, "<?php echo date('Y-m-d') ?>");
   myCalendar.hideTime();
}
</script> -->
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Student</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3">
    <form  action="<?php echo $onepay_url; ?>" method="POST" id="upay" name="upay_form">
    <input name="product_desc" id="product_desc" type="hidden" value="Hostel Room Payment" />
    <input name="merch_trans_id" id="merch_trans_id" type="hidden" value="" />
<!-- to be generated -->
    <input name="merchant_reg_id" id="merchant_reg_id" type="hidden" value="<?php echo $onepay_merchant; ?>" />
 
    <input name="client_email" id="client_email" type="hidden" value="<?php echo $student_email; ?>" />

    <input name="client_name" id="client_name" type="hidden" value="<?php echo $student_name; ?>" />   

    <input name="client_phone" id="client_phone" type="hidden" value="<?php echo $student_phone; ?>" />

    <input name="amt_paid" id="amt_paid" type="hidden" value="<?php echo str_replace(',', '', number_format($room[0]['amount'], 2)); ?>" />  
        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Student<span class="asterik">*</span></label>
                    <select class="form-control" name="student" id="student"  onchange="getstudent(this)">
                        <option value="Student">Select Student</option>
                        <?php
                        foreach ($first_name as $row) {
                            echo "<option value='" . $row['matric_no'] . "'>" . $row['first_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
						 <h3>Room : <?php echo $room[0]['room']; ?></h3>
						 <h3>Hostel :<?php echo $dbobject->getitemlabel('hostel', 'id', $room[0]['hostel'], 'hostel_type'); ?></h3>
						 <h3>Block :<?php echo $room[0]['block']; ?></h3>
                         <h3>Amount :<?php echo $room[0]['amount']; ?></h3>
				    </div>
            </div>

        </div>
        <!-- <div class="row mb-3">
            <div class="col-sm-6">
                <div id="icon-display" align="center" style="font-size:20px">
                    <?php echo "<i class='bi " . $fonts[0]['code'] . "'></i>"; ?>
                </div>
            </div>
        </div> -->

        <?php include("form-footer.php"); ?>

        <div id="err"></div>
        <button id="save_facility" type="submit" class="btn btn-primary mb-1">Submit</button>

    </form>
</div>
<script>
    function getstudent(id) {
        var selected = $(id).children('option:selected').val(),
            dd = {
                op: 'room.getstudent',
                room_id: '<?php echo $id; ?>',
                matric_no: selected 
            };
        $.post("utilities.php", dd, function(re) {
            //   alert(re.client_email);
            //   alert(re.client_email);
            //   alert(re.client_email);
                // $("#client_email").val(re.amount);
                if(re.response_code == 0){
                $("#client_email").val(re.data.email);
                $("#client_name").val(re.data.first_name);
                $("#client_phone").val(re.data.phone_no);
                $("#merch_trans_id").val(re.data.myuid);
                }else{
                    alert(re.response_message)
                }
               
            
        }, 'json');
    }
    // function gethostelBlock(id) {
    //     var selected = $(id).children('option:selected').val(),
    //         dd = {
    //             op: 'room.hostelselect',
    //             id: selected
    //         };
    //     $.post("utilities.php", dd, function(re) {

    //         $("#block").html(re);


    //     }, 'json');
    // }

    // function saveAnother() {
    //     $("#save_facility").text("Loading......");
    //     var dd = $("#form1").serialize();
    //     $.post("utilities.php", dd, function(re) {
    //         $("#save_facility").text("Save");
    //         console.log(re);
            
    //         if (re.response_code == 0) {

    //             $("#err").css('color', 'green')
    //             $("#err").html(re.response_message)
    //             getpage('roomList.php', 'page');

    //         } else {
    //             regenerateCORS();
    //             $("#err").css('color', 'red')
    //             $("#err").html(re.response_message)
    //             $("#warning").val("0");
    //         }

    //     }, 'json')
    // }

    //    function automatic()
    //    {
    //        if($("#auto").is(':checked'))
    //        {
    //            $("#auto_val").val(1)
    //        }else{
    //             $("#auto_val").val(0)
    //        }
    //    }
    // //    
    // function fetchLga(el) {
    //     getRegions(el);
    //     $("#lga-fds").html("<option>Loading Lga</option>");
    //     $.post("utilities.php", {
    //         op: 'Church.getLga',
    //         state: el
    //     }, function(re) {
    //         $("#lga-fds").empty();
    //         $("#lga-fds").html(re.state);

    //     }, 'json');
    //     //        $.blockUI();
    // }

    // function getRegions(state_id) {
    //     $("#church_region_select").html("<option>Loading....</option>");
    //     $.post("utilities.php", {
    //         op: 'Church.getRegions',
    //         state: state_id
    //     }, function(re) {
    //         $("#church_region_select").empty();
    //         $("#church_region_select").html(re);

    //     });
    // }

    // function fetchAccName(acc_no) {
    //     if (acc_no.length == 10) {
    //         var account = acc_no;
    //         var bnk_code = $("#bank_name").val();
    //         $("#acc_name").text("Verifying account number....");
    //         $("#account_name").val("");
    //         $.post("utilities.php", {
    //             op: "Church.getAccountName",
    //             account_no: account,
    //             bank_code: bnk_code
    //         }, function(res) {

    //             $("#acc_name").text(res);
    //             $("#account_name").val(res);
    //         });
    //     } else {
    //         $("#acc_name").text("Account Number must be 10 digits");
    //     }

    // // }

    // function display_icon(ee) {
    //     $("#icon-display").html(`<i class="${ee}"></i>`);
    // }
</script>