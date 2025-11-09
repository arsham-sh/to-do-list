<div>
    <!-- Desktop Navigation -->
    <nav class="desktop-nav navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-tasks me-2"></i>Corporate Task Manager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-calendar me-1"></i> Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-chart-bar me-1"></i> Reports</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Header -->
    <div class="d-lg-none mobile-header">
        <br>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-tasks me-2 text-primary"></i>Tasks
                </h4>
                <div class="d-flex">
                    <button class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="collapse"
                        data-bs-target="#mobileFilters">
                        <i class="fas fa-filter"></i>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                    Logout
                                </a>
                                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <div class="row">
            <!-- Sidebar - Hidden on mobile, shown as filter bar -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sidebar p-3">
                    <h5 class="mb-3">Filters</h5>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="filter-pending" 
                                   wire:model="showPending">
                            <label class="form-check-label" for="filter-pending">Pending</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="filter-completed" 
                                   wire:model="showCompleted">
                            <label class="form-check-label" for="filter-completed">Completed</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="filter-high" 
                                   wire:model="priorities.high">
                            <label class="form-check-label" for="filter-high">High</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="filter-medium" 
                                   wire:model="priorities.medium">
                            <label class="form-check-label" for="filter-medium">Medium</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="filter-low" 
                                   wire:model="priorities.low">
                            <label class="form-check-label" for="filter-low">Low</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   id="filter-{{ \Illuminate\Support\Str::slug($category) }}" 
                                   value="{{ $category }}"
                                   wire:model="selectedCategories">
                            <label class="form-check-label" for="filter-{{ \Illuminate\Support\Str::slug($category) }}">
                                {{ $category }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-lg-9">
                <!-- Mobile Filters -->
                <div class="d-lg-none mb-4">
                    <div class="collapse" id="mobileFilters">
                        <div class="card card-body">
                            <div class="filter-section">
                                <label class="form-label">Status</label>
                                <div class="filter-options">
                                    <span class="filter-option {{ $showPending && $showCompleted ? 'active' : '' }}" 
                                          wire:click="$set('showPending', true); $set('showCompleted', true)">
                                        All
                                    </span>
                                    <span class="filter-option {{ $showPending && !$showCompleted ? 'active' : '' }}" 
                                          wire:click="$set('showPending', true); $set('showCompleted', false)">
                                        Pending
                                    </span>
                                    <span class="filter-option {{ !$showPending && $showCompleted ? 'active' : '' }}" 
                                          wire:click="$set('showPending', false); $set('showCompleted', true)">
                                        Completed
                                    </span>
                                </div>
                            </div>

                            <div class="filter-section">
                                <label class="form-label">Priority</label>
                                <div class="filter-options">
                                    <span class="filter-option {{ $priorities['high'] && $priorities['medium'] && $priorities['low'] ? 'active' : '' }}"
                                          wire:click="$set('priorities', ['high' => true, 'medium' => true, 'low' => true])">
                                        All
                                    </span>
                                    <span class="filter-option {{ $priorities['high'] ? 'active' : '' }}"
                                          wire:click="$set('priorities.high', !$priorities['high'])">
                                        High
                                    </span>
                                    <span class="filter-option {{ $priorities['medium'] ? 'active' : '' }}"
                                          wire:click="$set('priorities.medium', !$priorities['medium'])">
                                        Medium
                                    </span>
                                    <span class="filter-option {{ $priorities['low'] ? 'active' : '' }}"
                                          wire:click="$set('priorities.low', !$priorities['low'])">
                                        Low
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
                    <h2>Task Dashboard</h2>
                    <button class="btn btn-primary" wire:click="openModal">
                        <i class="fas fa-plus me-1"></i> Add New Task
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card stats-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title">{{ $this->stats['total'] }}</h4>
                                        <p class="card-text">Total</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card stats-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title">{{ $this->stats['completed'] }}</h4>
                                        <p class="card-text">Done</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card stats-card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title">{{ $this->stats['in_progress'] }}</h4>
                                        <p class="card-text">In Progress</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-spinner"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card stats-card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title">{{ $this->stats['overdue'] }}</h4>
                                        <p class="card-text">Overdue</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Task Completion Progress</span>
                            <span>{{ $this->progressPercentage }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $this->progressPercentage }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Task List -->
                <div class="card">
                    <div class="card-body p-0">
                        @foreach($tasks as $task)
                        <div class="p-3 border-bottom task-card task-priority-{{ $task->priority }} {{ $task->status === 'completed' ? 'completed-task' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-start flex-grow-1">
                                    <div class="form-check mt-1 me-3">
                                        <input class="form-check-input" type="checkbox" 
                                               {{ $task->status === 'completed' ? 'checked' : '' }}
                                               wire:click="toggleStatus({{ $task->id }})">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 task-title {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                            {{ $task->title }}
                                        </h6>
                                        @if($task->description)
                                        <p class="mb-1 text-muted d-none d-md-block">{{ $task->description }}</p>
                                        @endif
                                        <div class="task-info-row">
                                            <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'success') }} me-2">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            <span class="badge bg-secondary me-2 category-badge">{{ $task->category }}</span>
                                            @if($task->due_date)
                                            <small class="text-muted">
                                                <i class="far fa-calendar me-1"></i> 
                                                {{ $task->due_date->format('M d') }}
                                            </small>
                                            @endif
                                            @if($task->assignee)
                                            <small class="text-muted ms-2">
                                                <i class="fas fa-user me-1"></i>
                                                {{ $task->assignee->username }}
                                            </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="task-actions">
                                    <button class="btn btn-sm btn-outline-secondary me-1" 
                                            wire:click="editTask({{ $task->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            wire:click="deleteTask({{ $task->id }})"
                                            onclick="return confirm('Are you sure you want to delete this task?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if($tasks->isEmpty())
                        <div class="p-5 text-center text-muted">
                            <i class="fas fa-tasks fa-3x mb-3"></i>
                            <p>No tasks found. Create your first task!</p>
                            <button class="btn btn-primary" wire:click="openModal">
                                <i class="fas fa-plus me-1"></i> Add Your First Task
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav d-lg-none">
        <div class="container position-relative">
            <button class="add-task-btn" wire:click="openModal">
                <i class="fas fa-plus"></i>
            </button>
            <div class="row">
                <div class="col-3">
                    <a href="#" class="mobile-nav-item active">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" class="mobile-nav-item">
                        <i class="fas fa-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" class="mobile-nav-item">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" class="mobile-nav-item" 
                       onclick="event.preventDefault(); document.getElementById('logout-form-bottom').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log out</span>
                    </a>
                    <form id="logout-form-bottom" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    @if($showModal)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditing ? 'Edit Task' : 'Add New Task' }}</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveTask">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label">Task Title</label>
                            <input type="text" class="form-control" id="taskTitle" 
                                   placeholder="Enter task title" wire:model="title">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="taskDescription" rows="3" 
                                      placeholder="Enter task description" wire:model="description"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="taskPriority" class="form-label">Priority</label>
                                <select class="form-select" id="taskPriority" wire:model="priority">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="taskCategory" class="form-label">Category</label>
                                <input type="text" class="form-control" id="taskCategory" 
                                       placeholder="Enter category" wire:model="category" list="categories">
                                <datalist id="categories">
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                    @endforeach
                                </datalist>
                                @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="taskDueDate" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="taskDueDate" wire:model="dueDate">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="taskAssignee" class="form-label">Assign To</label>
                                <select class="form-select" id="taskAssignee" wire:model="assignedTo">
                                    <option value="">Select User</option>
                                    @foreach($this->users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="saveTask">
                        {{ $isEditing ? 'Update Task' : 'Add Task' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>