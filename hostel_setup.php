<?php
include_once("../libs/dbfunctions.php");
include_once("../class/hostel.php");
$dbobject = new dbobject();
//$sql = "SELECT DISTINCT(State) as state,stateid FROM lga order by State";
//$states = $dbobject->db_query($sql);
//
//$sql2 = "SELECT bank_code,bank_name FROM banks WHERE bank_type = 'commercial' order by bank_name";
//$banks = $dbobject->db_query($sql2);
//
//$sql_pastor = "SELECT username,firstname,lastname FROM userdata WHERE role_id = '003'";
//$pastors = $dbobject->db_query($sql_pastor);

$sql = "SELECT * FROM font_awsome ORDER BY code ";
$fonts = $dbobject->db_query($sql);




// $sql = "SELECT DISTINCT(course) as course,id FROM course order by course";
// $course = $dbobject->db_query($sql);


$hostel = [];
if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $operation = 'edit';
    $id = $_REQUEST['id'];
    $sql_menu = "SELECT * FROM hostel WHERE id = '$id' LIMIT 1";
    file_put_contents("deborah.txt",$sql_menu);
    $hostel = $dbobject->db_query($sql_menu);
}else
{
    $operation = 'new';
}
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
    <h4 class="modal-title" style="font-weight:bold">hostel Setup</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
       <input type="hidden" name="op" value="hostel.saveHostel">
       <input type="hidden" name="operation" value="<?php echo $operation; ?>">
       <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="row">
                        <div class="col-sm-6">
								<div class="form-group">
									<label class="form-label">Hostel Type<span class="asterik">*</span></label>
									<input type="text" name="hostel_type" value="<?php echo $hostel[0]['hostel_type']; ?>" class="form-control" autocomplete="off">
								</div>
                                
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-label">Block<span class="asterik">*</span></label>
									<input type="text" name="block" value="<?php echo $hostel[0]['block']; ?>" class="form-control" autocomplete="off">
								</div>
							</div>
							
		                </div>
                        
						
                       
                        
                    <div>
                
        
        </div>
        <div class="row mb-3">
            <div class="col-sm-6">
                <div id="icon-display" align="center" style="font-size:20px">
                        <?php echo "<i class='bi ".$fonts[0]['code']."'></i>"; ?>
                    </div>
            </div>
        </div>
        
        <?php include("form-footer.php"); ?>
       
       <div id="err"></div>
        <button id="save_facility" onclick="saveAnother()" class="btn btn-primary mb-1">Submit</button>
        
        </form>
</div>
<script>
    function saveAnother()
    {
        $("#save_facility").text("Loading......");
        var dd = $("#form1").serialize();
        $.post("utilities.php",dd,function(re)
        {
            $("#save_facility").text("Save");
            console.log(re);
            if(re.response_code == 0)
                {
                    
                    $("#err").css('color','green')
                    $("#err").html(re.response_message)
                    getpage('hostelList.php','page');
                    
                }
            else
                {
                    regenerateCORS();
                     $("#err").css('color','red')
                    $("#err").html(re.response_message)
                    $("#warning").val("0");
                }
                
        },'json')
    }
    
//    function automatic()
//    {
//        if($("#auto").is(':checked'))
//        {
//            $("#auto_val").val(1)
//        }else{
//             $("#auto_val").val(0)
//        }
//    }
//    
    function fetchLga(el)
    {
        getRegions(el);
        $("#lga-fds").html("<option>Loading Lga</option>");
        $.post("utilities.php",{op:'Church.getLga',state:el},function(re){
            $("#lga-fds").empty();
            $("#lga-fds").html(re.state);
            
        },'json');
//        $.blockUI();
    }
    function getRegions(state_id)
    {
        $("#church_region_select").html("<option>Loading....</option>");
        $.post("utilities.php",{op:'Church.getRegions',state:state_id},function(re){
            $("#church_region_select").empty();
            $("#church_region_select").html(re);
            
        });
    }
    
    function fetchAccName(acc_no)
    {
        if(acc_no.length == 10)
            {
                var account  = acc_no;
                var bnk_code = $("#bank_name").val();
                $("#acc_name").text("Verifying account number....");
                $("#account_name").val("");
                $.post("utilities.php",{op:"Church.getAccountName",account_no:account,bank_code:bnk_code},function(res){
                    
                    $("#acc_name").text(res);
                    $("#account_name").val(res);
                });
            }else{
                $("#acc_name").text("Account Number must be 10 digits");
            }
        
    }
    function display_icon(ee)
    {
        $("#icon-display").html(`<i class="${ee}"></i>`);
    }
</script>