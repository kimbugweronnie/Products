@extends('layouts.products')
@section('content')
    <main id="main">
        {{-- https://getbootstrap.com/docs/4.0/layout/overview/#containers --}}
        <section class="container">
            <div class="row">
                <div class="card border-dark mb-3 rounded col-sm-4">
                    <div class="card-body">
                        <h3 class="card-title">Product</h3>
                        <form>
                            @csrf
                            {{-- https://getbootstrap.com/docs/4.0/components/forms/ --}}

                            <div class="mb-3">
                                <label for="name" class="col-form-label text-capitalize">Name:*</label>
                                <div>
                                    <input type="text" id=name class="form-control @error('name') is-invalid @enderror"
                                        name="name" value = "{{ old('name') }}">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="col-form-label text-capitalize">Quantity:*</label>
                                <div>
                                    <input type="number" id="quantity"
                                        class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                        value = "{{ old('quantity') }}">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="col-form-label text-capitalize">Price:*</label>
                                <div>
                                    <input type="number" id=price class="form-control @error('price') is-invalid @enderror"
                                        name="price" value = "{{ old('price') }}">

                                </div>
                            </div>
                            <input type=hidden class="form-control" value={{ date('Y-m-d') }} name="created_at"
                                id="time">
                            <br />
                            <button type="button" id="created" onclick="save()" class="btn btn-primary mt-4">Submit</a>

                        </form>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="card border-dark mb-3 rounded col-sm-6">
                    <div class="card-body">
                        <h3 class="card-title">Products</h3>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-capitalize" scope="col">Product Name</th>
                                    <th class="text-capitalize" scope="col">Quantity in stock</th>
                                    <th class="text-capitalize" scope="col">Price per Item</th>
                                    <th class="text-capitalize" scope="col">DateTime Submitted</th>
                                    <th class="text-capitalize" scope="col">Total value number</th>
                                    <th class="text-capitalize" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                    <tr>
                                        <td class="text-nowrap">{{ $product->name }}</td>
                                        <td class="text-nowrap">{{ $product->quantity }}</td>
                                        <td class="text-nowrap">{{ $product->price }}</td>
                                        <td class="text-nowrap">
                                        {{ Carbon\Carbon::parse($product->created_at)->format('d/m/y') }}</td>
                                        <td class="text-nowrap">{{ $product->quantity * $product->price }}</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('product.edit', $index) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td>{{ $subTotal }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <p id="message"></p>

        </section>

    </main>
@endsection
<script type='text/javascript'>
    function save() {
        // https://www.w3schools.com/jquery/html_val.asp
        var name = $('#name').val()
        var quantity = $('#quantity').val()
        var price = $('#price').val()
        var created_at = $('#time').val()
        $(document).ready(function() {
            // https://stackoverflow.com/questions/28417781/jquery-add-csrf-token-to-all-post-requests-data
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#created').on('click', function(e) {
                    //https://stackoverflow.com/questions/20195483/jquery-ajax-form-submits-twice
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    $.ajax({
                        url: '/product/store',
                        type: 'POST',
                        data: {
                            name,
                            quantity,
                            price,
                            created_at
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log('Data has been posted');
                            console.log(data);
                            document.location.href="/";

                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });

                }


            )
        })
    }
</script>
