document.getElementById('addProductForm').addEventListener('submit', async function(event) {
  event.preventDefault();

  // Ambil data dari form
  const formData = new FormData(event.target);
  const productData = {};

  formData.forEach((value, key) => {
      // Pastikan untuk menangani gambar dengan benar
      if (key === "image") {
          // Mengonversi gambar ke base64
          const reader = new FileReader();
          reader.readAsDataURL(value);
          reader.onload = async function () {
              // Tunggu hingga gambar dikonversi dan kirim data
              productData[key] = reader.result.split(',')[1]; // Mengambil bagian base64 setelah ","
              await sendProductData(productData);
          }
      } else {
          productData[key] = value;
      }
  });
});

// Kirim data ke server
async function sendProductData(productData) {
  try {
      const response = await fetch('http://localhost:8000/api/addProduct', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify(productData),
      });
      console.log(productData)

      if (!response.ok) {
          throw new Error('Gagal menambahkan produk');
      }

      const result = await response.json();
      document.getElementById('responseMessage').innerHTML = `<p class="success">Produk berhasil ditambahkan!</p>`;
      document.getElementById('addProductForm').reset();
  } catch (error) {
      console.error('Error:', error);
      document.getElementById('responseMessage').innerHTML = `<p class="error">Terjadi kesalahan: ${error.message}</p>`;
  }
}




// document.getElementById('addProductForm').addEventListener('submit', async function (event) {
//     event.preventDefault();

//     // Ambil data dari form
//     const formData = new FormData(event.target); // FormData otomatis menangani file input

//     try {
//         const response = await fetch('http://localhost:8000/api/addProduct', {
//             method: 'POST',
//             body: formData, // Kirim langsung FormData
//         });

//         if (!response.ok) {
//             throw new Error('Gagal menambahkan produk');
//         }
//         console.log(formData);
//         console.log(response)

//         const result = await response.json();
//         console.log(result)
//         document.getElementById('responseMessage').innerHTML = `<p class="success">Produk berhasil ditambahkan!</p>`;
//         document.getElementById('addProductForm').reset();
//     } catch (error) {
//         console.error('Error:', error);
//         document.getElementById('responseMessage').innerHTML = `<p class="error">Terjadi kesalahan: ${error.message}</p>`;
//     }
// });
