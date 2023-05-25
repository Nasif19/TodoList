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
								<div class="card-body p-2 px-md-5">

									<p class="h1 text-center pb-1 text-primary">
										<i class="fas fa-check-square me-1"></i>
										<u>My Todo-s</u>
									</p>

									<div class="pb-2">
										<div class="card">
											<div class="card-body">
												<div class="d-flex flex-row align-items-center">
                                                    <input type="text" class="form-control form-control-md me-2" id="name" placeholder="Title..." value="" autofocus>
                                                    <div class="col-2">
														<button type="button" class="btn btn-primary" onclick="saveTodo()">Add</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <h5><strong> ToDo Lists </strong></h5>
        <div class="row mt-2 justify-content-center" id="tasks">
        </div>
    </div>
	<script>
		$(document).ready(function() {
			getTodoLists();
		});

		const getTodoLists = (call_back) => ajaxCall({ url: '/todo/list', callback: async data => {
            await setData(data);
            if (typeof call_back != 'undefined') call_back();
        }});
		const setData = todoLists => {
			let html = ``;
			for (const todo of todoLists) {
                html += `<div class="col-5 border border-info rounded p-2 m-2">
                    <div class="row justify-content-between">
                        <div class="col-12 text-end mb-1"> 
                            <a style="text-decoration: none; cursor: pointer;" class="text-danger" data-mdb-toggle="tooltip" title="Delete Todo" onclick="deleteTask(${todo.id})">
                                X
                            </a>
                        </div>
                        <div class="col-6">
                            <input type="text" style="border: none;" class="form-control form-control-sm me-2" id="task" value="${todo.name}" onchange="updateTodo(this.value, ${todo.id})">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm me-2" name="task${todo.id}" id="task${todo.id}" placeholder="Task..." value="" onchange="saveTodo(this.value, ${todo.id})">
                        </div>
                    </div>
                    <hr class="my-2">`;
                    for (const [i, task] of todo.tasks.entries()) {
                        html += `<ul class="list-group list-group-horizontal rounded-0 bg-transparent mx-4">
                            <li class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                                <div class="form-check">
                                    <input class="form-check-input me-0" type="checkbox" value="" onchange="changeStatus(${ task.id })" id="status${i}" aria-label="..." ${ task.status != 1 ? 'checked' : '' }/>
                                </div>
                            </li>
                            <li class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                                <input type="text" style="border: none;" class="form-control form-control-sm me-2" id="task" value="${task.name}" onchange="updateTodo(this.value, ${task.id})">
                            </li>
                            <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                                <div class="text-end text-muted">
                                    <a style="text-decoration: none; cursor: pointer;" class="text-info" data-mdb-toggle="tooltip" title="Delete Task" onclick="deleteTask(${task.id})">
                                        X
                                    </a>
                                </div>
                            </li> 
                        </ul>`;
                    }
                html += `</div>`;
            }
			$('#tasks').html(html);
		}

		const saveTodo = (name = null, parent_id = null) => {
			ajaxCall({
				url: 'todo/store',
				method: 'POST',
				data: {
					name: name??$('#name').val(),
                    parent_id: parent_id
				},
				callback: () => {
                    if(!name) $('#name').val('').focus();
					getTodoLists(()=> {
                        if (name) $('#task'+parent_id).focus();
                    });
				}
			})
		}

		const updateTodo = (name, id) => {
            if (name.trim() != '') {
                ajaxCall({
                    url: 'todo/update',
                    method: 'POST',
                    data: {
                        name: name??$('#name').val(),
                        id: id
                    },
                    callback: ()=> getTodoLists()
                });
            }
		}

        const changeStatus = id => ajaxCall({
            url: 'todo/change-status',
            method: 'POST',
            data: { id: id },
            callback: () => getTodoLists()
        });

        const deleteTask = id => {
            if (confirm("Are You Sure to Delete This.?"))
            ajaxCall({
                url: `todo/delete`,
                method: 'POST',
                data: { id: id },
                callback: () => getTodoLists()
            });
        }

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
	</script>
@endsection
