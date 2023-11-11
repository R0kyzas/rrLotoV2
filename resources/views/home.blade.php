@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
@include('pool-progress', ['pool' => $pool])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container mb-0.5">
        <div class="card card-ticket">
            <div class="card-header primary-bg-color text-white d-flex justify-content-between align-items-center">
                Support ticket
            </div>
            <div class="card-body">
            <form action="{{ route('store.ticket') }}" method="POST" id="supportTicketForm">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="first_name">
                    First Name
                </label>
                <input
                    class="form-control"
                    id="first_name"
                    name="first_name"
                    type="text"
                    placeholder="Enter your first name"
                    value="{{ old('first_name') }}"
                >
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="last_name">
                    Last Name
                </label>
                <input
                    class="form-control"
                    id="last_name"
                    type="text"
                    name="last_name"
                    placeholder="Enter your last name"
                    value="{{ old('last_name') }}"
                >
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="ticket_quantity">
                    How much tickets you want?
                </label>
                <input
                class="form-control"
                    id="ticket_quantity"
                    name="ticket_quantity"
                    type="text" 
                    placeholder="Minimum 1 ticket"
                >
                @error('ticket_quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="price"></div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" >Discount code</label>
                <div class="justify-center md:flex">
                    <div class="flex items-center w-full">
                        <input 
                            type="text" 
                            name="discount"
                            id="discount" 
                            placeholder="Apply discount code" 
                            class="form-control"
                        />
                        <button type="button" onclick="applyDiscount()" class="btn btn-primary">
                            Apply
                        </button>
                    </div>
                </div>
                <div id="discountResponse"></div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="payment_method">
                    Select payment method
                </label>
                <div class="form-check mb-2">
                    <input 
                        class="form-check-input"
                        type="radio" 
                        name="payment_method"
                        value="0"
                        id="bank"
                        {{ old('payment_method') == '0' ? 'checked' : '' }}
                    />
                    <label class="form-check-label" for="bank"> Paysera </label>
                </div>
                <div class="form-check">
                    <input 
                        class="form-check-input"
                        type="radio" 
                        name="payment_method"
                        value="1"
                        id="cash"
                        {{ old('payment_method') == '1' ? 'checked' : '' }}
                    />
                    <label class="form-check-label" for="cash"> Cash </label>
                </div>
                @error('payment_method')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button
            class="primary-bg-color w-full text-white py-2 px-4 rounded font-bold hover:bg-red-800 focus:outline-none focus:shadow-outline"
            >
            Buy
        </button>
        
        <div class="mt-4 d-flex justify-content-center">
            <button type="button" data-mdb-toggle="modal" data-mdb-target="#termsModal">
            Terms and Conditions
            </button>
        </div>
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            Terms and Conditions
1. General Terms
1.1. These Terms and Conditions (hereinafter referred to as "Terms") govern the conditions for the purchase and sale of goods or services between the Seller and the Buyer.

1.2. All Buyer orders are processed in accordance with these Terms. The Buyer agrees to review and accept these Terms before placing an order.

2. Orders
2.1. The Buyer may place an order through the online store or other means provided by the Seller.

2.2. The Buyer agrees to provide accurate and complete order information.

2.3. The Seller reserves the right to reject or partially fulfill an order if the provided information is incorrect or incomplete.

3. Prices and Payment
3.1. All prices are listed on the online store and are subject to change without prior notice.

3.2. The Buyer must pay the full amount for the ordered goods or services before their delivery or provision.

4. Delivery
4.1. The Seller undertakes to deliver the goods to the Buyer within the specified timeframe and using the selected delivery method.

4.2. Delivery charges may be added to the total amount.

5. Returns and Exchanges
5.1. The Buyer has the right to return goods within 14 days of receiving them.

5.2. Returned items must be undamaged, unused, and in their original packaging.

5.3. The Seller reserves the right to reject returned goods that do not comply with these Terms.

6. Privacy
6.1. The Seller undertakes to protect and not disclose the Buyer's personal data obtained during transactions.

6.2. The Seller may use personal data solely for the purpose of fulfilling the transaction.

7. Liability
7.1. The Seller is not responsible for any damage or loss incurred due to the Buyer's improper use or non-compliance with these Terms.

7.2. All products and services are provided "as is," without any direct or implied warranties.

8. Final Provisions
8.1. These Terms are governed by the laws of the Republic of Lithuania.

8.2. All disputes and disagreements between the Seller and the Buyer will be resolved through negotiations.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" data-mdb-dismiss="modal">Okay</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        </form>
    </div>
</div>
    </div>
<script>
    document.getElementById('ticket_quantity').addEventListener('input', function() {
    let quantity = parseInt(this.value);
    if (!isNaN(quantity) && quantity > 0) {
        let price = quantity * <?= $ticketPrice ?>;
        let discountedPrice = 0;
        
        while (document.getElementById('price').firstChild) {
            document.getElementById('price').removeChild(document.getElementById('price').firstChild);
        }

        let priceMessage = document.createElement('div');
        priceMessage.classList.add('mt-2');

        if (price >= 30) {
            discountedPrice = price * 0.8;
            priceMessage.innerHTML = `Total price: <span class="line-through">${price} EUR</span><span class="font-bold text-base text-red-500"> ${discountedPrice} EUR`;
        } else {
            priceMessage.innerHTML = `Total price: <span class="font-bold">${price} EUR</span>`;
        }

        document.getElementById('price').appendChild(priceMessage);
    } else {
        while (document.getElementById('price').firstChild) {
            document.getElementById('price').removeChild(document.getElementById('price').firstChild);
        }
    }
});

function createAlert(discountResponse, textColorClass, message, backgroundColorClass) {
    while (discountResponse.firstChild) {
        discountResponse.removeChild(discountResponse.firstChild);
    }

    let alert = document.createElement('div');
    alert.classList.add('p-4', 'mb-4', 'mt-4', 'text-sm', textColorClass , 'rounded-lg', backgroundColorClass);
    alert.setAttribute('role', 'alert');
    alert.innerHTML = `<span class="font-medium">${message}</span>`;

    discountResponse.appendChild(alert);
}

function applyDiscount() {
    let discountCode = document.getElementById('discount').value;
    let discountResponse = document.getElementById('discountResponse');
    let tickets = document.getElementById('ticket_quantity').value;
    let price = parseInt(tickets) * <?= $ticketPrice ?>;  // Pakeičiau quantity į tickets

    if (tickets.length > 0) {
        if (discountCode.length >= 3) {
            fetch('/apply-discount', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ discount: discountCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    if (data.validDiscount.length > 0) {
                        createAlert(discountResponse, "text-green-800", "Discount applied !", "bg-green-50");
                        let quantity = parseInt(document.getElementById('ticket_quantity').value);
                        let discountedPrice = price - (price * (data.validDiscount[0].percentage / 100));

                        while (document.getElementById('price').firstChild) {
                            document.getElementById('price').removeChild(document.getElementById('price').firstChild);
                        }

                        let newPriceMessage = document.createElement('div');
                        newPriceMessage.classList.add('mt-2');
                        newPriceMessage.innerHTML = `Total price: <span class="line-through">${price} EUR</span><span class="font-bold text-base text-red-500"> ${discountedPrice.toFixed(2)} EUR`;

                        document.getElementById('price').appendChild(newPriceMessage);

                        let hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'discount_accepted';
                        hiddenInput.value = discountCode;
                        document.getElementById('supportTicketForm').appendChild(hiddenInput);
                    } else {
                        createAlert(discountResponse, "text-red-800", "Discount code not found !", "bg-red-50");
                    }
                } else {
                    alert('Invalid coupon code');
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            createAlert(discountResponse, "text-red-800", "The code must consist of at least 3 characters !", "bg-red-50");
        }
    } else {
        createAlert(discountResponse, "text-red-800", "First enter the ticket amount !", "bg-red-50");
    }
}



    document.addEventListener('DOMContentLoaded', function() {
        let userDataCookie = getCookie('userData');

        if(userDataCookie){
            let userData = JSON.parse(decodeURIComponent(userDataCookie));

            document.getElementById('first_name').value = userData.firstName;
            document.getElementById('last_name').value = userData.lastName;
        }

    });

    function getCookie(name) {
        let value = "; " + document.cookie;
        let parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    document.getElementById('supportTicketForm').addEventListener('submit', function() {
        let userData = {
            firstName: document.getElementById('first_name').value,
            lastName: document.getElementById('last_name').value,
        };

        let encodedUserData = encodeURIComponent(JSON.stringify(userData));

        let expirationDate = new Date();
        setCookie('userData', encodedUserData, expirationDate.setFullYear(expirationDate.getFullYear() + 1));
    });
</script>
@endsection