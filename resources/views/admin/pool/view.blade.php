@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')
@section('content')
@include('pool-progress', ['pool' => $pool])
<div class="container mb-0.5">
        <div class="card card-ticket">
            <div class="card-header primary-bg-color text-white d-flex justify-content-between align-items-center">
                <div>
                    Pool panel
                </div>
            </div>
            <div class="card-body">
                @if($pool)
                    <div>Pool already exists, so u can only <span class="fw-bold">disable / enable</span>. Of course, you can also delete it :)</div>
                    <div class="mt-4 d-flex">
                        <div class="mr-4">
                            @if($pool->active === 1)
                                <a href="{{ route('admin.pool.status', $pool->id) }}" class="btn btn-dark">Disable</a>
                            @else
                                <a href="{{ route('admin.pool.status', $pool->id) }}" class="btn btn-success">Enable</a>
                            @endif
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger" data-mdb-toggle="modal" data-mdb-target="#deleteModal{{ $pool->id }}">
                                Delete
                            </button>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal{{ $pool->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $pool->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Pool delete</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete the pool?</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.pool.delete', $pool->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                @else
                    <form action="{{ route('admin.pool.store') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Target Amount"
                                aria-label="Target Amount"
                                aria-describedby="target_amount"
                                name="target_amount"
                            />
                            <span class="input-group-text" id="target_amount">€</span>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Pool</button>
                    </form>
                @endif
            </div>
        </div>
</div>
@endsection
