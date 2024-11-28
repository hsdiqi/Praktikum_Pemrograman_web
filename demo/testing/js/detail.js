async function fetchProduct(id) {
  try {
    const response = await fetch(`http://localhost:8000/api/product/${id}}`);
    const data = await response.json();
    console.log(data);
  } catch (error) {
    console.error("Error fetching products:", error);
  }
}
