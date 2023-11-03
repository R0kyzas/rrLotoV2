@extends('layouts.layout')

@section('title', 'Pagrindinis Puslapis')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-md overflow-hidden card-ticket">
    <div class="primary-bg-color text-white p-4 flex justify-between">
        <div class="font-bold text-lg">Lottery Ticket</div>
        <div class="text-lg"><i class="fab fa-cc-visa"></i></div>
    </div>
    <div class="p-6">
        <form action="{{ route('store.ticket') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="first_name">
                    First Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="first_name"
                    name="first_name"
                    type="text"
                    placeholder="Enter your first name"
                    value="{{ old('first_name', $userData['first_name'] ?? '') }}"
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
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="last_name"
                    type="text"
                    name="last_name"
                    placeholder="Enter your last name"
                    value="{{ old('first_name', $userData['last_name'] ?? '') }}"
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
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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
                    <div class="flex items-center w-full h-13 pl-3 bg-white bg-gray-100 border rounded">
                        <input 
                            type="discount" 
                            name="discount"
                            id="discount" 
                            placeholder="Apply discount code" 
                            class="shadoww-full outline-none appearance-none focus:outline-none active:outline-none"
                        />
                        <button type="button" onclick="applyDiscount()" class="text-sm flex items-center px-3 py-1 text-white bg-gray-800 rounded outline-none md:px-4 hover:bg-gray-700 focus:outline-none active:outline-none">
                            <svg aria-hidden="true" data-prefix="fas" data-icon="gift" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h160V320H32v128zm256 32h160c17.7 0 32-14.3 32-32V320H288v160zm192-320h-42.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H32c-17.7 0-32 14.3-32 32v80c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16v-80c0-17.7-14.3-32-32-32zm-326.1 0c-22.1 0-40-17.9-40-40s17.9-40 40-40c19.9 0 34.6 3.3 86.1 80h-86.1zm206.1 0h-86.1c51.4-76.5 65.7-80 86.1-80 22.1 0 40 17.9 40-40s-17.9 40-40 40z"/></svg>
                            <span class="font-medium ml-2">Apply</span>
                        </button>
                    </div>
                </div>
                <div id="discountResponse"></div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="payment_method">
                    Select payment method
                </label>
                <div class="flex items-center mb-4">
                    <input 
                        id="bank" 
                        type="radio" 
                        value="0" 
                        name="payment_method" 
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                        @if(isset($userData['payment_method']) && $userData['payment_method'] == 0) checked @endif
                    >
                    <label for="bank" class="ml-2 text-sm font-medium">Paysera</label>
                </div>
                <div class="flex items-center">
                    <input 
                        @if(isset($userData['payment_method']) && $userData['payment_method'] == 1) checked @endif
                        id="cash" 
                        type="radio" 
                        value="1" 
                        name="payment_method" 
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                    >
                    <label for="cash" class="ml-2 text-sm font-medium">Cash</label>
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
        </form>
    </div>
</div>
<script>
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

        if(discountCode.length >= 3)
        {

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
                    console.log(data);
                    if(data.validDiscount.length > 0)
                    {
                        createAlert(discountResponse, "text-green-800", "Discount applied !", "bg-green-50");
                        let quantity = parseInt(document.getElementById('ticket_quantity').value);
                        let price = quantity * <?= $ticketPrice ?>;
                        let discountedPrice = price - (price * (data.validDiscount[0].percentage / 100));
                        
                        while ( document.getElementById('price').firstChild) {
                            document.getElementById('price').removeChild(document.getElementById('price').firstChild);
                        }

                        let newPriceMessage = document.createElement('div');
                        newPriceMessage.classList.add('mt-2');
                        newPriceMessage.innerHTML = `Total price: <span class="line-through">${price} EUR</span><span class="font-bold text-base text-red-500"> ${discountedPrice} EUR`;
                    
                        document.getElementById('price').appendChild(newPriceMessage);
                    }else{
                        createAlert(discountResponse, "text-red-800", "Discount code not found !", "bg-red-50");
                    }
                } else {
                    alert('Invalid coupon code');
                }
            })
            .catch(error => console.error('Error:', error));
        }else{
            createAlert(discountResponse, "text-red-800", "The code must consist of at least 3 characters !", "bg-red-50");
        }
    }

    document.getElementById('ticket_quantity').addEventListener('input', function() {
        let quantity = parseInt(this.value);
            if (!isNaN(quantity) && quantity > 0) {
                let price = quantity * <?= $ticketPrice ?>; 

                let priceMessage = document.createElement('div');
                priceMessage.classList.add('mt-2');
                priceMessage.innerHTML = `Total price: <span class="font-bold">${price} EUR</span>`;
            
                document.getElementById('price').appendChild(priceMessage);
        } else {
            while ( document.getElementById('price').firstChild) {
                document.getElementById('price').removeChild(document.getElementById('price').firstChild);
            }
        }
    });
</script>
@endsection