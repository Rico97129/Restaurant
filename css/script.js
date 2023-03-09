//  // JavaScript to retrieve address details from API
//  const ADDOK_URL = 'https://api-adresse.data.gouv.fr/search/';
//  const inputAdresse = document.getElementById('adresse');
//  inputAdresse.addEventListener('input', function(event) {
//    const query = event.target.value;
//    if (query.length > 2) {
//      const params = { q: query };
//      const url = ADDOK_URL + '?' + new URLSearchParams(params);
//      fetch(url)
//        .then(response => response.json())
//        .then(data => {
//          const addresses = data.features.map(feature => feature.properties.label);
//          const datalist = document.getElementById('addresses');
//          if (datalist) {
//            datalist.innerHTML = '';
//            addresses.forEach(address => {
//              const option = document.createElement('option');
//              option.value = address;
//              datalist.appendChild(option);
//            });
//          }
//        });
//    }
//  });
 