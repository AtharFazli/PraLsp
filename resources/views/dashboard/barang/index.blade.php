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
            object-fit:

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

                        @foreach ($barangs as $item)
                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6 mb-4">
                                <div class="product-photocard">
                                    <img class="product-photocard-img" src="{{ asset($item->gambar_barang) }}"
                                        alt="{{ $item->gambar_barang }}">
                                    <div class="product-photocard-content">

                                        <h1 class="product-photocard-title text-capitalize">{{ $item->nama_barang }}</h1>
                                        <h6 class="product-photocard-subtitle">{{ $item->harga_barang }}</h6>
                                        <button
                                            onclick="addToOrderList('{{ $item->nama_barang }}', '{{ $item->harga_barang }}')">Add
                                            to Cart</button>

                                    </div>
                                </div>

                            </div><!-- End Sales Card -->
                        @endforeach

                        {{-- ini card foreach end --}}


                    </div>
                </div>

                <!-- Right side columns -->
                <div class="col-lg-4">

                    <!-- Recent Activity -->
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <h1>Order List</h1>
                            </div>
                            <div class="row" id="orderList">
                                <table style="width: 100%">
                                    <tr>
                                        {{-- <th>No.</th> --}}
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price/item</th>
                                        <th>Price all</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($barangs as $item)
                                    @endforeach
                                </table>
                            </div>
                            <hr>
                            <div class="row d-flex">
                                <div class="col-8">
                                    Total

                                </div>

                                <div class="col-4 text-end">
                                    <span class="" id="totalPrice">0.00</span>

                                    <button onclick="applyDiscountAndDisplayFinalPrice()">Apply Discount</button>
                                    <p>Discounted Price: <span id="finalPrice">0.00</span></p>
                                </div>

                            </div>
                            <div class="row">
                                <h4>Payment Method</h4>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <button class="method-button">Method</button>
                                </div>
                                <div class="col-2">
                                    <button class="method-button">Extra looong Method</button>
                                </div>
                                <div class="col-2">
                                    <button class="method-button">Method</button>
                                </div>
                                <div class="col-2">
                                    <button class="method-button">Method</button>
                                </div>
                                <div class="col-2">
                                    <button class="method-button">Method</button>
                                </div>
                                <div class="col-2">
                                    <button class="method-button">Method</button>
                                </div>
                                <div class="col-2">
                                    <button class="method-button">Method</button>
                                </div>
                                <div class="col-2">
                                    <button class="method-button">Method</button>
                                </div>

                            </div>
                        </div>
                    </div><!-- End Recent Activity -->

                </div><!-- End Right side columns -->

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
                var quantityCell = document.getElementById(quantity$ {
                    itemId
                });
                var totalCell = document.getElementById(totalPrice$ {
                    itemId
                });
                var currentQuantity = parseInt(quantityCell.innerText, 10);
                var itemPrice = 0;

                // Update the quantity and total price
                quantityCell.innerText = currentQuantity + change;

                // Check if the item still exists in the dictionary
                if (itemQuantities[itemName]) {
                    itemPrice = parseFloat(totalCell.innerText) / (currentQuantity + change);
                    totalCell.innerText = (currentQuantity + change) * itemPrice;

                    // Update itemQuantities dictionary
                    itemQuantities[itemName] = currentQuantity + change;
                }

                totalOrderPrice += change * itemPrice;
                applyDiscount();
                document.getElementById('totalPrice').innerText = formatPrice(totalOrderPrice);

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
                    return price.toFixed(2) + ' (-' + discount + '%)';
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
