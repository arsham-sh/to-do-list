<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskManager extends Component
{
    public $tasks;
    public $showCompleted = true;
    public $showPending = true;
    public $priorities = ['high' => true, 'medium' => true, 'low' => true];
    public $categories = [];
    public $selectedCategories = [];

    public $taskId;
    public $title = '';
    public $description = '';
    public $priority = 'medium';
    public $category = '';
    public $dueDate = '';
    public $assignedTo = '';
    
    public $showModal = false;
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|in:low,medium,high',
        'category' => 'required|string',
        'dueDate' => 'nullable|date',
        'assignedTo' => 'nullable|exists:users,id',
    ];

    // Initialize component
    public function mount()
    {
        $this->loadTasks();
        $this->loadCategories();
    }

    public function loadTasks()
    {
        // Base query - show tasks owned by or assigned to current user
        $query = Task::with('assignee')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                  ->orWhere('assigned_to', Auth::id());
            });

        // Apply filters
        $this->applyStatusFilter($query);
        $this->applyPriorityFilter($query);
        $this->applyCategoryFilter($query);

        // Get sorted results
        $this->tasks = $query->orderBy('due_date', 'asc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();
    }

    // Filter status (completed/pending)
    private function applyStatusFilter($query)
    {
        $statusFilters = [];
        if ($this->showPending) $statusFilters[] = 'pending';
        if ($this->showCompleted) $statusFilters[] = 'completed';

        if (!empty($statusFilters)) {
            $query->whereIn('status', $statusFilters);
        }
    }

    // Filter priority (high/medium/low)
    private function applyPriorityFilter($query)
    {
        $activePriorities = array_keys(array_filter($this->priorities));
        if (!empty($activePriorities)) {
            $query->whereIn('priority', $activePriorities);
        }
    }

    // Filter category
    private function applyCategoryFilter($query)
    {
        if (!empty($this->selectedCategories)) {
            $query->whereIn('category', $this->selectedCategories);
        }
    }

    // Get unique categories for current user
    private function loadCategories()
    {
        $this->categories = Task::where(function ($query) {
            $query->where('user_id', Auth::id())
                  ->orWhere('assigned_to', Auth::id());
        })->distinct()->pluck('category')->filter()->toArray();

        $this->selectedCategories = $this->categories;
    }

    // Toggle task status between completed/pending
    public function toggleStatus($taskId)
    {
        $task = $this->getUserTask($taskId);
        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed',
        ]);
        $this->loadTasks();
    }

    // Open modal for creating new task
    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->isEditing = false;
    }

    // Open modal for editing existing task
    public function editTask($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('user_id', Auth::id()) // Only owner can edit
            ->firstOrFail();

        $this->fillForm($task);
        $this->showModal = true;
        $this->isEditing = true;
    }

    // Fill form with task data
    private function fillForm($task)
    {
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->priority = $task->priority;
        $this->category = $task->category;
        $this->dueDate = $task->due_date?->format('Y-m-d') ?? '';
        $this->assignedTo = $task->assigned_to;
    }

    // Save new task or update existing one
    public function saveTask()
    {
        $this->validate();

        $taskData = $this->prepareTaskData();

        if ($this->isEditing) {
            // Update existing task
            Task::where('id', $this->taskId)
                ->where('user_id', Auth::id())
                ->update($taskData);
        } else {
            // Create new task
            $taskData['user_id'] = Auth::id();
            $taskData['status'] = 'pending';
            Task::create($taskData);
        }

        $this->closeModal();
        $this->loadTasks();
        $this->loadCategories();
    }

    // Prepare data for saving
    private function prepareTaskData()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'category' => $this->category,
            'due_date' => $this->dueDate ?: null,
            'assigned_to' => $this->assignedTo ?: null,
        ];
    }

    // Delete a task
    public function deleteTask($taskId)
    {
        Task::where('id', $taskId)
            ->where('user_id', Auth::id()) // Only owner can delete
            ->delete();

        $this->loadTasks();
        $this->loadCategories();
    }

    // Get task that belongs to user (either owner or assignee)
    private function getUserTask($taskId)
    {
        return Task::where('id', $taskId)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('assigned_to', Auth::id());
            })
            ->firstOrFail();
    }

    // Reset form fields
    private function resetForm()
    {
        $this->reset([
            'taskId', 'title', 'description', 'priority', 
            'category', 'dueDate', 'assignedTo'
        ]);
        $this->resetErrorBag();
    }

    // Close modal and reset form
    private function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    // Reload tasks when filters change
    public function updated($propertyName)
    {
        if ($this->isFilterProperty($propertyName)) {
            $this->loadTasks();
        }
    }

    // Check if changed property is a filter
    private function isFilterProperty($propertyName)
    {
        $filterProperties = [
            'showCompleted', 'showPending', 'selectedCategories',
            'priorities.high', 'priorities.medium', 'priorities.low'
        ];
        
        return in_array($propertyName, $filterProperties);
    }

    // Get task statistics
    public function getStatsProperty()
    {
        $userTasks = Task::where(function ($query) {
            $query->where('user_id', Auth::id())
                  ->orWhere('assigned_to', Auth::id());
        })->get();

        return [
            'total' => $userTasks->count(),
            'completed' => $userTasks->where('status', 'completed')->count(),
            'in_progress' => $userTasks->where('status', 'pending')->count(),
            'overdue' => $userTasks->where('due_date', '<', now())
                         ->where('status', '!=', 'completed')->count(),
        ];
    }

    // Calculate completion percentage
    public function getProgressPercentageProperty()
    {
        $stats = $this->stats;
        return $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0;
    }

    public function getUsersProperty()
    {
        return User::where('id', '!=', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.task-manager');
    }
}