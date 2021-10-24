@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-3">
        <h5 class="card-header">Add New Spend</h5>
        
        <div class="card-body">

          @if ($errors->spending->all())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->spending->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          
          @if (!empty(old('success')))
            <div class="alert alert-success">
                {{ old('success') }}
            </div>
          @endif

          <form method="put" action="{{ route('spending.create') }}">
            @csrf

            <div class="mb-3">
                <label>Description</label>
                <input class="form-control" type="text" name="desc" value="{{ old('desc') }}" />
            </div>

            <div class="mb-3">
              <label>Cost</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon1">&pound;</span>
                <input class="form-control" step="0.01" type="number" name="cost" value="{{ old('cost') }}" />
              </div>
            </div>

            <div class="mb-3">
              <label>Date</label>
              <input class="form-control" type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" />
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Please select...</option>
                    @foreach($spendingCategories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
              <label>Who Payed for It?</label>
              <select name="user_id" class="form-control">
                <option value="">Please select...</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', Auth::user()->id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Spend</button>
          </form>

        </div>
      </div>
      <div class="card">
        <h5 class="card-header">Current Month Spends</h5>
        <div class="card-body">
          @include('spending.table')
        </div>
      </div>
</div>
@endsection