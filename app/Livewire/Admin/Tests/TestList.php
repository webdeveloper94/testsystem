<?php

namespace App\Livewire\Admin\Tests;

use App\Models\Test;
use Livewire\Component;
use Livewire\WithPagination;

class TestList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }

    public function render()
    {
        $tests = Test::query()
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.tests.test-list', [
            'tests' => $tests
        ]);
    }
}
