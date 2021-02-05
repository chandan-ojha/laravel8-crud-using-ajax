<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajax Crud</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	
	<section style="padding-top: 60px">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							Students
                             <a href="#" class="btn btn-success" data-toggle="modal" data-target="#studentModal">Add New Student</a>
                             <a href="#" class="btn btn-danger" id="deleteAllSelectedRecord">Delete Selected</a>

						</div>
						<div class="card-body">
							<table id="studentTable" class="table">
								<thead>
									<tr>
                                        <th><input type="checkbox" id="chkCheckAll"> </th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>
										<th>Phone</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($students as $student)
                                       <tr id="sid{{$student->id}}">

                                         <td><input type="checkbox" name="ids" class="checkBoxClass" value="{{$student->id}}"/> </td>
                                         <td>{{$student->firstname}}</td>
                                         <td>{{$student->lastname}}</td>
                                         <td>{{$student->email}}</td>
                                         <td>{{$student->phone}}</td>
                                         <td> 
                                            <a href="javascript:void(0)" onclick=" editStudent({{
                                                $student->id}})" class="btn btn-info">Edit</a>

                                            <a href="javascript:void(0)" onclick=" deleteStudent({{
                                                $student->id}})"  class="btn btn-danger">Delete</a>

                                         </td>

                                       </tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>


<!-- Add Student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="studentForm">
        	@csrf
        	<div class="form-group">
        		<label for="firstname">First Name</label>
        		<input type="text" class="form-control" id="firstname"/>
        	</div>
        	<div class="form-group">
        		<label for="lastname">Last Name</label>
        		<input type="text" class="form-control" id="lastname"/>
        	</div>
        	<div class="form-group">
        		<label for="email">Email</label>
        		<input type="text" class="form-control" id="email"/>
        	</div>
        	<div class="form-group">
        		<label for="phone">Phone</label>
        		<input type="text" class="form-control" id="phone"/>
        	</div>
        	<button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      
    </div>
  </div>
</div>


<!-- Edit Student Modal -->
<div class="modal fade" id="studentEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="studentEditForm">
            @csrf
            <input type="hidden" id="id" name="id"/>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" id="firstname2"/>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" id="lastname2"/>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email2"/>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone2"/>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      
    </div>
  </div>
</div>


<!--Add Student -->
<script >
	$("#studentForm").submit(function(e){
     e.preventDefault();

     let firstname=$("#firstname").val();
     let lastname=$("#lastname").val();
     let email=$("#email").val();
     let phone=$("#phone").val();
     let _token =$("input[name=_token]").val();

     $.ajax({

     	url:"{{route('student.add')}}",
     	type:"POST",
     	data:{
     		firstname:firstname,
     		lastname:lastname,
     		email:email,
     		phone:phone,
     		_token:_token
     	},
     	success:function(response)
     	{
     		if(response)
     		{
     			$("#studentTable tbody").prepend('<tr><td>'+response.firstname+'</td> <td>'+response.lastname+'</td> <td>'+response.email+'</td> <td>'+response.phone+'</td> </tr>');
     			$("#studentForm")[0].reset();
     			$("#studentModal").modal('hide');
     		}
     	}

     });

	});
</script>



<!--editStudent -->
<script >
    function editStudent(id)
    {
        $.get('/students/'+id,function(student){
            $("#id").val(student.id);
            $("#firstname2").val(student.firstname);
            $("#lastname2").val(student.lastname);
            $("#email2").val(student.email);
            $("#phone2").val(student.phone);
            $("#studentEditModal").modal('toggle');
        });

    }
    $("#studentEditForm").submit(function(e){
       e.preventDefault();
       let id=$("#id").val();
       let firstname=$("#firstname2").val();
       let lastname=$("#lastname2").val();
       let email=$("#email2").val();
       let phone=$("#phone2").val();
       let _token =$("input[name=_token]").val();

       $.ajax({

        url:"{{route('student.update')}}",
        type:"PUT",
        data:{
            id:id,
            firstname:firstname,
            lastname:lastname,
            email:email,
            phone:phone,
            _token:_token
        },
        success :function(response)
        {
            $('#sid' +response.id+'td:nth-child(1)').text(response.firstname);
            $('#sid' +response.id+'td:nth-child(1)').text(response.lastname);
            $('#sid' +response.id+'td:nth-child(1)').text(response.email);
            $('#sid' +response.id+'td:nth-child(1)').text(response.phone);
            $('#studentEditModal').modal('toggle');
            $("#studentEditForm")[0].reset();
        }

       });

    });

</script>

<!--Delete Student Record-->
<script >
    function deleteStudent(id)
    {
        if(confirm("Do you really want to delete this record?"))
        {
            $.ajax({
                url:'/students/'+id,
                type:'DELETE',
                data:{
                    _token:$("input[name=_token]").val()
                },
                success:function(response)
                {
                    $("#sid"+id).remove();
                }

            });
        }
    }
</script>



<!--Delete Multiple Student Record-->
<script >
    $(function(e){

        $("#chkCheckAll").click(function(){
            $(".checkBoxClass").prop('checked',$(this).prop('checked'));
        });

        $("#deleteAllSelectedRecord").click(function(e){
            e.preventDefault();
            var allids=[];

            $("input:checkbox[name=ids]:checked").each(function(){
                allids.push($(this).val());
            });

            $.ajax({

             url:"{{route('student.deleteSelected')}}",
             type:"DELETE",
             data:{
                _token:$("input[name=_token]").val(),
                ids:allids
             },

             success:function(response){
                $.each(allids,function(key,val){
                   $("#sid"+val).remove();
                })
             }

            });

        })

    });
</script>

</body>
</html>