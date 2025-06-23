<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Holidays</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Anton&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #222;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
        }

        .topbar {
            width: 100%;
            max-width: 900px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .topbar h1 {
            font-size: 2.5rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #222;
        }

        .dropdowns {
            display: flex;
            gap: 1rem;
        }

        .dropdowns select {
            appearance: none;
            background-color: transparent;
            color: #333;
            font-size: 1rem;
            padding: 0.5rem 0.75rem;
            border: none;
            border-bottom: 2px solid #ccc;
            transition: border-color 0.2s ease;
            font-weight: 500;
        }

        .dropdowns select:focus {
            outline: none;
            border-bottom-color: #6bc7a8;
        }

        #mainHoliday {
            font-family: 'Anton', sans-serif;
            font-size: 3.5rem;
            color:rgb(151, 15, 15);
            text-align: center;
            margin-top: 8rem;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
        }

        #mainType {
            font-size: 2rem;
            color: rgb(151, 15, 15);
            margin-bottom: 2.5rem;
            text-align: center;
            text-transform: uppercase;
        }

        .others {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            width: 100%;
            max-width: 900px;
            padding: 0 1rem 2rem;
        }

        .others div {
            font-size: 1.1rem;
            color: #089e9e;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0.5rem;
            line-height: 1.4;
            font-weight: 500;
            text-transform: uppercase;
        }

        .others div small {
            font-size: 0.85rem;
            color: #777;
            margin-top: 0.3rem;
            display: block;
            text-transform: none;
        }
    </style>
</head>
<body>

    <div class="topbar">
        <h1>Next Public Holidays</h1>
        <div class="dropdowns">
            <select id="countrySelect"></select>
            <select id="languageSelect">
                <option value="EN">English</option>
                <option value="ES">Español</option>
                <option value="DE">Deutsch</option>
            </select>
        </div>
    </div>

    <div id="mainHoliday">Loading...</div>
    <div id="mainType"></div>
    <div class="others" id="otherHolidays"></div>

    <script type="module">
        let country = 'DE';
        let language = 'EN';

        const countrySelect = document.getElementById('countrySelect');
        const languageSelect = document.getElementById('languageSelect');
        const mainHoliday = document.getElementById('mainHoliday');
        const mainType = document.getElementById('mainType');
        const otherHolidays = document.getElementById('otherHolidays');

        const loadCountries = async () => {
            try {
                const { data = [] } = await fetch(`/api/countries?languageIsoCode=${language}`).then(r => r.json());
                countrySelect.innerHTML = data.map(c => {
                    const name = c.name.find(n => n.language === language)?.text ?? c.name[0].text;
                    return `<option value="${c.isoCode}" ${c.isoCode === country ? 'selected' : ''}>${name}</option>`;
                }).join('');
            } catch (err) {
                console.error('Error loading countries', err);
            }
        };

        const loadHolidays = async () => {
            try {
                const res = await fetch(`/api/holidays/public?countryIsoCode=${country}&languageIsoCode=${language}&perPage=100`);
                const { data = [] } = await res.json();

                if (data.length) {
                    const [first, ...rest] = data;

                    mainHoliday.innerText = first.name?.[0]?.text?.toUpperCase() ?? 'UNNAMED';
                    mainType.innerHTML = `
                        ${first.type?.toUpperCase() ?? ''}
                        <br><small>${first.startDate ?? ''}</small>
                    `;

                    otherHolidays.innerHTML = rest.map(({ name, startDate }) => `
                        <div>
                            ${name?.[0]?.text ?? 'Unnamed'}
                            <small>${startDate}</small>
                        </div>
                    `).join('');
                } else {
                    mainHoliday.innerText = 'No holidays found.';
                    mainType.innerHTML = '';
                    otherHolidays.innerHTML = '';
                }
            } catch (error) {
                console.error('Error fetching holidays:', error);
                mainHoliday.innerText = 'Error loading holidays.';
                mainType.innerHTML = '';
                otherHolidays.innerHTML = '';
            }
        };

        languageSelect.addEventListener('change', (e) => {
            language = e.target.value;
            loadCountries();
            loadHolidays();
        });

        countrySelect.addEventListener('change', (e) => {
            country = e.target.value;
            loadHolidays();
        });

        loadCountries().then(loadHolidays);
    </script>
</body>
</html>
