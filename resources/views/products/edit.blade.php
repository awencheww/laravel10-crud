@extends('layouts.app')
@section('content')
    <main class="container">
      <section>
        <a href="{{ route('products.index') }}"><button class="bg-dark text-white">Cancel</button></a>
        <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="titlebar">
            <h1>Edit Product</h1>
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
                <input type="text" name="name" value="{{$product->name}}">
                <label>Description (optional)</label>
                <textarea cols="10" rows="5" name="description">{{$product->description}}</textarea>
                <label>Add Image</label>
                <img id="file-preview" src="{{asset('images/' .$product->image)}}" name="product-image" alt="" class="img-product" />
                <input type="file" name="image" accept="image/*" onchange="showFile(event)">
            </div>
            <div>
                  <label>Category</label>
                  <select  name="category">
                    @foreach (json_decode('{"Cake":"Cake", "Cupcake":"Cupcake", "Drinks":"Drinks", "Dessert":"Dessert", "Sweets":"Sweets"}', true) as $optionKey => $optionValue)
                      <option value="{{$optionKey}}" {{ ($optionKey==$product->category) ? 'selected' : ''; }}>{{$optionValue}}</option>
                    @endforeach
                  </select>
                  <hr>
                  <label>Inventory</label>
                  <input type="text" class="input" name="quantity" value="{{$product->quantity}}">
                  <hr>
                  <label>Price</label>
                  <input type="text" class="input" name="price" value="{{$product->price}}">
            </div>
          </div>
          <div class="titlebar mt-3">
              <h1></h1>
              <input type="hidden" name="hidden_id" value="{{$product->id}}">
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