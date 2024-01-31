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

            width: 50%;
            /* aspect-ratio: 2/3; */
            object-fit: cover;

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
                        <h5 class="card-title col-md-8">Halal Mart</h5>
                        <div class="col-md-4">
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

                        @foreach ($barangs as $barang)
                            <!-- Card with an image on top -->
                            <div class="card product-photocard">
                                <img src="{{ asset($barang->gambar_barang) }}" class="card-img-top product-photocard-img"
                                    alt="{{ asset($barang->gambar_barang) }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                                    <p class="card-text">Harga : Rp. {{ $barang->harga_barang }}</p>
                                    <p class="card-text">
                                        <a href="#" class="btn btn-success">
                                            Tambah ke keranjang
                                        </a>
                                    </p>
                                </div>
                            </div><!-- End Card with an image on top -->
                        @endforeach

                        {{-- ini card foreach end --}}


                    </div>
                </div>

                <div class="col-md-4">
                    <div style="display: flex; justify-content: center">
                        <h5>Order List</h5>
                    </div>

                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <tr id="cart-row-template" style="display: none;">
                                    <td class="item-number"></td>
                                    <td data-item-id="" class="item-name"></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger remove-item">Kurang</button>
                                        <span class="item-quantity"></span>
                                        <button class="btn btn-sm btn-success add-item">Tambah</button>
                                    </td>
                                    <td class="item-price"></td>
                                    <td class="total-price"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total Semua</th>
                                    <th id="total-all">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    var orderIdCounter = 1; // Initialize the counter
    var totalOrderPrice = 0; // Initialize the total order price
    var discount = 0; // Initialize the discount
    var itemQuantities = {}; // Dictionary to store item quantities

    function addToOrderList(itemName, itemPrice) {
        // Generate a unique ID for the order item
        var itemId = orderIdCounter++; // Use the counter directly

        // Check if the item already exists in the order list
        if (itemQuantities[itemName]) {
            // If yes, increment the quantity and update total price
            updateQuantity(itemId, 1, itemName);
        } else {
            // If not, create a new order item
            createOrderItem(itemId, itemName, itemPrice);
            itemQuantities[itemName] = 1; // Initialize quantity to 1
        }

        // Update the total order price
        totalOrderPrice += parseFloat(itemPrice);
        applyDiscount();
        document.getElementById('totalPrice').innerText = formatPrice(totalOrderPrice);
    }

    // Function to create a new order item
    function createOrderItem(itemId, itemName, itemPrice) {
        var newRow = document.createElement('tr');
        newRow.id = 'orderItem' + itemId; // Concatenate with 'orderItem'
        newRow.innerHTML = `
                                    <td>${itemName}</td>
                                    <td id="quantity${itemId}">1</td>
                                    <td>${itemPrice}</td>
                                    <td id="totalPrice${itemId}">${itemPrice}</td>
                                    <td>
                                        <button onclick="updateQuantity(${itemId}, 1, '${itemName}')">+</button>
                                        <button onclick="updateQuantity(${itemId}, -1, '${itemName}')">-</button>
                                    </td>
                                `;
        document.querySelector('#orderList table').appendChild(newRow);
    }

    function updateQuantity(itemId, change, itemName) {
        var quantityCell = document.getElementById(quantity${itemId});
        var totalCell = document.getElementById(totalPrice${itemId});
        var currentQuantity = parseInt(quantityCell.innerText, 10);

        // Update the quantity and total price
        quantityCell.innerText = currentQuantity + change;

        // Check if the item still exists in the dictionary
        if (itemQuantities[itemName]) {
            var itemPrice = parseFloat(totalCell.innerText) / currentQuantity;
            totalCell.innerText = (currentQuantity + change) * itemPrice;

            // Update itemQuantities dictionary
            itemQuantities[itemName] = currentQuantity + change;
        }

        // Update the total order price
        totalOrderPrice += change * itemPrice;
        applyDiscount();
        document.getElementById('totalPrice').innerText = formatPrice(totalOrderPrice);

        // Remove the item if the quantity is 0
        if (currentQuantity + change === 0) {
            var itemRow = document.getElementById('orderItem' + itemId);
            if (itemRow) {
                itemRow.remove();
            }
            delete itemQuantities[itemName]; // Remove from dictionary
        }
    }

    function applyDiscount() {
        // Apply 10% discount if total order price is greater than or equal to 200000
        if (totalOrderPrice >= 200000) {
            discount = 10; // Set discount to 10%
        } else if (totalOrderPrice >= 100000) {
            discount = 5; // Set discount to 5% if total order price is greater than or equal to 100000
        } else {
            discount = 0; // No discount
        }
    }

    function formatPrice(price) {
        if (discount !== 0) {
            return ${price.toFixed(2)} (-${discount}%);
        } else {
            return price.toFixed(2);
        }
    }

    function updateTotalPriceDisplay() {
        document.getElementById('totalPrice').innerText = totalOrderPrice.toFixed(2);
    }

    function applyDiscountAndDisplayFinalPrice() {
        applyDiscount();
        var finalPrice = totalOrderPrice - (totalOrderPrice * (discount / 100));
        document.getElementById('finalPrice').innerText = finalPrice.toFixed(2);
    }
</script>
@endpush
