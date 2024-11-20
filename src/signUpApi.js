//url: https://api.countrystatecity.in/v1/countries
//APIKey: WHVLVXBHUFJLbldabGgyNDRndlpaM2lxMGFwUEVmZ3NDSUx1QUtDMQ==

var config = {
    cUrl: 'https://api.countrystatecity.in/v1/countries',
    ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
}
var countrySelect = document.querySelector('#country'),
    stateSelect = document.querySelector('#state'),
    citySelect = document.querySelector('#city')

//Fetch calling
/*
function loadCountries() {
    let apiEndPoint = config.cUrl
    fetch(apiEndPoint, { headers: { "X-CSCAPI-KEY": config.ckey } })
        .then(Response => Response.json())
        .then(data => {
            // console.log(data);
            data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.iso2
                option.textContent = country.name
                // option.value=country.name 
                countrySelect.appendChild(option)
            })
        })
        .catch(error => console.error('Error loading countries:', error))

    stateSelect.disabled = true
    citySelect.disabled = true
    // stateSelect.style.pointerEvents = 'none'
    // citySelect.style.pointerEvents = 'none'
}
// console.log(countrySelect.value)
// console.log(countrySelect.textContent)

function loadStates() {
    stateSelect.disabled = false
    citySelect.disabled = true
    // stateSelect.style.pointerEvents = 'auto'
    // citySelect.style.pointerEvents = 'none'

    const selectedCountryCode = countrySelect.value
    // console.log(countrySelect)
    // console.log(countrySelect.value)
    // console.log(countrySelect.textContent)
    // console.log(selectedCountryCode);
    stateSelect.innerHTML = '<option value="">Select State</option>' // for clearing the existing states
    citySelect.innerHTML = '<option value="">Select City</option>' // Clear existing city options

    fetch(`${config.cUrl}/${selectedCountryCode}/states`, { headers: { "X-CSCAPI-KEY": config.ckey } })
        .then(response => response.json())
        .then(data => {
            // console.log(data);

            data.forEach(state => {
                const option = document.createElement('option')
                option.value = state.iso2
                option.textContent = state.name
                // option.value=state.name 
                // console.log(option);
                stateSelect.appendChild(option)
            })
        })
        .catch(error => console.error('Error loading countries:', error))
}

function loadCities() {
    citySelect.disabled = false
    citySelect.style.pointerEvents = 'auto'
    const selectedCountryCode = countrySelect.value
    const selectedStateCode = stateSelect.value
    citySelect.innerHTML = '<option value="">Select City</option>' // Clear existing city options
    fetch(`${config.cUrl}/${selectedCountryCode}/states/${selectedStateCode}/cities`, { headers: { "X-CSCAPI-KEY": config.ckey } })
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            data.forEach(city => {
                const option = document.createElement('option')
                option.value = city.iso2
                option.textContent = city.name
                option.value = city.name
                // console.log(option);
                citySelect.appendChild(option)
            })
        })
}

window.onload = loadCountries;
*/



//AJAX Calling
function loadCountries() {
    let apiEndPoint = config.cUrl;
    // Instantiate an xhr object
    let xhr = new XMLHttpRequest();
    // Open the object
    xhr.open('GET', apiEndPoint, true);
    xhr.setRequestHeader("X-CSCAPI-KEY", config.ckey);
    // What to do when response is ready
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let data = JSON.parse(xhr.responseText);
            data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.iso2;
                option.textContent = country.name;
                countrySelect.appendChild(option);
            });
        } else if (xhr.readyState === 4) {
            console.error('Error loading countries:', xhr.statusText);
        }
    };
    // send the request
    xhr.send();

    stateSelect.disabled = true;
    citySelect.disabled = true;
}

function loadStates() {
    stateSelect.disabled = false;
    citySelect.disabled = true;
    const selectedCountryCode = countrySelect.value;
    stateSelect.innerHTML = '<option value="">Select State</option>';
    citySelect.innerHTML = '<option value="">Select City</option>';

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
                stateSelect.appendChild(option);
            });
        } else if (xhr.readyState === 4) {
            console.error('Error loading states:', xhr.statusText);
        }
    };
    xhr.send();
}

function loadCities() {
    citySelect.disabled = false;
    const selectedCountryCode = countrySelect.value;
    const selectedStateCode = stateSelect.value;
    citySelect.innerHTML = '<option value="">Select City</option>';

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
                citySelect.appendChild(option);
            });
        } else if (xhr.readyState === 4) {
            console.error('Error loading cities:', xhr.statusText);
        }
    };
    xhr.send();
}

window.onload = loadCountries;
