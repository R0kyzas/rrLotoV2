
@if($pool && $pool->active === 1)
<div class="container">
    <div class="mt-4">
        <div class="progress rounded-pill" style="height: 50px; position: relative;">
            @php
                $percentage = ($pool->collected_amount / $pool->target_amount) * 100;
            @endphp

            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>

            @if ($percentage >= 100)
                <img src="{{ asset('images/love.png') }}" alt="We did it!" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); height: 50px;">
            @else
                <img src="{{ asset('images/teamwork.png') }}" alt="Teamwork" style="position: absolute; top: 50%; left: {{ $percentage }}%; transform: translate(-50%, -50%); height: 50px;">
            @endif
        </div>
        <div class="d-flex w-full justify-content-center">
            {{ $pool->collected_amount / 100 }} Eur / {{ $pool->target_amount / 100 }} Eur
        </div>
        <div class="d-flex w-full justify-content-center">
            @if ($percentage >= 100)
                We did it !
            @elseif($percentage >= 50 && $percentage < 70)
                We're halfway there !
            @elseif($percentage >= 70 && $percentage < 100)
                We almoste there !
            @else
                We can do it together !
            @endif
        </div>
    </div>
</div>

@endif