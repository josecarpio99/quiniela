<div>
    <h3>Withdraw request by user: {{ $withdraw->user->username }}</h3>
    <p><strong>Date:</strong> {{ $withdraw->created_at->format('d-m-Y') }} </p>
    <p><strong>Amount:</strong> {{ $withdraw->amount }} </p>
</div>
