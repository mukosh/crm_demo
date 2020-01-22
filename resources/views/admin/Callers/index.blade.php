  @extends('admin.template.layout')

@section('content') 
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Caller</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Caller Id</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Callers Id Listing</h3>

                <div class="card-tools">
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ route('callers.create') }}">Add Caller</a>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Client ID</th>
                      <th>Caller Id</th>
                      <th>Verify Status</th> 
                      <th>Created</th> 
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($callers as $caller)
                    <tr>
                       <td><a href="#" class="viewclient" data-toggle="modal" data-id="{{ $caller->c_id }}" data-target="#viewclient">{{ $caller->c_id }}</a></td>
                        <td>{{ $caller->caller_id }}</td>
                        <td>@if ($caller->is_verify === 1) ✔️ @else <a href="" class="sendOtp" data-toggle="modal" data-id="{{ $caller->id }}" data-target="#myModal">❌</a> @endif</td> 
                        <td>{{ $caller->created_at->format('jS F Y') }}</td>
                        
                        <td>
                            <form action="{{ route('callers.destroy', $caller->id) }}" method="POST">
                                <!-- <a class="btn btn-info" href="">Show</a> -->
                                <!-- <a class="btn btn-primary" href="{{ route('callers.edit', $caller->id) }}">Edit</a> -->
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/> 
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
                            </form>
                        </td> 
                    </tr>
                    @endforeach
                     
                  </tbody>
                </table>
              </div>
                {!! $callers->links() !!}
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
   
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
  <!-- /.content-wrapper -->
    
    
<div id="viewclient" class="modal fade" role="dialog">
  <div class="modal-dialog">
       
<table class="responstable"> 
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone Number</th>
    <th>Company Name</th>
    <th>Description</th>
  </tr>       
  <tr>
    <td><p id="name"></p></td>
    <td><p id="email"></p></td>
    <td><p id="company"></p></td>
    <td><p id="phone"></p></td>
    <td><p id="description"></p></td>
  </tr>
  
  <tr>
    <th>Address</th>
    <th>Pin code</th>
    <th>Call Limit</th>
    <th>Pacing</th>
    <th>Balance</th>
  </tr>       
  <tr>
    <td><p id="address"></p></td>
    <td><p id="pincode"></p></td>
    <td><p id="call_limit"></p></td>
    <td><p id="pacing"></p></td>
    <td><p id="balance"></p></td>
  </tr>
  
  <tr>
    <th>Country</th>
    <th>State</th>
    <th>City</th>
    <th>Status</th>
    <th>Created</th>
  </tr> 
  <tr>
    <td><p id="country"></p></td>
    <td><p id="state"></p></td>
    <td><p id="city"></p></td>
    <td><p id="status"></p></td>
    <td><p id="created_at"></p></td>
  </tr>
  
</table>

  </div>
</div>

<div id="myModal" class="modal fade" role="dialog"> 
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Caller Id Verification</h4>
         <p id="success_msg" style="color:green;"></p>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body"> 
        <form class="col s12" method="post" id="submit" action="{{url('caller/calleridverifyajax')}}">
           <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
          <div class="row">
           
            <div class="col">
               <label>OTP</label>
              <input type="text" name="otp" class="form-control" id="otp" placeholder="Enter your otp">
            </div> 
          </div><br>
           
          <div class="row" align="center">
            <div class="col">
              <button class="btn btn-primary verifycallerid" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </div> 
    </div> 
  </div>
</div>  
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript"> 
  $( document ).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      }); 
      $('.sendOtp').on('click', function(){
          var id = $(this).attr("data-id"); 
          $.ajax({
              type: "POST",
              url: '{{url("sendOtp")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {id: id}, 
              dataType: "json",
              cache: false,
              success: function(result) {  
                 console.log(result); 
              } 
          });   
      });
      $('.viewclient').on('click',function(){
      var clientId = $(this).attr("data-id"); 
      $.ajax({
              type: "POST",
              url: '{{url("clients/viewclient")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {clientId: clientId}, 
              dataType: "json",
              cache: false,
              success: function(result) {  
                $('#name').text(result[0].fname+' '+result[0].lname);
                $('#email').text(result[0].email);
                $('#company').text(result[0].company);
                $('#phone').text(result[0].phone);
                $('#description').text(result[0].description);
                $('#address').text(result[0].address);
                $('#pincode').text(result[0].pincode);
                $('#call_limit').text(result[0].call_limit);
                $('#pacing').text(result[0].pacing);
                $('#city').text(result[0].city);
                $('#country').text(result[0].country);
                $('#state').text(result[0].state);
                $('#balance').text(result[0].balance);
                $('#status').text(result[0].status);
                $('#created_at').text(result[0].created_at); 
              } 
          });   
      });

      $.validator.addMethod("alphabetsnspace", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
      });
      $.validator.addMethod("pnum", function(value, element) {
          return this.optional(element) || /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/.test(value);
      });

      $("#submit").validate({ 
          rules: { 
            otp:{
              required: true,
              pnum: true,
              remote: {                   
                url: '{{ url("checkCallerValidOtp")}}'+'?_token=' + '{{ csrf_token() }}', 
                type: "POST",                    
                data: {  
                    otp: function() {
                          return $( "#otp" ).val();
                        }
                  }                   
              }
            },  
          },
          //For custom messages
          messages: {  
            otp: {
              required: "Enter your OTP",
              pnum: "Please enter only number"
            },  
          },
          errorElement: 'div',
          errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
              $(placement).append(error)
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function(form) { 
          $.ajax({ 
              url:form.action,
              type:form.method,
              data:$(form).serialize(), 
              success: function(data){
                $("#success_msg").html(data);
                var msg = window.setTimeout(function(){location.reload()},2000);
                if(msg){
                 window.location.replace('{{url("callers")}}');
                }
              }
          }); 
        } 
    });
  });
</script>
<style type="text/css">
  .error-msg{
   background-color: #FF0000;
}
</style>
<style type="text/css"> 
.responstable {
  margin: 5em 0;
  width: 180%;
  margin: 130px 82px 0px -176px;
  overflow: hidden;
  background: #FFF;
  color: #024457;
  border-radius: 10px;
  border: 1px solid #167F92;
}
.responstable tr {
  border: 1px solid #D9E4E6;
}
.responstable tr:nth-child(odd) {
  background-color: #EAF3F3;
}
.responstable th {
  display: none;
  border: 1px solid #FFF;
  background-color: #167F92;
  color: #FFF;
  padding: 1em;
}
.responstable th:first-child {
  display: table-cell;
  text-align: center;
}
.responstable th:nth-child(2) {
  display: table-cell;
}
.responstable th:nth-child(2) span {
  display: none;
}
.responstable th:nth-child(2):after {
  content: attr(data-th);
}
@media (min-width: 480px) {
  .responstable th:nth-child(2) span {
    display: block;
  }
  .responstable th:nth-child(2):after {
    display: none;
  }
}
.responstable td {
  display: block;
  word-wrap: break-word;
  max-width: 7em;
}
.responstable td:first-child {
  display: table-cell;
  text-align: center;
  border-right: 1px solid #D9E4E6;
}
@media (min-width: 480px) {
  .responstable td {
    border: 1px solid #D9E4E6;
  }
}
.responstable th, .responstable td {
  text-align: left;
  margin: .5em 1em;
}
@media (min-width: 480px) {
  .responstable th, .responstable td {
    display: table-cell;
    padding: 1em;
  }
}

body {
  padding: 0 2em;
  font-family: Arial, sans-serif;
  color: #024457;
  background: #f2f2f2;
}

h1 {
  font-family: Verdana;
  font-weight: normal;
  color: #024457;
}
h1 span {
  color: #167F92;
}

</style>