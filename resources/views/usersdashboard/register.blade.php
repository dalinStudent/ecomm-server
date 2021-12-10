@extends('usersdashboard.usersdashboard')
	@section('content')
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<link href="css/custom.css" rel="stylesheet">
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content mt-5">
		<div id="page-wrapper">
			<div class="main-page signup-page" style="margin-top:100px;">
				<h2 class="title1">SignUp Here</h2>
				<div class="sign-up-row widget-shadow">
					<h5>Personal Information :</h5>
				<form id="registrationForm" method="POST" action="{{ url('/register') }}">
				{{ csrf_field() }}
					<div class="sign-u">
						<input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
					    <div class="clearfix"> </div>
					</div>
					<div class="sign-u">
						<input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
						<div class="clearfix"> </div>
					</div>
					<div class="sign-u">
						<input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number" required>
						<div class="clearfix"> </div>
					</div>
					<div class="sign-u">
						<input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
						<div class="clearfix"> </div>
					</div>
					<div class="sign-u">
						<input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Address" required>
						<div class="clearfix"> </div>
					</div>
					<div class="sign-u">
						<input type="password" id="password" name="password" value="" placeholder="Password" required>
						<div class="clearfix"> </div>
					</div>
					<div class="sub_home">
							<input type="submit" value="Submit">
						<div class="clearfix"> </div>
					</div>
					<div class="registration">
						Already Registered.
						<a class="" href="{{url('/login')}}">
							Login
						</a>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#registrationForm').submit(function(e){
                    e.preventDefault();
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var phone_number = $('#phone_number').val();
                var email = $('#email').val();
                var address = $('#address').val();
                var password = $('#password').val();
                $.ajax({
                    type:"POST",
                    url: "{{ url('http://127.0.0.1:8000/api/register') }}",
                    dataType: 'json',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        first_name:first_name,
                        last_name:last_name,
                        phone_number:phone_number,
                        email:email,
                        address:address,
                        password:password,
                    },
                    
                    success: function(data){
                        console.log('succesfull')
                    },
                    error: function(data){
                        console.log('error')
                    }
                });;
            });
        });
      </script>
	
</body>
@endsection
</html>