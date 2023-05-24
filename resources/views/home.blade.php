@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
				<div class="container h-100">
					<div class="row d-flex justify-content-center align-items-center h-100">
						<div class="col">
							<div class="card" id="list1"
								style="border-radius: .75rem; background-color: #eff1f2;">
								<div class="card-body py-4 px-4 px-md-5">

									<p class="h1 text-center pb-3 text-primary">
										<i class="fas fa-check-square me-1"></i>
										<u>My Todo-s</u>
									</p>

									<div class="pb-2">
										<div class="card">
											<div class="card-body">
												<div class="d-flex flex-row align-items-center">
													<div class="col-md-6 col-7 me-2">
														<input type="text" class="form-control form-control-md" id="name" placeholder="Add new..." value="">
													</div>
													<div class="col-md-4 col-3 me-2">
														<input type="date" class="form-control form-control-md" id="date" value="">
													</div>
													{{-- <a href="#!" data-mdb-toggle="tooltip" title="Set due date"><i class="fas fa-calendar-alt fa-lg me-3"></i></a> --}}
													<div class="col-2">
														<button type="button" class="btn btn-primary" onclick="saveTodo()">Add</button>
													</div>
												</div>
											</div>
										</div>
									</div>

									<hr class="my-4">

									{{-- <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
										<p class="small mb-0 me-2 text-muted">Filter</p>
										<select class="select">
											<option value="1">All</option>
											<option value="2">Completed</option>
											<option value="3">Active</option>
											<option value="4">Has due date</option>
										</select>
										<p class="small mb-0 ms-4 me-2 text-muted">Sort</p>
										<select class="select">
											<option value="1">Added date</option>
											<option value="2">Due date</option>
										</select>
										<a href="#!" style="color: #23af89;" data-mdb-toggle="tooltip"
											title="Ascending"><i class="fas fa-sort-amount-down-alt ms-2"></i></a>
									</div> --}}
									<div id="div_list">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
	<script>
		$(document).ready(function(){
			getTodoLists();
		});

		const ajaxCall = (varObj) => {
			/*
				varObj = {
					url='',
					method='GET/POST',
					data={},
					callback=()=>{},
					callbackError=()=>{},
					type = 1 // 1-Normal, 2-Form Submit 
				}
			*/
			let type = typeof varObj.type == 'undefined' ? 1 : varObj.type;
			let ajxObj = {
				url: varObj.url,
				method: (typeof varObj.method == 'undefined'?'GET':varObj.method),
				data: typeof varObj.data == 'undefined'?{}:varObj.data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			};

			if (type == 2) {
				ajxObj.contentType = false;
				ajxObj.cache = false;
				ajxObj.processData = false;
			}

			ajxObj = {
				...ajxObj,
				success: function (data) {
					console.log(data);
					varObj.callback(data);
				},
				error: function (error) {
					alert('Something Went Wrong..!!!!');
					console.log(error);
					if (typeof varObj.callbackError != 'undefined') varObj.callbackError(error);
				}
			}

			$.ajax(ajxObj);
		}

		const getTodoLists = () => {
			ajaxCall({
				url: '/todo/list',
				callback: setData
			})
		}
		const setData = todoLists => {
			let html = '';
			for (const [i, todo] of todoLists.entries()) {
				html += `<ul class="list-group list-group-horizontal rounded-0 bg-transparent">
					<li
						class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
						<div class="form-check">
							<input class="form-check-input me-0" type="checkbox" value="" onchange="updateStatus(${ todo.id })" id="status${i}" aria-label="..." ${ todo.status != 1 ? 'checked' : '' }/>
						</div>
					</li>
					<li
						class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
						<p class="lead fw-normal mb-0">${ todo.name }</p>
					</li>
					<li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
						<div class="text-end text-muted">
							<a href="#!" class="text-muted" data-mdb-toggle="tooltip" title="Created date">
								<p class="small mb-0"><i class="fas fa-info-circle me-2"></i> ${ todo.date } </p>
							</a>
						</div>
					</li>
					<li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
						<div class="text-end text-muted">
							<a href="#!" class="btn btn-sm btn-warning me-2" data-mdb-toggle="tooltip" title="Edit date">
								Edit
							</a>
							<a href="#!" class="btn btn-sm btn-danger" data-mdb-toggle="tooltip" title="Delete date">
								Delete
							</a>
						</div>
					</li>
				</ul>`;
			}
			$('#div_list').html(html);
		}

		const saveTodo = () => {
			ajaxCall({
				url: 'todo/store',
				method: 'POST',
				data: {
					name: $('#name').val(),
					date: $('#date').val()
				},
				callback: ()=>{
					$('#name').val('');
					getTodoLists();
				}
			})
		}
	</script>
@endsection
