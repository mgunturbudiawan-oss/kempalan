/**
 * Header Features: Weather & Date with BMKG Data
 */
(function() {
    'use strict';

    // List of Cities/Regencies in East Java (matching BMKG XML names)
    const eastJavaCities = [
        'Bangkalan', 'Banyuwangi', 'Batu', 'Blitar', 'Bojonegoro', 
        'Bondowoso', 'Gresik', 'Jember', 'Jombang', 'Kediri', 
        'Lamongan', 'Lumajang', 'Madiun', 'Magetan', 'Mojokerto', 
        'Nganjuk', 'Ngawi', 'Pacitan', 'Pamekasan', 'Pasuruan', 
        'Ponorogo', 'Probolinggo', 'Sampang', 'Sidoarjo', 'Situbondo', 
        'Sumenep', 'Surabaya', 'Trenggalek', 'Tuban', 'Tulungagung', 'Malang'
    ].sort();

    const storageKey = 'haliyora_selected_city';
    let currentCity = localStorage.getItem(storageKey) || 'Surabaya';

    /**
     * Map BMKG Code to Icon & Color
     */
    function getWeatherIcon(code) {
        const mapping = {
            '0': { icon: 'fas fa-sun', color: '#ff9800' },
            '1': { icon: 'fas fa-cloud-sun', color: '#ffb74d' },
            '2': { icon: 'fas fa-cloud-sun', color: '#ffb74d' },
            '3': { icon: 'fas fa-cloud', color: '#90a4ae' },
            '4': { icon: 'fas fa-cloud', color: '#546e7a' },
            '5': { icon: 'fas fa-smog', color: '#b0bec5' },
            '10': { icon: 'fas fa-smog', color: '#b0bec5' },
            '45': { icon: 'fas fa-smog', color: '#b0bec5' },
            '60': { icon: 'fas fa-cloud-rain', color: '#42a5f5' },
            '61': { icon: 'fas fa-cloud-rain', color: '#42a5f5' },
            '63': { icon: 'fas fa-cloud-showers-heavy', color: '#1e88e5' },
            '80': { icon: 'fas fa-cloud-rain', color: '#42a5f5' },
            '95': { icon: 'fas fa-bolt', color: '#fdd835' },
            '97': { icon: 'fas fa-bolt', color: '#fdd835' }
        };
        return mapping[code] || { icon: 'fas fa-sun', color: '#ff9800' };
    }

    function updateWeatherUI(city) {
        console.log('Updating weather for:', city);
        const weatherContainer = document.getElementById('header-weather');
        if (!weatherContainer) return;

        const tempElement = weatherContainer.querySelector('.weather-temp');
        const iconElement = weatherContainer.querySelector('.weather-icon');
        const cityDisplay = document.getElementById('current-weather-city');

        // Get data from localized BMKG data
        const data = window.bmkgWeatherData ? window.bmkgWeatherData[city.toLowerCase()] : null;
        console.log('BMKG Data for ' + city + ':', data);

        if (cityDisplay) {
            cityDisplay.innerHTML = `${city} <i class="fas fa-chevron-down" style="font-size: 10px;"></i>`;
        }

        if (data && data.temp && data.temp !== 'N/A') {
            const weather = getWeatherIcon(data.code);
            if (tempElement) tempElement.textContent = `${data.temp}°C`;
            if (iconElement) {
                iconElement.innerHTML = `<i class="${weather.icon}" style="color: ${weather.color}; font-size: 18px; margin-left: 5px;" title="${data.description}"></i>`;
            }
        } else {
            console.log('No valid weather data found for ' + city);
            if (tempElement) tempElement.textContent = '--°C';
            if (iconElement) iconElement.innerHTML = '';
        }
    }

    function initCityDropdown() {
        const cityDisplay = document.getElementById('current-weather-city');
        const dropdown = document.getElementById('weather-city-dropdown');
        if (!cityDisplay || !dropdown) return;

        // Populate dropdown
        dropdown.innerHTML = eastJavaCities.map(city => 
            `<div class="weather-dropdown-item" data-city="${city}">${city}</div>`
        ).join('');

        // Toggle dropdown
        cityDisplay.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropdown.classList.toggle('active');
        };

        // Handle city selection
        dropdown.onclick = function(e) {
            const item = e.target.closest('.weather-dropdown-item');
            if (item) {
                const selectedCity = item.getAttribute('data-city');
                currentCity = selectedCity;
                localStorage.setItem(storageKey, selectedCity);
                updateWeatherUI(selectedCity);
                dropdown.classList.remove('active');
            }
        };

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && !cityDisplay.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }

    // Initialize
    const start = () => {
        initCityDropdown();
        updateWeatherUI(currentCity);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        setTimeout(start, 200);
    }

})();
