<td class="text-center">
    <div class="dropdown">

        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>

        <div class="dropdown-menu dropdown-menu-right">

            {{-- Voir --}}
            <a class="dropdown-item" href="{{ route('buy-command-order.show', $receipt->id) }}">
                <i class="fas fa-eye text-primary mr-2"></i> Voir
            </a>
            <a class="dropdown-item" href="{{ route('buy.command.print', $receipt->id) }}" target="_blank">
                <i class="fas fa-print text-dark mr-2"></i> Imprimer
            </a>

            {{-- Modifier --}}
            @if ($receipt->status === 'draft')
                <a class="dropdown-item" href="{{ route('buy-command-order.edit', $receipt->id) }}">
                    <i class="fas fa-edit text-warning mr-2"></i> Modifier
                </a>
                <form action="{{ route('buy-command-order.destroy', $receipt->id) }}" method="POST"
                    onsubmit="return confirm('Supprimer cette commande ?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-trash-alt mr-2"></i> Supprimer
                    </button>
                </form>
            @endif

            

        </div>
    </div>
</td>
