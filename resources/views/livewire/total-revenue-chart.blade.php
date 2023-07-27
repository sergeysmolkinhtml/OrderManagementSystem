<div wire:poll.60="updateChartData">
    <canvas
        x-data="{
            chart: null,

            init: function () {
                let chart = new Chart($el, {
                    type: 'line',
                    data: @js($this->getData()),
                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return '$' + context.formattedValue
                                    }
                                }
                            }
                        }
                    }
                })

                $wire.on('updateChartData', async ({ data }) => {
                    chart.data = data
                    chart.update('resize')
                })
            }
        }"
        style="height: 320px;"
        wire:ignore>
    </canvas>
    @foreach($orders as $order)
    <div class="mt-4">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{  $loop->iteration }} Order </h5>
                    <h5 class="card-title">{{$order->users}}</h5>
                    <p class="card-text">Total {{$order->subtotal}}</p>
                    <a href="#" class="btn btn-primary">From {{$order->created_at->format('Y-m-d')}} - To {{$order->order_date->format('Y-m-d')}}</a>
                    <p>Pay with Stripe:</p>
                    <form action="/payments" method="POST">
                        <input type="hidden" name="amount" value="{{ session()->get('amount') }}">
                        @csrf
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ config('settings.stripe.key') }}"
                            data-amount="{{ session()->get('amount') }}"
                            data-name="freek.dev ads"
                            data-locale="auto"
                            data-label="Pay {{ session()->get('amount') / 100 }} EUR to freek.dev"
                            data-zip-code="true"
                            data-currency="eur">
                        </script>
                    </form>

                    <a href="/payments" class="font-semibold text-gray-700 pb-1 border-b-2">
                        Change amount
                    </a>
                </div>
            </div>

        @endforeach
    </div>
</div>
