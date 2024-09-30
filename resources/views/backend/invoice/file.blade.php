<div class="invoice-total">
    <p>Subtotal: {{ $sub_total }} Taka </p>
    <p> Discount:
        @if ($sale->discount == 0)
        {{ $sale->discount_for_amount ?? 0 }} Taka
        @else
        {{ number_format($discount, 2) }} ({{ $sale->discount ?? 0 }} %)
        @endif
    </p>
    <p>Total: {{ $total ?? 'N/A' }} Taka </p>
</div>