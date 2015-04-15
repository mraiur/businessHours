<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>hours calculator</title>

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="bower_components/jquery-numeric/dist/jquery-numeric.js"></script>
</head>
<body>
    <form id="calculateForm">
        <div class="form-group">
            <label for="minutes">Minutes</label>
            <input type="text" class="number form-control" id="minutes" placeholder="Minutes">
        </div>
        <div class="form-group">
            <label for="minutes">Hours</label>
            <input type="text" class="number form-control" id="hours" placeholder="Hours">
        </div>
        <div class="form-group">
            <label for="submitDate">Submit date</label>
            <input type="text" class="form-control" id="submitDate" placeholder="submitDate">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <div id="msg">

    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#submitDate").datepicker({
                format: "yyyy-mm-dd"
            });

            $(".number").numeric({
                negative : false
            });

            $("#calculateForm").submit(function(e){
                e.preventDefault();
                $.post('server.php', $(this).serialize(), function(res){
                    console.log(res);
                });
            });
        });
    </script>
</body>
</html>
