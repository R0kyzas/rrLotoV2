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
            <div class="card-body">
                <form action="{{ route('admin.discount.create') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter random discount code"
                            aria-label="Enter random discount code"
                            aria-describedby="button-addon2"
                            id="discountCodeInput"
                            name="code"
                        />
                        <button class="btn btn-outline-primary" type="button" id="button-addon2" data-mdb-ripple-color="dark" onclick="generateRandomCode()">
                            Generate random code
                        </button>
                    </div>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="col-auto mb-3">
                        <span id="textExample2" class="form-text">The best way to generate code is by pressing "Generate random code"</span>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="number"
                            class="form-control"
                            placeholder="Enter the discount amount (%)"
                            aria-label="Enter the discount amount (%)"
                            aria-describedby="basic-addon2"
                            name="percentage"
                        />
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>
                    @error('percentage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
        <div class="card card-ticket">
            <div class="card-header primary-bg-color text-white d-flex justify-content-between align-items-center">
                All discounts
            </div>
            <div class="card-body">
            <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Percentage</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <th scope="row">{{ $discount->code }}</th>
                                    <td>{{ intval($discount->percentage) }} %</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-mdb-toggle="modal" data-mdb-target="#deleteModal{{ $discount->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="deleteModal{{ $discount->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $discount->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Discount delete</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete the discount?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.discount.delete', $discount->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Save changes</button>
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
        function generateRandomCode() {
            // Siunčiame užklausą į back-end
            fetch("{{ route('admin.discount.generate.code') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            })
                .then(response => response.json())
                .then(data => {
                    // Užpildome sugeneruotą kodą į įvesties lauką
                    document.getElementById('discountCodeInput').value = data.code;
                })
                .catch(error => console.error("Error:", error));
        }
    </script>
@endsection
