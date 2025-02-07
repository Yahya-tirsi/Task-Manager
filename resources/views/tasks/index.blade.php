@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Message succes -->
    @if (session("succes"))
        <div id="messageContainer" class="alert alert-success" role="alert">
            {{session("succes")}}
        </div>
    @endif

    <div class="d-flex top-tsks-project">
        <h1 class="my-4">Tasks for {{ $project->name }}</h1>
        <div>
            If you want to add a new task click here <button id="btn-add-tasks" class="btn-create-project"
                data-bs-toggle="modal" data-bs-target="#createTaskModal"><i class="bi bi-plus-lg"></i></button>
        </div>
    </div>
    <p>{{ $project->description }}</p>

    <!-- Kanban Board -->
    <div class="row">
        <!-- A faire -->
        <div class="col-md-4">
            <div class="card afaire-section-task">
                <div class="card-header afaire-section-task">
                    A faire
                </div>
                <div class="card-body" id="a-faire" ondrop="drop(event, 'A faire')" ondragover="allowDrop(event)">
                    @foreach ($tasks as $task)
                        @if ($task->project_id == $project->id && $task->status === "A faire")
                            <div class="task-card card mb-2" draggable="true" ondragstart="drag(event)"
                                id="task-{{ $task->id }}" data-status="A faire">
                                <div class="card-body">
                                    <div class="card-top-task">
                                        <h5 class="card-title">{{ $task->name }}</h5>
                                        <!-- Three-dot menu -->
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" type="button"
                                                id="dropdownMenuButton{{ $task->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                                <!-- Bootstrap Icons three-dot icon -->
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $task->id }}">
                                                <li>
                                                    <button type="button" onclick="updateTask({{ $task->id }})">
                                                        <i class="bi bi-pencil me-2"></i> Update
                                                    </button>
                                                </li>
                                                <li>
                                                    <button id="delete-task" type="button" onclick="deleteTask({{ $task }})">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <p class="card-text">{{ $task->description }}</p>
                                    <small class="text-muted">Created at: {{ $task->created_at->format('Y-m-d H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Encours -->
        <div class="col-md-4">
            <div class="card encours-section-task">
                <div class="card-header encours-section-task">
                    Encours
                </div>
                <div class="card-body" id="encours" ondrop="drop(event, 'Encours')" ondragover="allowDrop(event)">
                    @foreach ($tasks as $task)
                        @if ($task->project_id == $project->id && $task->status === "Encours")
                            <div class="task-card card mb-2" draggable="true" ondragstart="drag(event)"
                                id="task-{{ $task->id }}" data-status="Encours">
                                <div class="card-body">
                                    <div class="card-top-task">
                                        <h5 class="card-title">{{ $task->name }}</h5>
                                        <!-- Three-dot menu -->
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" type="button"
                                                id="dropdownMenuButton{{ $task->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                                <!-- Bootstrap Icons three-dot icon -->
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $task->id }}">
                                                <li>
                                                    <button type="button" onclick="updateTask({{ $task->id }})">
                                                        <i class="bi bi-pencil me-2"></i> Update
                                                    </button>
                                                </li>
                                                <li>
                                                    <button id="delete-task" type="button"
                                                        onclick="deleteTask({{ $task->id }})">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <p class="card-text">{{ $task->description }}</p>
                                    <small class="text-muted">Created at: {{ $task->created_at->format('Y-m-d H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Terminer -->
        <div class="col-md-4">
            <div class="card terminer-section-task">
                <div class="card-header terminer-section-task">
                    Terminer
                </div>
                <div class="card-body" id="terminer" ondrop="drop(event, 'Terminer')" ondragover="allowDrop(event)">
                    @foreach ($tasks as $task)
                        @if ($task->project_id == $project->id && $task->status === "Terminer")
                            <div class="task-card card mb-2" draggable="true" ondragstart="drag(event)"
                                id="task-{{ $task->id }}" data-status="Terminer">
                                <div class="card-body">
                                    <div class="card-top-task">
                                        <h5 class="card-title">{{ $task->name }}</h5>
                                        <!-- Three-dot menu -->
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" type="button"
                                                id="dropdownMenuButton{{ $task->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                                <!-- Bootstrap Icons three-dot icon -->
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $task->id }}">
                                                <li>
                                                    <button type="button" onclick="updateTask({{ $task->id }})">
                                                        <i class="bi bi-pencil me-2"></i> Update
                                                    </button>
                                                </li>
                                                <li>
                                                    <button id="delete-task" type="button"
                                                        onclick="deleteTask({{ $task->id }})">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <p class="card-text">{{ $task->description }}</p>
                                    <small class="text-muted">Created at: {{ $task->created_at->format('Y-m-d H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Update Task Modal -->
    <div class="modal fade" id="updateTaskModal" tabindex="-1" aria-labelledby="updateTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTaskModalLabel">Update Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateTaskForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="updateTaskName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="updateTaskName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateTaskDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="updateTaskDescription" name="description"
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="updateTaskStatus" class="form-label">Status</label>
                            <select class="form-control" id="updateTaskStatus" name="status" required>
                                <option value="A faire">A faire</option>
                                <option value="Encours">Encours</option>
                                <option value="Terminer">Terminer</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="updateTaskForm" class="btn btn-primary" >Update Task</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Task Modal -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskModalLabel">Delete Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this <span id="task-id-name"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteTask">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProjectModalLabel">Create New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addTaskForm{{ $project->id }}" action="{{ route('tasks.store', $project) }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="projectName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="projectName" placeholder="Enter project name"
                                name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="projectDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="projectDescription" rows="3" name="description"
                                placeholder="Enter project description"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addTaskForm{{ $project->id }}" class="btn btn-primary add-project">
                        Add Task
                    </button>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- Include JavaScript for Drag and Drop -->
<script>
    let currentTaskId = null;

    function addTask(taskId) {
        const form = document.getElementById(`addTaskForm${taskId}`);

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(`/projects/${taskId}/tasks`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {

                    const messageContainer = document.getElementById('messageContainer');
                    const messageText = document.getElementById('messageText');
                    messageText.innerHTML = '🎉 Task created successfully!';

                    const modal = bootstrap.Modal.getInstance(document.getElementById(`addTaskModal${taskId}`));
                    modal.hide();

                    setTimeout(() => {
                        messageContainer.classList.add('d-none');
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    }

    // Function to open the update task modal
    function updateTask(taskId) {
        currentTaskId = taskId;

        // Fetch the task details
        fetch(`/tasks/${taskId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch task details');
                }
                return response.json();
            })
            .then(task => {
                // Populate the modal form with task details
                document.getElementById('updateTaskName').value = task.name;
                document.getElementById('updateTaskDescription').value = task.description;
                document.getElementById('updateTaskStatus').value = task.status;

                // Open the modal
                const modal = new bootstrap.Modal(document.getElementById('updateTaskModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to fetch task details. Please try again.');
            });
    }

    // Function to handle the update form submission
    document.getElementById('updateTaskForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch(`/tasks/${currentTaskId}`, {
            method: 'POST', // Use POST for form submissions
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                'Accept': 'application/json', // Ensure JSON response
            },
            body: formData, // Send form data directly
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update the task');
                }
                return response.json();
            })
            .then(data => {
                window.location.reload(); // Refresh the page after update
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.reload()
            });
    });

    // Function to open the delete task modal
    function deleteTask(task) {
        currentTaskId = task.id;

        console.log(task);

        // Open the modal
        const modal = new bootstrap.Modal(document.getElementById('deleteTaskModal'));
        document.getElementById("task-id-name").innerHTML = task.name;
        modal.show();
    }

    // Function to handle the delete confirmation
    document.getElementById('confirmDeleteTask').addEventListener('click', function () {
        fetch(`/tasks/${currentTaskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Failed to delete the task.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Allow dropping
    function allowDrop(event) {
        event.preventDefault();
    }

    // Drag start
    function drag(event) {
        event.dataTransfer.setData("text", event.target.id);
    }

    // Drop
    function drop(event, status) {
        event.preventDefault();
        const taskId = event.dataTransfer.getData("text").replace('task-', '');
        const taskElement = document.getElementById(`task-${taskId}`);

        // Move the task to the new section
        event.target.appendChild(taskElement);

        // Send an AJAX request to update the task status in the database
        fetch(`/tasks/${taskId}/update-status`, {
            method: 'POST', // Use POST for form submissions
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
            },
            body: JSON.stringify({ status: status, _method: 'PUT' }), // Laravel spoofing for PUT
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update task status');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update task status. Please try again.');
            });
    }
</script>
@endsection