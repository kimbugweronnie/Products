@extends('layouts.products')
@section('content')
    <main id="main">
        {{-- https://getbootstrap.com/docs/4.0/layout/overview/#containers --}}
        <section class="container">
            <div class="row">
                <div class="card border-dark mb-3 rounded col-sm-4">
                    <div class="card-body">
                        <h3 class="card-title">Product-{{ $product->name }}</b></h3>
                        <form>
                            @csrf
                            {{-- https://getbootstrap.com/docs/4.0/components/forms/ --}}

                            <div class="mb-3">
                                <label for="name" class="col-form-label text-capitalize">Name:*</label>
                                <div>
                                    <input type="text" id=name class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder={{ $product->name }} value = "{{ old('name') }}">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="col-form-label text-capitalize">Quantity:*</label>
                                <div>
                                    <input type="number" id="quantity"
                                        class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                        placeholder={{ $product->quantity }} value = "{{ old('quantity') }}">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="col-form-label text-capitalize">Price:*</label>
                                <div>
                                    <input type="number" id = price class="form-control @error('price') is-invalid @enderror"
                                        name="price" placeholder={{ $product->price }} value = "{{ old('price') }}">

                                </div>

                            </div>
                            <input type=hidden class="form-control" value={{ $index }} name="index" id="index">
                            <br />
                            <div class="d-flex justify-content-between">
                                <button type="button" id="updated" onclick="update()"
                                    class="btn btn-primary mt-4">Submit</button>
                                <a href="{{ route('product.index') }}" class="card-link gap-3">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

<script type='text/javascript'>
    function update() {
        // https://www.w3schools.com/jquery/html_val.asp
        var name = $('#name').val()
        var quantity = $('#quantity').val()
        var price = $('#price').val()

        //index of the object in the json file
        var index = $('#index').val()
        $(document).ready(function() {
            // https://stackoverflow.com/questions/28417781/jquery-add-csrf-token-to-all-post-requests-data
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#updated').on('click', function(e) {
                    //https://stackoverflow.com/questions/20195483/jquery-ajax-form-submits-twice
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    $.ajax({
                        url: '/product/update',
                        type: 'PUT',
                        data: {
                            name,
                            quantity,
                            price,
                            index
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            //document.location.href="/";

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
