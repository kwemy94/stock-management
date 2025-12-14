<td class="text-center">
    <div class="dropdown">

        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>

        <div class="dropdown-menu dropdown-menu-right">

            {{-- Voir --}}
            <a class="dropdown-item" href="{{ route('buy-command-order.show', $command->id) }}">
                <i class="fas fa-eye text-primary mr-2"></i> Voir
            </a>
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

            {{-- Supprimer --}}
            @if (in_array($command->status, ['draft', 'confirmed']))
                {{-- <div class="dropdown-divider"></div>

                <form action="{{ route('buy-command-order.destroy', $command->id) }}" method="POST"
                    onsubmit="return confirm('Supprimer cette commande ?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-trash-alt mr-2"></i> Supprimer
                    </button>
                </form> --}}
            @endif

        </div>
    </div>
</td>
