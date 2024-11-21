async function tesFetch() {
  const response = await fetch("http://localhost:8000/api/allProducts");

  if (!response.ok) {
    throw new Error(`HTTP error! Status: ${response.status}`);
  }

  const text = await response.text();
  console.log(text); // Lihat apakah respons berupa JSON atau ada error HTML

  let data;
  try {
    data = JSON.parse(text);
  } catch (parseError) {
    console.error("Error parsing JSON:", parseError);
    return;
  }

  console.log(data);
}
