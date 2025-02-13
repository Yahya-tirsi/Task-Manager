<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ url('/home') }}" class="navbar-logo">Task Manager</a>

        <button type="button" class="btn-create-project" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            <i class="bi bi-plus-lg"></i> Create Project
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
            data-bs-whatever="@mdo">P</button>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Settings</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Username</h1>
                <p>{{ auth()->user()->username }}</p>
            </div>
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Email address</h3>
                <p>{{ auth()->user()->email }}</p>
            </div>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Password</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#editPasswordModal">
                    Edit
                </button>
            </div>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete account</h1>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Password Modal -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPasswordForm" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Old Password -->
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Old Password</label>
                        <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                            id="old_password" name="old_password" required>
                        @error('old_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                            id="new_password" name="new_password" required>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation"
                            name="new_password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

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


    document.getElementById('editPasswordForm').addEventListener('submit', function (event) {
        event.preventDefault();

        fetch(this.action, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                old_password: document.getElementById('old_password').value,
                new_password: document.getElementById('new_password').value,
                new_password_confirmation: document.getElementById('new_password_confirmation').value,
            }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success); // Show success message
                    document.getElementById('editPasswordForm').reset(); // Clear the form
                    bootstrap.Modal.getInstance(document.getElementById('editPasswordModal')).hide(); // Close the modal
                } else if (data.errors) {
                    // Display validation errors
                    alert(data.errors.join('\n'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>