
function printDetails() {
    const type = document.querySelector('input[name="type"]').value;
    const name = document.querySelector('title').innerText;
    const release_date = document.querySelector('h6').innerText;

    alert(`${type} ${name} ${release_date}`);
}

// document.getElementById('addBtn').addEventListener('click', printDetails);