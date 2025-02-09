<!-- resources/views/partials/navbar.blade.php -->

<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ url('/') }}" class="navbar-logo">Task Manager</a>
        <!-- Update the button to trigger the modal -->
        <button type="button" class="btn-create-project" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            <i class="bi bi-plus-lg"></i> Create Project
        </button>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectModalLabel">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProjectForm">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter project name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="projectDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="projectDescription" rows="3"
                            placeholder="Enter project description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="createProjectForm" class="btn btn-primary add-project">Add Project</button>
            </div>
        </div>
    </div>
</div>

<!-- Projects -->
 <div class="container-projects">
    
 </div>

<script>
    document.getElementById('createProjectForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const projectName = document.getElementById('projectName').value;
        const projectDescription = document.getElementById('projectDescription').value;

        fetch('/projects', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                name: projectName,
                description: projectDescription
            })
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('projectName').value = "";
                document.getElementById('projectDescription').value = "";

                const messageContainer = document.getElementById('messageContainer');
                const messageText = document.getElementById('messageText');
                messageText.innerHTML = '🎉 Project created successfully!';
                messageContainer.classList.remove('d-none'); 

                const modal = bootstrap.Modal.getInstance(document.getElementById('createProjectModal'));
                modal.hide();

                setTimeout(() => {
                    messageContainer.classList.add('d-none');
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'An error occurred. Please try again.');
            });
    });


</script>