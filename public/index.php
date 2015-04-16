<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>hours calculator</title>

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/datetimepicker/jquery.datetimepicker.css">
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="bower_components/datetimepicker/jquery.datetimepicker.js"></script>
    <script src="bower_components/jquery-numeric/dist/jquery-numeric.js"></script>
</head>
<body>
    <form id="calculateForm">
        <div class="form-group">
            <label for="minutes">Minutes</label>
            <input type="text" name="minutes" class="number form-control" id="minutes" placeholder="Minutes">
        </div>
        <div class="form-group">
            <label for="hours">Hours</label>
            <input type="text" name="hours" class="number form-control" id="hours" placeholder="Hours">
        </div>
        <div class="form-group">
            <label for="submitDate">Submit date</label>
            <input type="text" name="submitDate" class="form-control" id="submitDate" placeholder="submitDate">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <div id="msg">

    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#submitDate").datetimepicker({
                format: "Y-m-d H:i",
                inline:true,
                allowTimes:[ '8:00','8:15','8:30','8:45', '9:00','9:15','9:30','9:45','10:00','10:15','10:30','10:45',
                    '11:00','11:15','11:30','11:45', '12:00','12:15','12:30','12:45', '13:00','13:15','13:30','13:45',
                    '14:00','14:15','14:30','14:45', '15:00','15:15','15:30','15:45', '16:00','16:15','16:30','16:45'],
            });

            $(".number").numeric({
                negative : false
            });

            $("#calculateForm").submit(function(e){
                e.preventDefault();
                console.log($(this).serialize());
                $.post('server.php', $(this).serialize(), function(res){
                console.log(res);
                    $("#msg").html(
                        "STATUS: "+res.status+"<br />"+
                        "RESPONCE: "+res.result
                    );
                }, 'json');
            });
        });
    </script>
</body>
</html>
