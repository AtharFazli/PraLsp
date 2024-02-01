@extends('dashboard.layout.master')

@section('style')
    <style>
        .product-photocard {
            width: 20vw !important;
            height: auto;
            background-color: #fff;
            overflow: hidden;
            margin-right: 2rem;
            margin-top: 2rem;
        }

        .product-photocard-img {

            width: 100%;
            height: 200px;
            /* aspect-ratio: 2/3; */

        }
    </style>
@endsection

@section('index')
    <div class="pagetitle">
        <h1>Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Barang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">

            <div class="row">

                <div class="col-md-8">
                    <div class="row">
                        <h5 class="card-title col-md-10">Halal Mart</h5>
                        <div class="col-md-2">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Tambah Barang
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Barang</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif

                                            <form action="{{ route('barang.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="namaBarang"
                                                        name="nama_barang" placeholder="nama barang">
                                                    <label for="namaBarang">Nama Barang</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="jumlahBarang"
                                                        name="jumlah_barang" placeholder="jumlah barang">
                                                    <label for="jumlahBarang">Jumlah Barang</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="hargaBarang"
                                                        name="harga_barang" placeholder="harga_barang">
                                                    <label for="hargaBarang">Harga Barang</label>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="gambarBarang" class="form-label">Gambar Barang</label>
                                                    <input class="form-control" type="file" name="gambar_barang"
                                                        id="gambarBarang">
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Buat</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ini card foreach start --}}

                        <!-- Card with an image on top -->
                        <div class="row">
                            @foreach ($barangs as $item)
                                <div class="card col-md-4 mt-3 mr-3">
                                    <img src="{{ asset($item->gambar_barang) }}" class="card-img-top product-photocard-img"
                                        alt="{{ $item->gambar_barang }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama_barang }}</h5>
                                        <p class="card-text">Harga : Rp. {{ $item->harga_barang }}</p>
                                        <p class="card-text"><a href="#" class="btn btn-success add-to-cart"
                                                data-id="{{ $item->id }}" data-nama="{{ $item->nama_barang }}"
                                                data-price="{{ $item->harga_barang }}">Beli</a>
                                        </p>
                                    </div>
                                </div><!-- End Card with an image on top -->
                            @endforeach
                        </div>

                        {{-- ini card foreach end --}}


                    </div>
                </div>

                <!-- Right side columns -->
                <div class="col-lg-4">
                    <!-- Recent Activity -->
                    <div class="card mt-5">
                        <div class="card-body">
                            <h3 class="d-flex justify-content-center">Order List</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="order-list">
                                    <!-- Data Order akan ditampilkan di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Diskon</th>
                                        <th id="discount"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Total Harga</th>
                                        <th id="total-price">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div><!-- End Recent Activity -->
                </div><!-- End Right side columns -->

            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                let cart = [];

                // Tambahkan ke keranjang
                $('.add-to-cart').click(function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let price = parseFloat($(this).data('price'));
                    let item = {
                        id: id,
                        name: name,
                        price: price,
                        quantity: 1
                    };

                    // Cek apakah item sudah ada di keranjang
                    let existingItem = cart.find(i => i.id === id);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        cart.push(item);
                    }

                    updateCart();
                });

                // Update keranjang
                function updateCart() {
                    var orderList = $('#order-list');
                    var totalPrice = 0;

                    orderList.empty();

                    cart.forEach(function(item) {
                        var subtotal = item.price * item.quantity;
                        totalPrice += subtotal;

                        orderList.append(
                            '<tr>' +
                            '<td>Nama Barang</td>' +
                            '<td>' + item.price + '</td>' +
                            '<td>' +
                            '<button class="btn btn-sm btn-info" onclick="updateQuantity(' + item.id +
                            ', -1)">-</button>' +
                            ' ' + item.quantity + ' ' +
                            '<button class="btn btn-sm btn-info" onclick="updateQuantity(' + item.id +
                            ', 1)">+</button>' +
                            '</td>' +
                            '<td>' + subtotal + '</td>' +
                            '</tr>'
                        );
                    });

                    // Tampilkan total harga
                    $('#total-price').text(totalPrice.toFixed(2));

                    // Terapkan diskon jika total harga memenuhi syarat
                    applyDiscount(totalPrice);
                }

                // Function to update quantity
                window.updateQuantity = function(itemId, change) {
                    var item = cart.find(i => i.id === itemId);

                    if (item) {
                        item.quantity += change;
                        if (item.quantity <= 0) {
                            // Hapus item jika jumlahnya kurang dari atau sama dengan 0
                            cart = cart.filter(i => i.id !== itemId);
                        }
                        updateCart();
                    }
                };

                // Logika diskon
                function applyDiscount(totalPrice) {
                    var discountRate = 0;

                    if (totalPrice >= 200000) {
                        discountRate = 0.10;
                    } else if (totalPrice >= 100000) {
                        discountRate = 0.05;
                    }

                    var discountAmount = totalPrice * discountRate;
                    var discountedPrice = totalPrice - discountAmount;

                    // Tampilkan diskon dan total harga setelah diskon
                    // console.log('Discount: ' + discountAmount.toFixed(2));


                    if (totalPrice >= 200000) {
                        $('#discount').text('10%')
                        $('#total-price').text(discountedPrice.toFixed(2))
                    } else if (totalPrice >= 100000) {
                        $('#discount').text('5%')
                        $('#total-price').text(discountedPrice.toFixed(2))
                    }

                    console.log('Total Price after Discount: ' + discountedPrice.toFixed(2));

                }



            });
        </script>
    @endpush
