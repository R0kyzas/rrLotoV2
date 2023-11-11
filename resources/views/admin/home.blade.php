<!-- resources/views/admin/home.blade.php -->

@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
@include('pool-progress', ['pool' => $pool])
    <div class="container mb-0.5">
        <div class="card card-ticket">
            <div class="card-header primary-bg-color text-white d-flex justify-content-between align-items-center">
                <div>
                    Hello admin
                </div>
                <div>
                    <form action="{{ route('auth.logout') }}" method="POST" role="search">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Logout</button>
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.home') }}" method="GET" id="searchForm">
                <div class="w-100 p-4 pb-4 d-flex align-items-center flex-wrap">
                    <div>
                        <div class="input-group">
                            <div class="form-outline">
                                <input type="search" name="query" id="searchInput" class="form-control">
                                <label class="form-label" for="searchInput" style="margin-left: 0px;">Search</label>
                            <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 47.2px;"></div><div class="form-notch-trailing"></div></div></div>             
                        </div>
                    </div>
                    <div class="mt-4 mt-sm-0 md:ml-4">
                        <div class="input-group">
                            <div class="form-outline">
                                <select class="select border border-secondary rounded p-2" id="select" name="status">
                                    <option value="">Select order status</option>
                                    <option value="0">Waiting for activation</option>
                                    <option value="1">Activated</option>
                                    <option value="2">Canceled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mt-sm-0 md:ml-4">
                        <div class="input-group">
                            <div class="form-outline">
                                <select class="select border border-secondary rounded p-2" id="select" name="payment_method">
                                    <option value="">Select payment method</option>
                                    <option value="0">Bank</option>
                                    <option value="1">Cash</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mt-sm-0">
                        <button type="submit" class="btn btn-primary md:ml-4">Search</button>
                        <button type="button" class="btn btn-danger ml-4" onclick="clearSearch()">Clear</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="w-100 ps-4 d-flex align-items-center flex-wrap">
                <div>
                    <a href="{{ route('admin.discount') }}" class="btn primary-bg-color text-white">Create discount</a>
                </div>
                <div>
                    <a href="{{ route('admin.pool.view') }}" class="btn second-bg-color second-text-color ml-4">Pool panel</a>
                </div>
                <div class="mt-4">
                    <form action="{{ route('admin.pick.winner') }}" method="POST">
                        @csrf
                        <button class="btn btn-success">Pick winner</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order number</th>
                                <th scope="col">First name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">Order status</th>
                                <th scope="col">Order payment method</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order->order_nr }}</th>
                                    <td>{{ $order->first_name }}</td>
                                    <td>{{ $order->last_name }}</td>
                                    <td>
                                        @if ($order->active === 0)
                                            <span class="text-warning">Waiting for activation</span>
                                        @elseif ($order->active === 1)
                                            <span class="text-success">Activated</span>
                                        @elseif ($order->active === 2)
                                            <span class="text-danger">Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->payment_method === 0)
                                            <span class="text-success">Bank</span>
                                        @elseif ($order->payment_method === 1)
                                            <span class="text-success">Cash</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $order->final_price / 100 }} Eur
                                    </td>
                                    <td>
                                        @if($order->active === 0)
                                            <div class="mb-4">
                                                <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#activeModal{{ $order->id }}">
                                                    Accept
                                                </button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-danger" data-mdb-toggle="modal" data-mdb-target="#cancelModal{{ $order->id }}">
                                                    Cancel
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="activeModal{{ $order->id }}" tabindex="-1" aria-labelledby="activeModalLabel{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="activeModalLabel">Order activate</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to activate the order?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.order.activate', $order->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-primary">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cancelModalLabel">Order cancel</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to cancel the order?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.order.cancel', $order->id) }}" method="POST">
                                                        @csrf
                                                        <button class="btn btn-danger">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    function clearSearch() {
        // Išvalo paieškos lauką
        document.getElementById('searchInput').value = '';

        // Pasiima paieškos formos elementą
        var form = document.getElementById('searchForm');

        // Ištrina paieškos užklausos parametrą (query) iš URL
        history.replaceState({}, '', form.action);

        // Pateikia paieškos formą (jei reikia)
        form.submit();
    }
</script>
@endsection
