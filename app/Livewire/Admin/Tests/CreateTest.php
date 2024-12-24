<?php

namespace App\Livewire\Admin\Tests;

use App\Models\Test;
use Livewire\Component;

class CreateTest extends Component
{
    public $title;
    public $description;
    public $duration;
    public $passing_score;
    public $status = true;

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required',
        'duration' => 'required|integer|min:1',
        'passing_score' => 'required|integer|min:0|max:100',
        'status' => 'boolean'
    ];

    public function save()
    {
        $this->validate();

        Test::create([
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            'passing_score' => $this->passing_score,
            'status' => $this->status
        ]);

        session()->flash('message', 'Test muvaffaqiyatli yaratildi.');
        return redirect()->route('admin.tests.index');
    }

    public function render()
    {
        return view('livewire.admin.tests.create-test');
    }
}
