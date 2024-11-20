// Pre-existing data (these should be dynamically assigned)
var config = {
    cUrl: 'https://api.countrystatecity.in/v1/countries',
    ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
}

// Selecting the elements in the DOM
var countrySelect = document.querySelector('#country');
var stateSelect = document.querySelector('#state');
var citySelect = document.querySelector('#city');

// Pre-existing data for the initial selections
const initialCountry = document.getElementsByClassName('d1')[9].innerText; 
const initialState = document.getElementsByClassName('d1')[10].innerText;
const initialCity = document.getElementsByClassName('d1')[11].innerText;

//fetch calling
/*
function loadCountries() {
    let apiEndPoint = config.cUrl;

    fetch(apiEndPoint, { headers: { "X-CSCAPI-KEY": config.ckey } })
        .then(response => response.json())
        .then(data => {
            data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.iso2;
                option.textContent = country.name;
                if (country.iso2 === initialCountry) option.selected = true;
                countrySelect.appendChild(option);
            });
            loadStates(); // Load states after countries
        })
        .catch(error => console.error('Error loading countries:', error));

    stateSelect.disabled = true;
    citySelect.disabled = true;
}

function loadStates() {
    stateSelect.disabled = false;
    stateSelect.innerHTML = '<option value="">Select State</option>';
    citySelect.innerHTML = '<option value="">Select City</option>';

    const selectedCountryCode = countrySelect.value;
    console.log(countrySelect.value);


    fetch(`${config.cUrl}/${selectedCountryCode}/states`, { headers: { "X-CSCAPI-KEY": config.ckey } })
        .then(response => response.json())
        .then(data => {
            data.forEach(state => {
                const option = document.createElement('option');
                option.value = state.iso2;
                option.textContent = state.name;
                if (state.iso2 === initialState) option.selected = true;
                stateSelect.appendChild(option);
            });
            loadCities(); // Load cities after states
        })
        .catch(error => console.error('Error loading states:', error));
}

function loadCities() {
    citySelect.disabled = false;
    citySelect.innerHTML = '<option value="">Select City</option>';

    const selectedCountryCode = countrySelect.value;
    const selectedStateCode = stateSelect.value;
    console.log(countrySelect.value, stateSelect.value);

    fetch(`${config.cUrl}/${selectedCountryCode}/states/${selectedStateCode}/cities`, { headers: { "X-CSCAPI-KEY": config.ckey } })
        .then(response => response.json())
        .then(data => {
            data.forEach(city => {
                const option = document.createElement('option');
                option.value = city.name;
                option.textContent = city.name;
                if (city.name === initialCity) option.selected = true;
                citySelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading cities:', error));
}

loadCountries(); // Start the chain by loading countries
*/


//AJAX calling
function loadCountries() {
    let apiEndPoint = config.cUrl;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', apiEndPoint, true);
    xhr.setRequestHeader("X-CSCAPI-KEY", config.ckey);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let data = JSON.parse(xhr.responseText);
            data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.iso2;
                option.textContent = country.name;
                if (country.iso2 === initialCountry) option.selected = true;
                countrySelect.appendChild(option);
            });
            loadStates(); // Load states after countries
        } else if (xhr.readyState === 4) {
            console.error('Error loading countries:', xhr.statusText);
        }
    };
    xhr.send();

    stateSelect.disabled = true;
    citySelect.disabled = true;
}

function loadStates() {
    stateSelect.disabled = false;
    stateSelect.innerHTML = '<option value="">Select State</option>';
    citySelect.innerHTML = '<option value="">Select City</option>';

    const selectedCountryCode = countrySelect.value;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `${config.cUrl}/${selectedCountryCode}/states`, true);
    xhr.setRequestHeader("X-CSCAPI-KEY", config.ckey);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let data = JSON.parse(xhr.responseText);
            data.forEach(state => {
                const option = document.createElement('option');
                option.value = state.iso2;
                option.textContent = state.name;
                if (state.iso2 === initialState) option.selected = true;
                stateSelect.appendChild(option);
            });
            loadCities(); // Load cities after states
        } else if (xhr.readyState === 4) {
            console.error('Error loading states:', xhr.statusText);
        }
    };
    xhr.send();
}

function loadCities() {
    citySelect.disabled = false;
    citySelect.innerHTML = '<option value="">Select City</option>';

    const selectedCountryCode = countrySelect.value;
    const selectedStateCode = stateSelect.value;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `${config.cUrl}/${selectedCountryCode}/states/${selectedStateCode}/cities`, true);
    xhr.setRequestHeader("X-CSCAPI-KEY", config.ckey);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let data = JSON.parse(xhr.responseText);
            data.forEach(city => {
                const option = document.createElement('option');
                option.value = city.name;
                option.textContent = city.name;
                if (city.name === initialCity) option.selected = true;
                citySelect.appendChild(option);
            });
        } else if (xhr.readyState === 4) {
            console.error('Error loading cities:', xhr.statusText);
        }
    };
    xhr.send();
}

loadCountries(); // Start the chain by loading countries
