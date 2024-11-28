async function fetchProducts() {
  try {
    const response = await fetch("http://localhost:8000/api/allProducts"); // URL ke backend PHP
    const data = await response.json();
    console.log(data);

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
function isValidBase64(data) {
  // Pola validasi Base64
  const base64Pattern =
    /^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?$/;
  return base64Pattern.test(data);
}

function normalizeBase64(base64String) {
  // Pastikan string dimulai dengan prefix Base64 untuk gambar JPEG
  const prefix = "data:image/jpeg;base64,";

  if (base64String.startsWith(prefix)) {
    const payload = base64String.slice(prefix.length); // Ambil bagian setelah prefix
    // Cek apakah payload dimulai dengan "/"
    if (!payload.startsWith("/")) {
      return `${prefix}/9j/${payload}`; // Tambahkan "/" jika belum ada
    }
    return base64String; // Kembalikan string asli jika sudah sesuai
  }

  throw new Error(
    "Invalid Base64 prefix. The string must start with 'data:image/jpeg;base64,'"
  );
}

function renderCards(products, section) {
  const container = document.querySelector(`.products-section .product-grid`);
  if (section === "Terbaru") {
    container.innerHTML = "";
  }

  products.forEach((product) => {
    const card = document.createElement("article");
    card.className = "product-card";

    let imageUrl = "assets/download.jpg"; // Default image

    try {
      // Normalisasi dan validasi gambar Base64
      if (product.image && product.image.startsWith("data:image/")) {
        const normalizedImage = normalizeBase64(product.image);
        const payload = normalizedImage.split(",")[1]; // Ambil payload untuk validasi

        if (isValidBase64(payload)) {
          imageUrl = normalizedImage; // Gunakan gambar yang sudah dinormalisasi
        }
      }
    } catch (error) {
      console.warn(`Invalid image for product ${product.name}:`, error.message);
    }

    // card.innerHTML = `
    //       <figure class="product-image-wrapper">
    //         <img src="${imageUrl}" alt="${product.name}" class="product-image" />
    //       </figure>
    //       <h2 >ID: ${product.id}</h2>
    //       <h3 class="product-title">${product.name}</h3>
    //       <button class="add-to-cart-btn">Masukkan keranjang</button>
    //     `;
    card.innerHTML = `
  <figure class="product-image-wrapper">
    <img src="${imageUrl}" alt="${product.name}" class="product-image" />
  </figure>
  <h2>ID: ${product.id}</h2>
  <h3 class="product-title">${product.name}</h3>
  <button class="add-to-cart-btn">Masukkan keranjang</button>
`;

    // Tambahkan event listener ke seluruh card
    card.style.cursor = "pointer"; // Opsional: Ubah kursor jadi pointer saat hover
    card.addEventListener("click", () => {
      window.location.href = `/demo/frontend/page/detail.html?id=${product.id}`;
    });

    container.appendChild(card);
  });
}

// function renderCards(products, section) {
//   const container = document.querySelector(`.products-section .product-grid`);
//   if (section === "Terbaru") {
//     container.innerHTML = "";
//   }

//   products.forEach((product) => {
//     const card = document.createElement("article");
//     card.className = "product-card";

//     // Gunakan base64 jika ada, fallback ke gambar default
//     // const imageUrl =
//     //   product.image && product.image.startsWith("data:image/")
//     //     ? product.image
//     //     : "/frontend/assets/download.jpg";

//     card.innerHTML = `
//           <figure class="product-image-wrapper">
//             <img src="${product.image}" alt="${product.name}" class="product-image" />
//           </figure>
//           <h2 >ID: ${product.id}</h2>
//           <h3 class="product-title">${product.name}</h3>
//           <button class="add-to-cart-btn">Masukkan keranjang</button>
//         `;

//     container.appendChild(card);
//   });
// }

document.addEventListener("DOMContentLoaded", fetchProducts);
