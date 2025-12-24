<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class ProjectTasks extends Component
{
    public $project;
    public $content = '';

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function addTask()
    {
        $this->validate([
            'content' => 'required|string|max:255',
        ]);

        $this->project->tasks()->create([
            'content' => $this->content,
        ]);

        $this->content = '';
        $this->project->refresh();
    }

    public function toggle($taskId)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id === $this->project->id) {
            $task->update(['is_completed' => !$task->is_completed]);
            $this->project->refresh();
        }
    }

    public function delete($taskId)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id === $this->project->id) {
            $task->delete();
            $this->project->refresh();
        }
    }

    public function render()
    {
        return view('livewire.project-tasks', [
            'tasks' => $this->project->tasks()->latest()->get(),
        ]);
    }
}
