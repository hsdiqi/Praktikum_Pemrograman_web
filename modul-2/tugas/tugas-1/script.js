let currentInput = "";
let previousInput = "";
let operator = "";
let calculationString = "";

let a = 1;
let b = 2;
let c = a + b;
console.log(c);

const screen = document.getElementById("screen");
const calculationDisplay = document.getElementById("calculation");

function updateScreen(value) {
  screen.textContent = value;
}

function updateCalculationDisplay(value) {
  calculationDisplay.textContent = value;
}

// Handle angka yang ditekan
document.querySelectorAll(".number").forEach((button) => {
  button.addEventListener("click", () => {
    currentInput += button.dataset.number;
    calculationString += button.dataset.number;
    updateScreen(currentInput);
    updateCalculationDisplay(calculationString);
    console.log("current input: ", currentInput);
    console.log("kalkulasi: ",  calculationString);
  });
});

// Handle operator yang ditekan
document.querySelectorAll(".operator").forEach((button) => {
  button.addEventListener("click", () => {
    if (currentInput === "") return;
    operator = button.dataset.operator;
    previousInput = currentInput;
    currentInput = "";
    calculationString += ` ${operator} `;
    updateCalculationDisplay(calculationString);
    console.log("pinput sebelumnya: " + previousInput);
    console.log("operator: " + operator);
    console.log("current: " + currentInput);
  });
});

// Handle tombol "=" untuk menghitung
document.getElementById("equal").addEventListener("click", () => {
  if (previousInput === "" || currentInput === "" || operator === "") return;

  let result = 0; // Inisialisasi result dengan nilai default
  let prev = parseFloat(previousInput);
  let curr = parseFloat(currentInput);

  console.log("   ");
  console.log("__equal clicked__");
  console.log("Previous Input:", prev);
  console.log("Current Input:", curr);
  console.log("Operator digunakan:", operator);

  switch (operator) {
    case "+":
      result = prev + curr;
      break;
    case "-":
      result = prev - curr;
      break;
    case "*":
      result = prev * curr;
      break;
    case "/":
      if (curr === 0) {
        result = "Error"; // Menangani pembagian dengan nol
      } else {
        result = prev / curr;
      }
      break;
    case "%":
      result = prev % curr;
      break;
    case "**":
      result = Math.pow(prev, curr);
      break;
    default:
      result = "Error"; // Menangani operator tidak dikenal
  }

  currentInput = result.toString();
  updateScreen(currentInput);
  calculationString += ` = ${currentInput}`;
  updateCalculationDisplay(calculationString);
  console.log("hasil :", result);


  // Reset setelah perhitungan
  previousInput = "";
  operator = "";
  calculationString = "";
});

// Handle tombol "C" untuk reset
document.getElementById("clear").addEventListener("click", () => {
  currentInput = "";
  previousInput = "";
  operator = "";
  calculationString = "";
  updateScreen("");
  updateCalculationDisplay("");
  console.log("clear clicked")
});

// Handle tombol desimal
document.querySelector(".decimal").addEventListener("click", () => {
  if (!currentInput.includes(".")) {
    currentInput += ".";
    calculationString += ".";
    updateScreen(currentInput);
    updateCalculationDisplay(calculationString);
  }
});
