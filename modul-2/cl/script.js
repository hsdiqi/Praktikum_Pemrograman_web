document.querySelector("#jumlah").addEventListener("click", () => {
    let first = document.getElementById("first").value;
    let second = document.getElementById("second").value;

    if (first === "" || second === "") {
        return alert("Kolom tidak boleh kosong!");
    } else {
        let hasil = parseInt(first) + parseInt(second);
        document.getElementById("hasil").innerText = hasil;
        console.log(hasil);
    }
});

document.querySelector("#reset").addEventListener("click", () => {
    document.getElementById("first").value = "";
    document.getElementById("second").value = "";
    document.getElementById("hasil").innerText = "0";
});
