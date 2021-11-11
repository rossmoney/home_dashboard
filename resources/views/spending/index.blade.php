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

          @if (session()->has('success'))
          <div class="alert alert-success">
              @if(is_array(session('success')))
                  <ul>
                      @foreach (session('success') as $message)
                          <li>{{ $message }}</li>
                      @endforeach
                  </ul>
              @else
                  {{ session('success') }}
              @endif
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

            <div class="mb-3 float-left">
              <label>Installment? (please tick and fill end date)</label>
              <input type="hidden" value="0" name="installment" />
              <input style="width: 30px;" value="1" class="form-control" type="checkbox" id="installment" name="installment" {{ old('installment') ? 'checked' : '' }} />
            </div>

            <script type="text/javascript">
              function installmentClick()
              {
                if ($('#installment').prop('checked'))
                {
                  $('#end_date').removeAttr('disabled');
                } else {
                  $('#end_date').attr('disabled', "disabled");
                }
              }
              
              $('#installment').click(installmentClick);
            
              $(document).ready(installmentClick);
            </script>

            <div class="clearfix"></div>
            
            <div class="mb-3">
              <label>Installment End Date</label>
              <input disabled="disabled" id="end_date" class="form-control" type="date" name="end_date" value="{{ old('end_date', date('Y-m-d', strtotime("+3 months", strtotime(date("y-m-d"))) )) }}" />
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

      <div class="card mb-3">
        <h5 class="card-header">Add New Category</h5>
        
        <div class="card-body">

          @if ($errors->category->all())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->category->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif

          <form method="put" action="{{ route('spending_category.create') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input class="form-control" type="text" name="name" value="{{ old('name') }}" />
            </div>

            <div class="mb-3 float-left">
              <label>Recurrent each month?</label>
              <input type="hidden" value="0" name="recurrent" />
              <input style="width: 30px;" value="1" class="form-control" type="checkbox" name="recurrent" value="1" {{ old('recurrent') ? 'checked' : '' }} />
            </div>

            <div class="mb-3 ml-4 float-left">
              <label>Show all spends on dashboard for this category?</label>
              <input type="hidden" value="0" name="show_all" />
              <input style="width: 30px;" value="1" class="form-control" type="checkbox" name="show_all" value="1" {{ old('show_all') ? 'checked' : '' }} />
            </div>

            <div class="clearfix"></div>

            <button type="submit" class="btn btn-primary">Add Category</button>
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
