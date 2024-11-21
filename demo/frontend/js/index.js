async function fetchProducts() {
  try {
    const response = await fetch("http://localhost:8000/api/allProducts"); // URL ke backend PHP
    const data = await response.json();
    console.log(data); // Pastikan data adalah array produk

    // Sort produk berdasarkan tahun_rilis secara descending
    const terbaru = data.sort((a, b) => b.tahun_rilis - a.tahun_rilis);

    // Jika Anda ingin mengurutkan berdasarkan muchBought (pastikan properti 'muchBought' ada di data)
    const bestSeller = data.sort((a, b) => b.muchBought - a.muchBought); 

    renderCards(terbaru, "Terbaru");
    renderCards(bestSeller, "Best Seller");
  } catch (error) {
    console.error("Error fetching products:", error);
  }
}

function renderCards(products, section) {
  const container = document.querySelector(`.products-section .product-grid`);
  if (section === "Terbaru") {
    container.innerHTML = ""; 
  }

  products.forEach((product) => {
    const card = document.createElement("article");
    card.className = "product-card";

    // Gunakan base64 jika ada, fallback ke gambar default
    // const imageUrl =
    //   product.image && product.image.startsWith("data:image/")
    //     ? product.image
    //     : "/frontend/assets/download.jpg";

    card.innerHTML = `
          <figure class="product-image-wrapper">
            <img src="${product.image}" alt="${product.name}" class="product-image" />
          </figure>
          <h3 class="product-title">${product.name}</h3>
          <button class="add-to-cart-btn">Masukkan keranjang</button>
        `;

    container.appendChild(card);
  });
}

document.addEventListener("DOMContentLoaded", fetchProducts);
