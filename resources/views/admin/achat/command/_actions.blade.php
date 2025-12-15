<td class="text-center">
    <div class="dropdown">
        <a href="#" class="text-secondary" data-toggle="dropdown">
            <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow-sm">

            <a class="dropdown-item" href="{{ route('buy.command.print', $command->id) }}" target="_blank">
                <i class="fas fa-print text-dark mr-2"></i> Imprimer
            </a>

            {{-- Modifier --}}
            @if ($command->status === 'draft')
                <a class="dropdown-item" href="{{ route('buy-command-order.edit', $command->id) }}">
                    <i class="fas fa-edit text-warning mr-2"></i> Modifier
                </a>
                <form action="{{ route('buy-command-order.destroy', $command->id) }}" method="POST"
                    onsubmit="return confirm('Supprimer cette commande ?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-trash-alt mr-2"></i> Supprimer
                    </button>
                </form>
            @endif

            {{-- Envoyer --}}
            @if ($command->status === 'confirmed')
                <a class="dropdown-item" href="{{ route('buy.command.send', $command->id) }}">
                    <i class="fas fa-paper-plane text-info mr-2"></i> Expédier
                </a>
            @endif

        </div>
    </div>
</td>
