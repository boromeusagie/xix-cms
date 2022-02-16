@extends('xix-admin.layout.app')

@section('page_title', 'Tags')

@section('content')
<div class="row">
  <div class="col-lg-4">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h5 class="m-0">Add New Tag</h5>
      </div>
      <div class="card-body">
        <form id="form" action="{{ route('admin-tag-store') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="tagName">Name</label>
            <input type="text" class="form-control @error('tagName') is-invalid @enderror" name="tagName" id="tagName" placeholder="Tag Name">
            @error('tagName')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" id="description" cols="3" rows="3" placeholder="(optional)"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <!-- /.col-md-6 -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">All Tags</h5>
      </div>
      <div class="card-body table-responsive p-0 clear-fix">
        <div class="float-left pl-3">
          <form action="{{ route('admin-tag') }}" method="get">
            {{-- @csrf --}}
            <div class="form-group mt-4 row">
              <p class="col-sm m-0 pr-1">Sort by</p>
              <div class="col-sm m-0 p-0">
                <select name="sort" id="sort" onchange="this.form.submit()">
                  <option value="asc" {{ $sort === 'asc' ? 'selected' : null }}>Ascending Name</option>
                  <option value="desc" {{ $sort === 'desc' ? 'selected' : null }}>Descending Name</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <table class="table table-striped p-0">
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Description</th>
              <th>Slug</th>
              <th>Count</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tags as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->description ?? '-' }}</td>
                  <td>{{ $item->slug }}</td>
                  <td>4</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" data-toggle="modal" data-target="#updateItem" data-name="{{ $item->name }}" data-desc="{{ $item->description }}" data-id="{{ $item->id }}" class="btn btn-sm text-primary" title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button type="button" data-toggle="modal" data-target="#deleteItem" data-name="{{ $item->name }}" data-id="{{ $item->id }}" class="btn btn-sm text-danger" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer clearfix">
        <div class="float-left">
          <form action="{{ route('admin-tag') }}" method="get">
            {{-- @csrf --}}
            <div class="form-group row">
              <p class="col-sm m-0 pr-1">Show</p>
              <div class="col-sm m-0 p-0">
                <select name="perPage" id="perPage" onchange="this.form.submit()">
                  <option value="5" {{ $ppg === 5 ? 'selected' : null }}>5</option>
                  <option value="10" {{ $ppg === 10 ? 'selected' : null }}>10</option>
                  <option value="15" {{ $ppg === 15 ? 'selected' : null }}>15</option>
                  <option value="20" {{ $ppg === 20 ? 'selected' : null }}>20</option>
                  <option value="{{ $totalItems }}" {{ $ppg === $totalItems ? 'selected' : null }}>All</option>
                </select>
              </div>
              <p class="col-sm m-0 pl-1">of {{ $totalItems }}</p>
            </div>
          </form>
        </div>
        <div class="float-right">
          {{ $tags->withQueryString()->links() }}
        </div>
      </div>
    </div>
  </div>
  <!-- /.col-md-6 -->
</div>
@endsection

@section('modal')
  <div class="modal fade" id="updateItem">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Tag</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form name="updateItem" method="post">
          <div class="modal-body">
            @csrf
            <div class="form-group row">
              <label for="tagName" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control @error('tagName') is-invalid @enderror" value="{{ old('tagName') }}" name="tagName" id="tagName" placeholder="Category Name">
                  @error('tagName')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                  <textarea name="description" class="form-control" id="description" cols="3" rows="3" placeholder="(optional)">{{ old('description') }}</textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <div class="modal fade" id="deleteItem">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Tag</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="modal-text"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <form name="deleteItem" class="delete-item" method="post">
            @csrf
            {{-- @method('delete') --}}
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
@endsection

@section('scripts')
    <script>
      $('#updateItem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var name = button.data('name')
        var description = button.data('desc')
        var idItem = button.data('id')
        let url = "{{ route('admin-tag-update', ['id' => ':id']) }}"
        url = url.replace(':id', idItem)
        
        var modal = $(this)
        modal.find('input#tagName').val(name)
        modal.find('textarea#description').val(description)
        
        document.updateItem.action = get_action();

        function get_action() {
          console.log(url);
          return url;
        }
        // modal.find('form.delete-item').action = 
      })
      $('#deleteItem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var name = button.data('name')
        var idItem = button.data('id')
        let url = "{{ route('admin-tag-destroy', ['id' => ':id']) }}"
        url = url.replace(':id', idItem)
        
        var modal = $(this)
        modal.find('.modal-text').text('Are you sure delete tag "' + name + '"?')
        
        document.deleteItem.action = get_action();

        function get_action() {
          console.log(url);
          return url;
        }
        // modal.find('form.delete-item').action = 
      })
    </script>
@endsection