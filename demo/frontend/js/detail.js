// Get product ID from URL
const params = new URLSearchParams(window.location.search);
const productId = params.get('id');

// Helper function to format the price to Indonesian Rupiah (Rp) with comma as decimal separator
function formatRupiah(amount) {
// Check if amount is a valid number
amount = parseFloat(amount);  // Convert to a floating point number

if (isNaN(amount) || amount === null || amount <= 0) {
    return "Rp 0,00";  // Return default value if invalid
}

let formattedAmount = amount.toFixed(2);  // Ensure two decimal places
let [integerPart, decimalPart] = formattedAmount.split('.');

// Format the integer part with periods as thousands separators
integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

// Return the formatted price with comma as decimal separator
return `Rp ${integerPart},${decimalPart}`;
}

// Fetch product details from API
fetch(`http://localhost:8000/api/product/${productId}`)
    .then(response => {
        if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
        console.log(response);
        return response.json();
    })
    .then((data) => {
        document.getElementById('product-image').src = data.image ? `data:image/jpeg;base64,${data.image}` : 'placeholder.jpg';
        document.getElementById('product-name').textContent = data.nama;
        document.getElementById('product-price').textContent = `${formatRupiah(data.price)}`;
        document.getElementById('product-stock').textContent = data.stok;
        document.getElementById('product-description').textContent = data.description;

        document.getElementById('add-to-cart-btn').addEventListener('click', () => {
            addToCart(data.id);
        });
        console.log(data.image);   
    })
    .catch(error => console.error('Error fetching product details:', error));

function addToCart(productId) {
    fetch(`http://localhost:8000/api/buy/${productId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
    })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
            return response.json();
        })
        .then(data => {
            alert(`Product ${data.name} added to cart successfully!`);
        })
        .catch(error => console.error('Error adding to cart:', error));
}