<div class="mailchimp-subscription-status">
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
    {{-- <div class="badge badge-secondary">{{ $status }}</div>
    Click here to resubscribe --}}

    <div class="text-muted">Checking subscription...</div>

</div>

@push('scripts')
    @script('/vendor/ascent/mailchimp-subscription/ascent-mailchimpsubscription-status.js')
@endpush