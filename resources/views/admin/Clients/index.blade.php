@extends('admin.template.layout')

@section('content') 
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Client</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Client</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12"> 
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Client Record</h3>
               <div class="pull-right" align="right">
                        <a class="btn btn-success" href="{{ route('clients.create') }}">Create Client</a>
                    </div>
            </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block"> 
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong> {{ $message }} </strong>
                    </div>
                @endif
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>  
                      <th>Id</th>
                      <th>Name</th>
                      <th>Call Limit</th>
                      <th>Balance</th> 
                      <th>Created</th>
                      <th>Status</th>
                      <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 
                 @foreach ($clients as $client)
                    <tr> 
                       <td><a href="#" class="viewclient" data-toggle="modal" data-id="{{ $client['id'] }}" data-target="#viewclient">{{ $client['id'] }}</a></td>
                        <td>{{ $client['fname'].' '.$client['lname'] }}</td>
                        <td>{{ $client['call_limit'] }}</td>
                        <td>{{ $client['balance'] }}</td> 
                        <td>{{ $client['created_at'] }}</td>
                        <td>{{ $client['status'] }}</td>
                        <td align="center">
                            <form action="{{ route('clients.destroy', $client['id']) }}" method="POST"> 
                               <!--  <button type="button" class="btn btn-info viewclient" data-toggle="modal" data-id="{{ $client['id'] }}" data-target="#viewclient">Show</button> -->
                                <a class="btn btn-primary" href="{{ route('clients.edit', $client['id']) }}">Edit</a>
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/> 
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button> 
                                <button type="button" class="btn btn-warning showbalance" data-toggle="modal" data-cid="{{ $client['id'] }}" data-target="#myModal">Add Balance</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach 
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
 <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Balance</h4>
         <p id="success_msg" style="color:green;"></p>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body"> 
         <form class="col s12" method="post" id="submit" action="{{url('clients/createbalance')}}">
          <div class="row">
            <div class="col"> 
              <input type="hidden" name="client_id" id="client_id">
              <label>Balance</label>
              <input type="text" name="balance" class="form-control" id="balance" readonly>
            </div>
            <div class="col input-field">
               <label>Amount</label>
              <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount">
            </div> 
          </div><br>
          <div class="row">
            <div class="col-sm-12">
               <label>Description</label>
              <textarea type="text" name="description" class="form-control" id="description" placeholder="Description"></textarea>
            </div>
          </div><br>
          <div class="row" align="center">
            <div class="col">
              <button class="btn btn-primary addbalance" type="submit">Add</button>
            </div>
          </div>
        </form>
      </div> 
    </div>

  </div>
</div>
  <!-- client view --> 
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
        <td><p id="client_name"></p></td>
        <td><p id="client_email"></p></td>
        <td><p id="client_phone"></p></td>
        <td><p id="client_company"></p></td>
        <td><p id="client_description"></p></td>
      </tr>
      
      <tr>
        <th>Address</th>
        <th>Pin code</th>
        <th>Call Limit</th>
        <th>Pacing</th>
        <th>Balance</th>
      </tr>       
      <tr>
        <td><p id="client_address"></p></td>
        <td><p id="client_pincode"></p></td>
        <td><p id="client_call_limit"></p></td>
        <td><p id="client_pacing"></p></td>
        <td><p id="client_balance"></p></td>
      </tr>
      
      <tr>
        <th>Country</th>
        <th>State</th>
        <th>City</th>
        <th>Status</th>
        <th>Created</th>
      </tr> 
      <tr>
        <td><p id="client_country"></p></td>
        <td><p id="client_state"></p></td>
        <td><p id="client_city"></p></td>
        <td><p id="client_status"></p></td>
        <td><p id="client_created_at"></p></td>
      </tr> 
    </table> 
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
       $('.showbalance').on('click', function () { 
          var clientId = $(this).attr("data-cid");  
          $.ajax({
                type: "POST",
                url: '{{url("clients/balance")}}'+'?_token=' + '{{ csrf_token() }}',
                data: {clientId: clientId}, 
                dataType: "json",
                cache: false,
                success: function(result) {  
                  $('#client_id').val(result[0].id);
                  $('#balance').val(result[0].balance);
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
            amount:{
              required: true,
              pnum: true,
            }, 
            description: {
              required: true, 
            }, 
          },
          //For custom messages
          messages: {  
            amount: {
              required: "Enter your Amount",
              pnum: "Please enter only number"
            }, 
            description: {
              required: "Enter your description" 
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
                           window.location.replace('{{url("clients")}}');
                          }
                   }
                 }); 
            
        }

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
                var lastname = result[0].lname;
                if(lastname == null){ lastname = ''}else{ lastname = lastname }   
                var client_name = result[0].fname+' '+lastname;  
                if(client_name == null){client_name = 'Not Available'}else{ client_name = client_name;} 
                $('#client_name').text(client_name);

                var client_email = result[0].email;  
                if(client_email == null){client_email = 'Not Available'}else{ client_email = client_email;} 
                $('#client_email').text(client_email); 
               
                var client_company = result[0].company;  
                if(client_company == null){client_company = 'Not Available'}else{ client_company = client_company;} 
                $('#client_company').text(client_company);  

                var client_phone = result[0].phone;  
                if(client_phone == null){client_phone = 'Not Available'}else{ client_phone = client_phone;} 
                $('#client_phone').text(client_phone);  
                
                var client_description = result[0].description;  
                if(client_description == null){client_description = 'Not Available'}else{ client_description = client_description;} 
                $('#client_description').text(client_description);

                var client_address = result[0].address;  
                if(client_address == null){client_address = 'Not Available'}else{ client_address = client_address;} 
                $('#client_address').text(client_address);

                var client_pincode = result[0].pincode;  
                if(client_pincode == null){client_pincode = 'Not Available'}else{ client_pincode = client_pincode;} 
                $('#client_pincode').text(client_pincode);
                
                var client_call_limit = result[0].call_limit;  
                if(client_call_limit == null){client_call_limit = 'Not Available'}else{ client_call_limit = client_call_limit;} 
                $('#client_call_limit').text(client_call_limit);

                var client_pacing = result[0].pacing;  
                if(client_pacing == null){client_pacing = 'Not Available'}else{ client_pacing = client_pacing;} 
                $('#client_pacing').text(client_pacing);
                
                var client_city = result[0].pacing;  
                if(client_city == null){client_city = 'Not Available'}else{ client_city = client_city;} 
                $('#client_city').text(client_city); 
                 
                var client_country = result[0].country;  
                if(client_country == null){client_country = 'Not Available'}else{ client_country = client_country;} 
                $('#client_country').text(client_country); 

                var client_state = result[0].state;  
                if(client_state == null){client_state = 'Not Available'}else{ client_state = client_state;} 
                $('#client_state').text(client_state); 

                var client_balance = result[0].balance;  
                if(client_balance == null){client_balance = 'Not Available'}else{ client_balance = client_balance;} 
                $('#client_balance').text(client_balance); 
                 
                var client_status = result[0].status;  
                if(client_status == null){client_status = 'Not Available'}else{ client_status = client_status;} 
                $('#client_status').text(client_status); 

                var client_created_at = result[0].created_at;  
                if(client_created_at == null){client_created_at = 'Not Available'}else{ client_created_at = client_created_at;} 
                $('#client_created_at').text(client_created_at);  
              } 
          });   
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