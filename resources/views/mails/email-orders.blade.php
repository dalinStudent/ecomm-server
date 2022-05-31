<!DOCTYPE html>
<html>
<head>
<title>Your Email</title>
</head>
<body>
<h1>Dear customer,</h1> <h3><i>{{$email}}</i></h3>
<p>
    We've received your order and will get started on it right away.
</p>
<p>
    You can expect to received a shipping confimation email soon. 
</p>

<p>Thank you for shppoing with Online Phone Sale!</p>
{{ url('http://127.0.0.1:8000/home', []) }}
</body>
</html>