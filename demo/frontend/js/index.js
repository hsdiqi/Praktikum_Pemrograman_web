let lastFetchedData = null; // To store the last fetched data for comparison

const productTemplate = (product) => `
    <div class="product-card" onclick="viewProductDetail(${product.id})">
        <img src="${product.image}" alt="${product.name}">
        <h4>${product.name}</h4>
        <p class="price">${formatRupiah(product.price)}</p>
        <p>Stok: ${product.stok}</p>
        <button class="add-to-cart" data-id="${
          product.id
        }">Masukkan Keranjang</button>
    </div>
    `;

// Helper function to format the price to Indonesian Rupiah (Rp) with comma as decimal separator
function formatRupiah(amount) {
  amount = parseFloat(amount); // Convert to a floating point number
  if (isNaN(amount) || amount === null || amount <= 0) {
    return "Rp 0,00"; // Return default value if invalid
  }

  let formattedAmount = amount.toFixed(2); // Ensure two decimal places
  let [integerPart, decimalPart] = formattedAmount.split(".");

  // Format the integer part with periods as thousands separators
  integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

  // Return the formatted price with comma as decimal separator
  return `Rp ${integerPart},${decimalPart}`;
}

// Function to fetch and render products
function fetchAndRenderProducts() {
  const popularProducts = document.getElementById("popular-products");
  const newProducts = document.getElementById("new-products");

  fetch("http://localhost:8000/api/allProducts", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      console.log(response);
      if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
      return response.json();
    })
    .then((data) => {
      // Check if the fetched data has changed
      console.log(data);
      if (JSON.stringify(data) !== JSON.stringify(lastFetchedData)) {
        lastFetchedData = data; // Update the last fetched data
        const popular = data.slice(0, 4);
        const latest = data.slice(4);

        renderProducts(popularProducts, popular);
        renderProducts(newProducts, latest);
      }
    })
    .catch((error) => console.error("Error fetching products:", error));
}

function renderProducts(container, products) {
  const promises = products.map((product) => {
    const imageUrl = product.image
      ? `data:image/jpeg;base64,${product.image}`
      : "placeholder.jpg";
    return Promise.resolve({ ...product, blobUrl: imageUrl });
  });

  Promise.all(promises).then((productsWithBlobs) => {
    container.innerHTML = productsWithBlobs
      .map((product) => productTemplate(product))
      .join("");

    document.querySelectorAll(".add-to-cart").forEach((button) => {
      button.addEventListener("click", (event) => {
        event.stopPropagation();
        const productId = event.target.dataset.id;
        addToCart(productId); // Add product to cart
      });
    });
  });
}

// Function to add product to cart
function addToCart(productId) {
  fetch(`http://localhost:8000/api/buy/${productId}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
  })
    .then((response) => {
      if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
      return response.json();
    })
    .then((data) => {
      alert(`Product ${data.name} added to cart successfully!`);
      fetchAndRenderProducts();
    })
    .catch((error) => console.error("Error adding to cart:", error));
}

function viewProductDetail(productId) {
  window.location.href = `product-detail.html?id=${productId}`;
}

// Initial fetch
document.addEventListener("DOMContentLoaded", () => {
  fetchAndRenderProducts();

  // Set interval to check for changes every 10 seconds
  setInterval(fetchAndRenderProducts, 5000);
});
