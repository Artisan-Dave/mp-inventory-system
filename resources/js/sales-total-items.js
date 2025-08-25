document.addEventListener('DOMContentLoaded', () => {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalAmountDisplay = document.getElementById('totalAmount');
    const productSummary = document.getElementById('productSummary');
    const totalItemsDisplay = document.getElementById('totalItems');

    function updateTotal() {
        let total = 0;
        let summaryHTML = '';
        let totalItems = 0;


        quantityInputs.forEach(input => {
            const productId = input.dataset.id;
            const quantity = parseFloat(input.value) || 0;
            const name = input.dataset.name || `Product ${productId}`;

            const priceInput = document.querySelector(`.price-input[data-id="${productId}"]`);
            const price = parseFloat(priceInput.value) || 0;

            if (quantity > 0) {
                const subtotal = quantity * price;
                total += subtotal;
                totalItems += quantity;

                summaryHTML += `<div>${name}: ${quantity} × ${price} = ${subtotal.toFixed(2)}</div>`;
            }
        });

        productSummary.innerHTML = summaryHTML || '<div class="mt-4 text-md font-bold text-red-600">No products selected.</div>';
        totalAmountDisplay.textContent = `Total: ${total.toFixed(2)}`;
        totalItemsDisplay.textContent = `Items: ${totalItems}`;

    }

    quantityInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    updateTotal();

});