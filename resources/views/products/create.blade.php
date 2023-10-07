@extends('layouts.app')
@section('content')
    <main class="container">
      <section>
        <a href="{{ route('products.index') }}"><button>View Products</button></a>
        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="titlebar">
            <h1>Add Product</h1>
          </div>
          @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  @foreach ($errors->all() as $error)
                      <p class="text-center">{{$error}}</p>
                  @endforeach
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          @endif
          <div class="card">
            <div>
                <label>Name</label>
                <input type="text" name="name">
                <label>Description (optional)</label>
                <textarea cols="10" rows="5" name="description"></textarea>
                <label>Add Image</label>
                <img id="file-preview" src="" alt="" class="img-product" />
                <input type="file" name="image" accept="image/*" onchange="showFile(event)">
            </div>
            <div>
                  <label>Category</label>
                  <select  name="category">
                    @foreach (json_decode('{"Cake":"Cake", "Cupcake":"Cupcake", "Drinks":"Drinks", "Dessert":"Dessert", "Sweets":"Sweets"}', true) as $optionKey => $optionValue)
                      <option value="{{$optionKey}}">{{$optionValue}}</option>
                    @endforeach
                  </select>
                  <hr>
                  <label>Inventory</label>
                  <input type="text" class="input" name="quantity" >
                  <hr>
                  <label>Price</label>
                  <input type="text" class="input" name="price">
            </div>
          </div>
          <div class="titlebar mt-3">
              <h1></h1>
              <button type="submit">Save</button>
          </div>
        </form>
      </section>
    </main>

    <script>
      function showFile(e) {
        var input = e.target;

        var reader = new FileReader();
        reader.onload = function() {
          var dataURL = reader.result;
          var output = document.getElementById('file-preview');
          output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
      }
    </script>
@endsection