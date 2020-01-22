<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Form</title>
 

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
    * {box-sizing: border-box;}
.main{
  padding-top: 10px;
  padding-bottom: 0px;
  height: 100%;
  width: 100%;
  background-color: #F4F5F7;
} 

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}
.container{
    width: 40%;
}

button {
  background-color: #002C47;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
} 
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color:  coral;
} 
.imgcontainer {
  text-align: center; 
} 
img.avatar {
  width: 150px;
  height: auto;
  border-radius: 50%;
} 
span.psw {
  float: right;
  padding-top: 16px;
} 
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }
  .cancelbtn {
    width: 100%;
  }
}
</style>
</head>
<body class="main"> 
    <div class="main"> 
        <form method="post" action="{{ url('main/login')}}">
            {{ csrf_field() }}
            <div class="imgcontainer">
                <img src="{{ URL::asset('public/images/user.png')}} " alt="Avatar" class="avatar">
            </div> 
            @if(isset(Auth::user()->email))
            <script> window.location="{{ url('main') }}";</script>
            @endif 
            @if($message = Session::get('error'))
                <div class="alert alert-danger alert-block"> 
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong> {{ $message }} </strong>
                </div>
            @endif
            @if($message = Session::get('success'))
                <div class="alert alert-success alert-block"> 
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong> {{ $message }} </strong>
                </div>
            @endif
            <div class="container">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="email" value="{{ old('email') }}" > 
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password"  value="{{ old('password') }}" > 
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" name="login">Login</button> 
            </div> 
        </form> 
    </div>  
</body>
</html>                                                                 