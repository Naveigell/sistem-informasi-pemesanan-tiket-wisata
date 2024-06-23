@extends('layouts.admin.admin')

@section('content-title', 'Testimoni')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <div class="card">
            <form action="{{ @$testimonial ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method(@$testimonial ? 'PUT' : 'POST')
                <div class="card-header">
                    <h4>Form Testimoni</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', @$testimonial ? $testimonial->name : '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control" cols="30" rows="10" style="min-height: 200px; resize: none;">{{ old('description', @$testimonial ? $testimonial->description : '') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
