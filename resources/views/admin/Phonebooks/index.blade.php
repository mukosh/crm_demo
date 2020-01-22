@extends('admin.template.layout')

@section('content')  
<meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="content-wrapper"> 
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Phone Book</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Phonebook</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div> 
    <section class="content">
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Phonebook Listing</h3> 
                <div class="card-tools">
                    <div class="pull-right"> 
                        <a class="btn btn-success" href="{{ route('phonebooks.create') }}">Add Phonebook</a>
                    </div>
                </div> 
              </div> 
                @if ($message = Session::get('success')) 
                    <div class="alert alert-success alert-block col-6 text-center"> 
                      <button type="button" class="close" data-dismiss="alert">x</button>
                      <strong> {{ $message }} </strong>
                    </div>
                @endif
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Client Id</th>
                      <th>Client Name</th> 
                      <th>Phonebook Name</th>
                      <th>Created</th> 
                      <th colspan="5">Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach ($phonebooks as $phonebook)
                    <tr>
                        <td><a href="#" class="viewclient" data-toggle="modal" data-id="{{ $phonebook->client_id }}" data-target="#viewclient">{{ $phonebook->client_id }}</a></td>
                        <td>{{ $phonebook->fname.' '.$phonebook->lname }}</td>  
                        <td>{{ $phonebook->phonebook_name }}</td>
                        <td>{{ $phonebook->created_at->format('jS F Y') }}</td>
                        
                        <td>
                            <form action="{{ route('phonebooks.destroy', $phonebook->id) }}" method="POST">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/> 
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">❌</button>
                                @if($phonebook->is_otp != 1)
                                <a class="btn btn-primary send_otp" href="#" data-cid="{{ $phonebook->client_id }}" data-id="{{ $phonebook->id }}" data-target="#pb_otp" data-toggle="modal">📥</a>
                                @else
                                <a class="btn btn-primary download_excel" href="{{ route('export_excel.excel') }}?table={{ $phonebook->phonebook_name }}&id={{ $phonebook->id }}">Download</a> 
                                @endif
                                <a class="btn btn-warning" href="{{ route('phonebooks.edit', $phonebook->id) }}">📤</a> 
                                <a class="btn btn-default contact_popup" href="#" data-id="{{ $phonebook->id }}" data-target="#contact_modal" data-toggle="modal">➕</a> 
                                <a class="btn btn-info search_popup" href="#" data-id="{{ $phonebook->id }}" data-target="#search_modal" data-toggle="modal">🔎</a>
                               <!--  <a class="btn btn-primary" href="{{ route('phonebooks.edit', $phonebook->id) }}">Edit</a> --> 
                            </form>
                        </td>
                    </tr>
                    @endforeach 
                  </tbody>
                </table>
              </div>
                {!! $phonebooks->links() !!} 
            </div> 
          </div>
        </div> 
      </div> 
    </section> 

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

<div id="contact_modal" class="modal fade" role="dialog"> 
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Contact</h4>
         <p id="success_msg" style="color:green;"></p>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body"> 
        <form class="col s12" method="post" id="submit" action="{{url('phonebooks/addcontactajax')}}">
           <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
          <div class="row">
           
            <div class="col">
               <label>Contact</label>
              <input type="hidden" name="phonebook_table" id="phonebook_table">
              <input type="text" name="contact" class="form-control" id="contact" placeholder="Enter contact number">
            </div> 
          </div><br>
           
          <div class="row" align="center">
            <div class="col">
              <button class="btn btn-primary addcontact" type="submit">Add</button>
            </div>
          </div>
        </form>
      </div> 
    </div> 
  </div>
</div>
<!-- search popup  -->
<div id="search_modal" class="modal fade" role="dialog"> 
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Search Contact</h4>
         <p id="success_msg" style="color:green;"></p>
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
        <div class="modal-body">  
          <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
          <div class="row"> 
            <div class="col">
              <label>Search Contact</label> 
              <input type="hidden" name="pb_table" id="pb_table">
              <input type="search" name="contact_number" class="form-control" id="contact_number" placeholder="Search...." onclick="this.value=''">
            </div>
          </div>  
          <div class="card-body table-responsive p-0">
            <p id="output"></p> 
          </div> 
        </div>
      </div> 
    </div> 
  </div>
</div>
<!-- send OTP popup -->
<div id="pb_otp" class="modal fade" role="dialog"> 
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">OTP for Download Contact</h4>
         <p class="success_msg" style="color:green;"></p>
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body"> 
        <form class="col s12" method="post" id="submit_pb_otp" action="{{url('phonebook/check_pb_otp_ajax')}}">
           <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
          <div class="row"> 
            <div class="col">
               <label>OTP</label>
               <input type="hidden" name="pb_id" id="pb_id" value="">
              <input type="text" name="otp" class="form-control" id="otp" placeholder="Enter your otp">
            </div> 
          </div><br> 
          <div class="row" align="center">
            <div class="col">
             <button class="btn btn-primary verified_pb_otp" type="submit">Submit</button>
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
      $.validator.addMethod("alphabetsnspace", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
      });
      $.validator.addMethod("pnum", function(value, element) {
          return this.optional(element) || /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/.test(value);
      });

      $("#contact_number").keyup(function(e){ 
        var search_data = $('#contact_number').val();
        var pb_table = 'phonebook_'+$('#pb_table').val();
       // var pb_table = 'phonebook_phonebook_15012020_9042484682';
        var sd = null;
        if(search_data.length >= 9){
          sd = search_data;
        }
         e.preventDefault(); 
        if(sd != null)
        { 
          $.ajax({
             type:"POST", 
             url: '{{url("search_contact")}}'+'?_token=' + '{{ csrf_token() }}',
             data:{search_data: sd, pb_table:pb_table},
             success:function(data){
                $('#output').html(data);
             }
          });
        }else{
          $.ajax({
             type:"POST", 
             url: '{{url("search_contact")}}'+'?_token=' + '{{ csrf_token() }}',
             data:{search_data: 'null', pb_table:pb_table},
             success:function(data){
                $('#output').html(data);
             }
          });
         // $("#empty").html('<div class="alert alert-danger">Record not found</div>');
        } 
      });
      $('.contact_popup').on('click', function(){
          var id = $(this).attr("data-id"); 
          $.ajax({
              type: "POST",
              url: '{{url("get_phonebook_table")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {id: id}, 
              dataType: "json",
              cache: false,
              success: function(result) {  
                $('#phonebook_table').val(result[0].phonebook_name);
                 console.log(result); 
              } 
          });   
      });
      $('.send_otp').on('click', function(){
          var id = $(this).attr("data-id");
          var client_id = $(this).attr("data-cid"); 
          $.ajax({
              type: "POST",
              url: '{{url("phonebook/send_pb_otp")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {client_id: client_id},  
              cache: false,
              success: function(result) {  
                $('#pb_id').val(id);
                 console.log(result); 
              } 
          });   
      });
      $(document).on("click", ".del_contact", function() {
        var id = $(this).attr("data-id"); 
        var pb_table = 'phonebook_'+$('#pb_table').val();
       // alert('id='+id+'&table='+pb_table);
        $.ajax({
              type: "POST",
              url: '{{url("delete_pb_contact")}}'+'?_token=' + '{{ csrf_token() }}',
              data: { id: id, pb_table:pb_table },  
              cache: false,
              success: function(result) { 
                console.log(result);  
              } 
          });
        $(this).closest("tr").remove();
      });
      $('.search_popup').on('click', function(){
          $('#output').html("");
           
          var id = $(this).attr("data-id");  
         // alert(id);
          $.ajax({
              type: "POST",
              url: '{{url("get_phonebook_table")}}'+'?_token=' + '{{ csrf_token() }}',
              data: {id: id}, 
              dataType: "json",
              cache: false,
              success: function(result) {  
                $('#pb_table').val(result[0].phonebook_name);
                 console.log(result); 
              } 
          });   
      });  

        $("#submit_pb_otp").validate({ 
            rules: { 
              otp:{
                required: true,
                pnum: true,
                remote: {                   
                  url: '{{url("checkValidOtp")}}'+'?_token=' + '{{ csrf_token() }}', 
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
                  $(".success_msg").html(data);
                  location.reload(true); 
                  // var msg = window.setTimeout(function(){location.reload()},2000);
                  // if(msg){
                  //  window.location.replace('{{url("phonebooks")}}');
                  // }
                }
            }); 
          } 
      });
      $("#submit").validate({ 
          rules: { 
            contact:{ 
              'required': true,
              'pnum': true,
              'minlength': 8,
              'maxlength': 13,
                remote: {                   
                    url: '{{url("checkDuplicateContactPhonebook")}}'+'?_token=' + '{{ csrf_token() }}', 
                    type: "POST",                    
                    data: {  
                      contact: function() {
                          return $( "#contact" ).val();
                        },
                        phonebook_table: function() {
                          return $( "#phonebook_table" ).val();
                        }, 
                    }                   
                  }  
            },  
          },
          //For custom messages
          messages: {  
            contact: {
              required: "Enter your Contact Number",
              pnum: "Please enter only number", 
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
                  window.location.replace('{{url("phonebooks")}}');
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
                var client_name = result[0].fname+' '+result[0].lname;  
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