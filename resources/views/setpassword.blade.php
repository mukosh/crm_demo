<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<script type="text/javascript">
    $(document).ready(function(){
        $('.pass_show').append('<span class="ptxt">Show</span>');  
        }); 
        $(document).on('click','.pass_show .ptxt', function(){  
        $(this).text($(this).text() == "Show" ? "Hide" : "Show");  
        $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });  
    });   
</script>
<style type="text/css"> 
    .pass_show{position: relative}  
    .pass_show .ptxt {  
        position: absolute;  
        top: 50%;  
        right: 10px; 
        z-index: 1;  
        color: #f36c01; 
        margin-top: -10px; 
        cursor: pointer;  
        transition: .3s ease all; 

    }  
.pass_show .ptxt:hover{color: #333333;} 
</style>

<?php //echo $token;?>
<div class="container password-form">
    <form action="/demo/updatepassword/{{ $token }}" method="GET">
        <div class="row">
            <div class="col-sm-4"> 
                <label>Password</label>
                <div class="form-group pass_show"> 
                    <input type="password" name="pass" value="{{old('pass')}}" class="form-control" placeholder="Password"> 
                </div> 
                @error('pass')
                      <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label>Confirm Password</label>
                <div class="form-group pass_show"> 
                    <input type="password" name="cpass" value="{{old('cpass')}}" class="form-control" placeholder="Confirm Password"> 
                </div>
                @error('cpass')
                      <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div>
                    <button name="update" class="btn btn-primary">Update</button>
                </div> 
                
            </div>  
        </div>
    </form>
   
</div>