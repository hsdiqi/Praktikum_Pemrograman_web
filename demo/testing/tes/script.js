const productTemplate = (product) => `
        <div class="product-card">
            <img src="${product.blobUrl}" alt="${product.nama}">
            <h4>${product.nama}</h4>
            <p>Stok: ${product.stok}</p>
            <button class="add-to-cart" data-id="${product.id}">Masukkan Keranjang</button>
        </div>
    `;


document.addEventListener('DOMContentLoaded', () => {
    const popularProducts = document.getElementById('popular-products');
    const newProducts = document.getElementById('new-products');

    

    fetch('http://localhost:8000/api/allProducts')
        .then((response) => {
            if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
            return response.json();
        })
        .then((data) => {
            const popular = data.slice(0, 4);
            const latest = data.slice(4);

            renderProducts(popularProducts, popular);
            renderProducts(newProducts, latest);
        })
        .catch((error) => console.error('Error fetching products:', error));
});

function renderProducts(container, products) {
    const promises = products.map((product) => {
        const imageUrl = product.image || 'placeholder.jpg';
        return Promise.resolve({ ...product, blobUrl: imageUrl });
    });

    Promise.all(promises).then((productsWithBlobs) => {
        container.innerHTML = productsWithBlobs
            .map((product) => productTemplate(product))
            .join('');

        document.querySelectorAll('.add-to-cart').forEach((button) => {
            button.addEventListener('click', (event) => {
                const productId = event.target.dataset.id;
                addToCart(productId);
            });
        });
    });
}

function addToCart(productId) {
    fetch(`http://localhost:8000/api/buy/${productId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
    })
        .then((response) => {
            if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
            return response.json();
        })
        .then((data) => {
            alert(`Product ${data.name} added to cart successfully!`);
        })
        .catch((error) => console.error('Error adding to cart:', error));
}
