<form wire:submit.prevent="updateQuantity('{{ $cart_item->rowId }}', '{{ $cart_item->id }}')">
    <div class="input-group">
        <input wire:model="quantity.{{ $cart_item->id }}" style="min-width: 40px;max-width: 90px;" type="number" class="form-control" value="{{ $cart_item->qty }}" min="0">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check mr-2"></i>
            </button>
        </div>
    </div>
</form>
