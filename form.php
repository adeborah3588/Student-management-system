

<style>
.form-inline {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
  }
  .form-inline input {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  background-color: #fff;
  border: 1px solid #ddd;
}
.form-inline button {
  padding: 10px 20px;
  background-color: dodgerblue;
  border: 1px solid #ddd;
  color: white;
}
.form-inline input {
    margin: 10px 0;
  }
  .form-inline {
    flex-direction: column;
    align-items: stretch;
  }
</style>

   
<div>
    <h1>
        Register
    </h1>
    <p>
        Already have an account? <a href="login.php">Login!</a>
    </p>
    <form class="form-inline" id="form1" onsubmit="return false" method="post">
        <input type="hidden" name="op" value="first.saveUser">
        <input type="hidden" name="operation" value="new">
        <input type="hidden" name="idd" value="<?php echo $id; ?>">
        <input type="text" name="username" placeholder="username">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
        <div id="err"></div>
        <button type="submit" name="submit" id="save_facility"  onclick="saveRecord()">REGISTER</button>
    </form>
</div>
<script>

    function saveRecord() {
        $("#save_facility").text("Loading......");
        var dd = $("#form1").serialize();
        $.post("utilities.php", dd, function(re) {
            $("#save_facility").text("Save");
            console.log(re);
            if (re.response_code == 0) {

                $("#err").css('color', 'green')
                $("#err").html(re.response_message);

                setTimeout(function(){
                    getpage('userList.php', 'page');
                }, 5000);

            } else {
                regenerateCORS();
                $("#err").css('color', 'red')
                $("#err").html(re.response_message)
                $("#warning").val("0");
            }

        }, 'json')
    }
</script>
   

