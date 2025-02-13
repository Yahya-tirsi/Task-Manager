@extends('layouts.app')

@section('content')
    @if (session('message'))
        <div id="messageContainer">
            <p id="messageText">{{ session('message') }}</p>
        </div>
    @endif


    <div class="content-home">
        <h1>Welcome to the Task Management System</h1>
        <p>This is the home page of your task management application.</p>

        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form class="input-group" onsubmit="handleSearch(event)">
                        <input type="text" class="form-control inp-search" id="search-input"
                            placeholder="Search for your projects " name="query" aria-label="Search">
                        <button class="btn search-icone" onclick="handleSearch(event)">
                            <i class="bi bi-search" id="search-icone-nit"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="div-btn-search">
        <button class="btn-create-project" id="btn-all-projects" onclick="showProjects()"> <span
                id="changeTextbtnprojects"><i class="bi bi-arrow-down"></i> All projects</span></button>
    </div>



    <!-- Projects Section -->
    <div class="container my-5" id="contentProjects">
        <div class="row">
        </div>
    </div>

    @foreach ($projects as $project)
        <!-- Add Task Modal -->
        <div class="modal fade" id="addTaskModal{{ $project->id }}" tabindex="-1"
            aria-labelledby="addTaskModalLabel{{ $project->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel{{ $project->id }}">
                            Add task for : {{ $project->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('tasks.store', ['project' => $project->id]) }}">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <div class="mb-3">
                                <label for="taskName{{ $project->id }}" class="form-label">Name for task</label>
                                <input type="text" class="form-control" id="taskName{{ $project->id }}" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="taskDescription{{ $project->id }}" class="form-label">Description</label>
                                <textarea class="form-control" id="taskDescription{{ $project->id }}" name="description"
                                    rows="3"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary add-project">Add task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Update Project Modal -->
    <div class="modal fade" id="updateProjectModal" tabindex="-1" aria-labelledby="updateProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProjectModalLabel">Update Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateProjectForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="updateProjectName" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="updateProjectName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateProjectDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="updateProjectDescription" name="description"
                                rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="updateProjectForm" class="btn btn-primary">Update Project</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProjectModalLabel">Delete Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this project : <span id="project-id-name"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteProject">Delete</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        let currentProjectId = null;

        // Count of tasks for each project
        function getTasksProject(idProject) {
            return fetch('/tasks/project/index')
                .then((response) => response.json())
                .then((data) => {
                    const countTasks = data.filter((task) => task.project_id === idProject);
                    return countTasks.length;
                })
                .catch((error) => {
                    console.error('Error fetching tasks:', error);
                    return 0;
                });
        }

        function handleSearch(event) {
            if (event) {
                event.preventDefault();
            }
            const projectSearch = document.getElementById("search-input").value;

            fetch(`/allprojects`)
                .then(response => response.json())
                .then((data) => {
                    const divProjects = document.getElementById("contentProjects").querySelector(".row");

                    if (data.length <= 0) {
                        divProjects.innerHTML = "<p class='text-center'>No data found</p>";
                        return;
                    }

                    const filterProjects = data.project.filter((item) =>
                        item.name.toLowerCase().includes(projectSearch.toLowerCase())
                    );

                    if (filterProjects.length <= 0) {
                        divProjects.innerHTML = "<div class='text-center'> <img src='./images/notFoundProjects.png' alt='No projects found' class='img-fluid' style='max-width: 200px;' /></div><p class='text-center'>No matching projects found</p>";
                        return;
                    }

                    divProjects.innerHTML = "";

                    filterProjects.forEach(item => {
                        getTasksProject(item.id).then((taskCount) => {
                            divProjects.innerHTML += `
                                                            <div class="col-md-4 mb-4" id="container-projects">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <h5 class="card-title">${item.name}</h5>

                                                                            <div class="top-card-projects">

                                                                            <div class="bell-notification">
                                                                                <i class="bi bi-bell"></i> 
                                                                                <span class="count-tasks-notification"> ${taskCount}</span> 
                                                                                <p class="count-tasks"><span>Tasks :</span> <span>${taskCount}</span> </p>
                                                                            </div>
                                                                            <div class="dropdown">
                                                                                <button class="btn btn-link text-muted p-0" type="button"
                                                                                    id="dropdownMenuButton${item.id}" data-bs-toggle="dropdown"
                                                                                    aria-expanded="false">
                                                                                    <i class="bi bi-three-dots-vertical"></i>
                                                                                </button>
                                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${item.id}">
                                                                                    <li><a class="dropdown-item link-view-all-tasks" href="/projects/${item.id}/tasks"><i class="bi bi-eye-fill"></i> View Tasks</a></li>
                                                                                    <li><button id="delete-task" type="button"
                                                                                        onclick="deleteProject(${item.id}, '${item.name}')">
                                                                                        <i class="bi bi-trash me-2"></i> Delete
                                                                                    </button></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                            </div>
                                                                        <hr>
                                                                        <p class="card-text">${item.description}</p>

                                                                        <small class="text-muted">Created at: ${new Date(item.created_at).toLocaleString()}</small>

                                                                        <button class="btn-sm btn-addTask-home" data-bs-toggle="modal"
                                                                            data-bs-target="#addTaskModal${item.id}">
                                                                            <i class="bi bi-plus"></i> Add Task
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                        })
                    });
                })
                .catch(error => {
                    const divProjects = document.getElementById("contentProjects");
                    divProjects.innerHTML = "<p class='text-center'>An error occurred while fetching projects.</p>";
                });
        }

        // Function to open the update project modal
        function updateProject(projectId) {
            currentProjectId = projectId;

            fetch(`/projects/${projectId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch project details');
                    }
                    return response.json();
                })
                .then(project => {
                    document.getElementById('updateProjectName').value = project.name;
                    document.getElementById('updateProjectDescription').value = project.description;

                    const modal = new bootstrap.Modal(document.getElementById('updateProjectModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to fetch project details. Please try again.');
                });
        }

        // function deleteProject(projectId) {
        //     if (!confirm("Voulez-vous vraiment supprimer ce projet ?")) {
        //         return;
        //     }

        //     fetch(`/projects/${projectId}`, {
        //         method: 'DELETE',
        //         headers: {
        //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        //             'Accept': 'application/json'
        //         },
        //     })
        //         .then(response => {
        //             if (!response.ok) {
        //                 throw new Error('Erreur lors de la suppression');
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             alert('Projet supprimé avec succès !');
        //             window.location.reload();
        //         })
        //         .catch(error => {
        //             console.error('Erreur :', error);
        //             alert('Impossible de supprimer le projet.');
        //         });
        // }



        // Function to handle the update form submission


        document.getElementById('updateProjectForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch(`/projects/${currentProjectId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update the project');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Project updated successfully!');
                    window.location.reload(); // Reload the page to reflect changes
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update the project. Please try again.');
                });
        });

        // Function to handle the delete confirmation
        document.getElementById('confirmDeleteProject').addEventListener('click', function () {
            fetch(`/projects/${currentProjectId}`, {
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
                        alert('Failed to delete the project.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        // Show all projects
        function showProjects() {
            const changeTextbtnprojects = document.getElementById("changeTextbtnprojects");
            const contentProjects = document.getElementById("contentProjects");
            setTimeout(() => {
                changeTextbtnprojects.innerHTML = "<div class='waitProjects'><i class='bi bi-hourglass-bottom'></i></div>";
            }, 100);
            setTimeout(() => {
                handleSearch();
                changeTextbtnprojects.innerHTML = "<i class='bi bi-arrow-down' ></i > All projects";
            }, 1500);
        }

        function addTask(event, projectId) {
            event.preventDefault();

            const form = document.getElementById(`addTaskForm${projectId}`);
            const formData = new FormData(form);

            fetch(`/projects/${projectId}/tasks`, {
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
                    messageContainer.classList.remove('d-none');

                    const modal = bootstrap.Modal.getInstance(document.getElementById(`addTaskModal${projectId}`));
                    modal.hide();

                    form.reset();

                    setTimeout(() => {
                        messageContainer.classList.add('d-none');
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }


        // Function to open the delete project modal
        function deleteProject(projectId, projectName) {
            currentProjectId = projectId;
            console.log(projectId, projectName);


            const modal = new bootstrap.Modal(document.getElementById('deleteProjectModal'));
            document.getElementById("project-id-name").innerHTML = projectName;
            modal.show();
        }


        setTimeout(() => {
            document.getElementById("messageContainer").classList.add('d-none');
        }, 3000);

    </script>
@endsection