<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container ">
    <h4 style="color: #E31E1A;">ID Card Application Details</h4>
    <h6><b>Details</b></h6>
    @php
        $cutnric = substr($courses->nric, -4);
        $nric = "XXXXX$cutnric";
    @endphp
    <h6><b>NRIC / FIN</b> &ensp;: {{$nric}}</h6>
    <h6><b>Name </b> &ensp;&ensp;&ensp;&ensp;: {{$nric}}</h6>


</div>

</body>
</html>
