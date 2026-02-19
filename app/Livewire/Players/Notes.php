<?php

namespace App\Livewire\Players;

use App\Actions\CreatePlayerNoteAction;
use App\DTOs\CreatePlayerNoteData;
use App\Enums\Permissions;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Notes extends Component
{
    use WithPagination;
    
    public int $playerId;
    public string $note = '';

    protected string $paginationTheme = 'tailwind';

    protected array $rules = [
        'note' => 'required|string|max:100',
    ];

    /**
     * Set up the component.
     *
     * @param int $id The ID of the player to get notes for.
     * @param PlayerRepositoryInterface $playerRepositoryInterface The player repository to use.
     * @param PlayerNoteRepositoryInterface $playerNoteRepositoryInterface The player note repository to use.
     *
     * @return void
     */
    public function mount(int $id, PlayerRepositoryInterface $playerRepositoryInterface): void
    {
        $this->playerId = $id;

        abort_if(
            !$playerRepositoryInterface->findById($id),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Saves a new player note.
     *
     * This method validates the note content and calls the given action to create a new player note.
     * After the note is saved, it resets the note input field.
     *
     * @param CreatePlayerNoteAction $action The action to use for creating the player note.
     * @return void
     */
    public function save(CreatePlayerNoteAction $action): void
    {
        abort_if(!auth()->user()->can(Permissions::CREATE_PLAYER_NOTES->value), Response::HTTP_FORBIDDEN);
        
        $this->validate();

        $action->execute(
            new CreatePlayerNoteData(
                playerId: $this->playerId,
                authorId: auth()->id(),
                note: $this->note,
            )
        );

        $this->reset('note');
        $this->resetPage();

        $this->dispatch('note-created');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(
        PlayerRepositoryInterface $playerRepositoryInterface,
        PlayerNoteRepositoryInterface $playerNoteRepositoryInterface
    ): View
    {
        return view('livewire.players.notes', [
            'player' => $playerRepositoryInterface->findById($this->playerId),
            'notes' => $playerNoteRepositoryInterface->paginateByPlayer($this->playerId),
        ])->layout('layouts.app');
    }
}
