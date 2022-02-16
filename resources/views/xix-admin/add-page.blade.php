@extends('xix-admin.layout.app')

@section('page_title', 'Add New Page')

@section('content')
<form method="post" name="addPage" id="addPageForm">
    @csrf
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control form-control-lg  @error('title') is-invalid @enderror" placeholder="Enter Page Title" value="{{ old('title') }}">
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea name="content" class="textarea @error('content') is-invalid @enderror" placeholder="Write an awesome content here...."
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; padding: 10px;">{{ old('content') }}</textarea>
                          @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 text-center">
                            <button type="submit" id="btnDraft" class="btn btn-default">Save as Draft</button>
                        </div>
                        <div class="col-sm-6 text-center">
                            <button type="submit" id="btnSubmit" class="btn btn-primary">Save Page</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Options</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Allow Comment</label>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</form>
@endsection

@section('add_css')
    <link rel="stylesheet" href="/admin-panel/plugins/summernote/summernote-bs4.css">
@endsection

@section('add_js')
    <script src="/admin-panel/plugins/summernote/summernote-bs4.min.js"></script>
@endsection

@section('scripts')
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote({
        height: 500,
        placeholder: 'Enter content here.....'
    })

    if (!$('.textarea').summernote('isEmpty')) {
        var HTMLstring = '---}}'.$('.textarea').val();
        $('.textarea').summernote('reset');
        $('.textarea').summernote('resetFormat');
        $('.textarea').summernote('pasteHTML', HTMLstring);
    }
    
    $('#btnSubmit').click(function () {
        var url = "{{ route('admin-page-store') }}"
        
        document.addPage.action = get_action();

        function get_action() {
          return url;
        }

        $('#addPageForm').submit();
    })
    $('#btnDraft').click(function () {
        var url = "{{ route('admin-page-store-draft') }}"
        
        document.addPage.action = get_action();

        function get_action() {
          return url;
        }

        $('#addPageForm').submit();
    })
  })
</script>
@endsection