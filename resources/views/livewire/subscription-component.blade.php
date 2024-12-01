<div>
<h1>Payment</h1>
   
    <div class="paymentWidgets"></div>
   
    <form action="{{ route('payment.status') }}" class="paymentWidgets" data-brands="VISA MASTER ALIADEBIT AMEX DISCOVER CARTEBANCAIRE  MADA GOOGLEPAY APPLEPAY"></form>

</div>

@push('scripts')
<script src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}"></script>
<!-- <script src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={checkoutId}"></script> -->

@endpush
