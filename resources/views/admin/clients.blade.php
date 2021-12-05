@extends('layout.layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2>{{ __('Clients List') }}</h2>
                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#Clients">Add New +</button>
                </div>
              
                <div class="card-body">
                    <!-- row -->
                    <div class="row mt-3 row-sm">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table id="example" class="table key-buttons text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">Sr.No</th>
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">Email</th>
                                                <th class="border-bottom-0">Created Date</th>
                                                <th class="border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											@if(isset($User))
                                            @php $i= 1; @endphp
											@foreach($User as $m)
											<tr>
									            <td>{{$i}}</td>
												<td>{{$m->name}}</td>
												<td>{{$m->email}}</td>
                                                <td>{{$m->created_at}}</td>
                                                <td>
                                                    <button class="btn btn-outline-info Edit"  value="{{$m->id}}">Edit</button>	
                                                    <button class="btn btn-outline-danger Delete"  value="{{$m->id}}">Delete</button>
                                                        
												</td>
											</tr>
                       						 @php $i++; @endphp
											 @endforeach
											@endif
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row closed -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Clients" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Save Clients</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{route('save_Client')}}" method="POST" >
      @csrf
      <input type="hidden" name="id" class="form-control" id="id" value="">
        <div class="form-group">
            <label for="exampleInputName">Name</label>
            <input type="text" name="name" class="form-control" id="name"  placeholder="Enter Name">
            
        </div>
        <div class="form-group">
            <label for="exampleInputemail">Email</label>
            <input type="text" name="email" class="form-control" id="email"  placeholder="Enter Email">
        </div>
        <div class="form-group">
            <label for="exampleInputemail">Password</label>
            <input type="Password" name="password" class="form-control" id="password"  placeholder="Enter Password">
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
    $(".Edit").on("click",function(){
            var id = this.value;
            var _token = $('input[name="_token"]').val();
            var url = "{{route('getById_Client', '')}}"+"/"+id;
            $.ajax({
                type: 'get', 
                url : url, 
                headers: { "Accept": "application/json" },
                success : function (data) {
                if (data) {
                    $('#Clients').modal();
                    $('#id').val(data.User.id);
                    $('#name').val(data.User.name);
                    $('#email').val(data.User.email);
                    $('#password').val(data.User.password);
                }
                },
            }); 
    });
    $(".Delete").on("click",function(){
        if (confirm("Are you sure to Delete?")) {
        var id = this.value;
        var _token = $('input[name="_token"]').val();
        var url = "{{route('deleteById_Client', '')}}"+"/"+id;
        $.ajax({
                        type: 'get', 
                        url : url, 
                        headers: { "Accept": "application/json" },
                        success : function (data) {
                                    console.log(data);
                        if (data) {
                        $('#alert_failed').removeAttr('hidden');
                        $('#alert_failed').text(data.message);
                        window.location.reload(3000);
                        }
                        
                        },
                    }); 
                }
        return false;
    }); 
}); 

</script>
