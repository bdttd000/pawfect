const select = document.getElementById('select');
let value = select.value;
const title = document.getElementById('search-title');
const cardContainer = document.getElementById('card-container');

setInterval(function() {
    if (document.getElementById('select').value === value) return;
    value = select.value;
    text = select.options[select.selectedIndex].text

    fetch("/changeCity", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: value
    }).then((response) => {
        return response.json()
    }).then((result) => {
        cardContainer.innerHTML = '';
        loadPets(result);
        title.innerHTML = "zwierzęta dla miasta " + text;
    });
}, 100);

function loadPets(pets) {
    for (pet of pets) {
        createCard(pet)
    };
}

function createCard(pet) {
    const template = document.querySelector("#card-template");
    const clone = template.content.cloneNode(true);

    const image = clone.querySelector("img");
    image.src = `public/uploads/${pet.directory_url}/${pet.avatar_url}`;

    const name = clone.querySelector("h3");
    name.innerHTML = pet.name;

    const description = clone.querySelector("h4");
    description.innerHTML = pet.description.length > 50 ? pet.description.substr(0,50) + '...' : pet.description; 

    const link = clone.querySelector("a");
    link.href = `pet?id=${pet.pet_id}`;

    cardContainer.appendChild(clone);
}