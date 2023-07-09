<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

use App\Models\Track;

class Index extends Component
{
    public $lang;
    public $search;
    public Track $track;

    protected $listeners = [
        'newData' => '$refresh',
    ];

    public function mount()
    {
        $this->lang = app()->getLocale();
    }

    public function editTrack($id)
    {
        $this->emit('editTrack', $id);
    }

    public function deleteTrack($id)
    {
        Track::destroy('id', $id);
    }

    public function archiveTrack($id)
    {
        Track::where('id', $id)->update(['state' => 0]);
    }

    public function render()
    {
        $tracks = Track::where('user_id', auth()->user()->id)
            ->where('state', 1)
            ->orderBy('id', 'desc')
            ->when((strlen($this->search) >= 2), function($query) {
                $query->where('code', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
                    ->where('user_id', auth()->user()->id);
            })
            ->paginate(50);

        return view('livewire.client.index', ['tracks' => $tracks])
            ->layout('livewire.client.layout');
    }
}
