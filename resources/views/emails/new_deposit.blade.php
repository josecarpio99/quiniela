<div>
    <h3>Deposit request by user: {{ $deposit->user->username }}</h3>
    <p><strong>Date:</strong> {{ $deposit->date->format('d-m-Y') }} </p>
    <p><strong>Payment method:</strong> {{ $deposit->paymentMethod?->name }} </p>
    <p><strong>Payment reference:</strong> {{ $deposit?->payment_reference }} </p>
    <p><strong>Amount:</strong> {{ $deposit->amount }} </p>
</div>
