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
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            color: #222;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(94, 234, 212, 0.15), transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(20, 184, 166, 0.15), transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1200px;
        }

        .topbar {
            background: #ffffff;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            animation: fadeInDown 0.6s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .topbar h1 {
            font-size: 2.5rem;
            margin: 0;
            font-weight: 700;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .dropdowns {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .dropdowns select {
            appearance: none;
            background: #f7fafc;
            backdrop-filter: blur(5px);
            color: #2d3748;
            font-size: 0.95rem;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232d3748' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
        }

        .dropdowns select:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .dropdowns select:focus {
            outline: none;
            background: #ffffff;
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
        }

        .dropdowns select option {
            background: #ffffff;
            color: #2d3748;
        }

        .hero-card {
            background: linear-gradient(135deg, #5eead4 0%, #14b8a6 100%);
            border-radius: 30px;
            padding: 4rem 3rem;
            margin-bottom: 3rem;
            box-shadow: 0 10px 40px rgba(20, 184, 166, 0.3);
            border: 1px solid rgba(20, 184, 166, 0.2);
            text-align: center;
            animation: scaleIn 0.6s ease-out 0.2s both;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hero-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(20, 184, 166, 0.4);
        }

        #mainHoliday {
            font-family: 'Anton', sans-serif;
            font-size: 3.5rem;
            color: #ffffff;
            margin-bottom: 1rem;
            text-transform: uppercase;
            line-height: 1.2;
            letter-spacing: 2px;
            min-height: 4.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #mainType {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        #mainType small {
            display: block;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 0.75rem;
            letter-spacing: 1px;
            font-weight: 400;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
            color: #2d3748;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }

        .others {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }

        .holiday-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            cursor: default;
            position: relative;
            overflow: hidden;
        }

        .holiday-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(94, 234, 212, 0.05) 0%, rgba(20, 184, 166, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .holiday-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(20, 184, 166, 0.2);
            background: #ffffff;
            border-color: #14b8a6;
        }

        .holiday-card:hover::before {
            opacity: 1;
        }

        .holiday-card-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            position: relative;
            z-index: 1;
        }

        .holiday-card-date {
            font-size: 0.95rem;
            color: #718096;
            font-weight: 500;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        .loading {
            display: inline-block;
            font-size: 2rem;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                flex-direction: column;
                align-items: stretch;
                padding: 1.5rem;
            }

            .topbar h1 {
                font-size: 2rem;
                text-align: center;
            }

            .dropdowns {
                justify-content: center;
            }

            .dropdowns select {
                font-size: 0.9rem;
                padding: 0.65rem 2rem 0.65rem 0.85rem;
            }

            .hero-card {
                padding: 3rem 1.5rem;
            }

            #mainHoliday {
                font-size: 2.5rem;
            }

            #mainType {
                font-size: 1.2rem;
            }

            .others {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .topbar h1 {
                font-size: 1.75rem;
            }

            #mainHoliday {
                font-size: 2rem;
            }

            .dropdowns {
                flex-direction: column;
                width: 100%;
            }

            .dropdowns select {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1 style="cursor: pointer;">Next Holidays</h1>
            <div class="dropdowns">
                <select id="countrySelect"></select>
                <select id="subdivisionSelect" style="display:none"></select>
                <select id="languageSelect"></select>
                <select id="typeSelect">
                    <option value="public">{{ __('public') }}</option>
                    <option value="school">{{ __('school') }}</option>
                </select>
            </div>
        </div>

        <div class="hero-card">
            <div id="mainHoliday"><span class="loading">{{ __('loading') }}</span></div>
            <div id="mainType"></div>
        </div>

        <div class="section-title" id="upcomingTitle" style="display:none">{{ __('upcoming-holidays') }}</div>
        <div class="others" id="otherHolidays"></div>
    </div>

    <script type="module">
        // Load translations - dynamically load all language files
        const translations = @json(collect(glob(base_path('lang/*.json')))->mapWithKeys(function($path) {
            $lang = strtoupper(pathinfo($path, PATHINFO_FILENAME));
            return [$lang => json_decode(file_get_contents($path), true)];
        }));

        // Translation helper function
        const __ = (key) => {
            return translations[language]?.[key] ?? key;
        };

        let country = 'IE';
        let language = 'EN';
        let type = 'public';
        let subdivision = null;
        let hasSubdivisions = false;

        const countrySelect = document.getElementById('countrySelect');
        const subdivisionSelect = document.getElementById('subdivisionSelect');
        const languageSelect = document.getElementById('languageSelect');
        const typeSelect = document.getElementById('typeSelect');
        const mainHoliday = document.getElementById('mainHoliday');
        const mainType = document.getElementById('mainType');
        const otherHolidays = document.getElementById('otherHolidays');
        const upcomingTitle = document.getElementById('upcomingTitle');

        // Load languages
        const loadLanguages = async () => {
            try {
                const { data = [] } = await fetch('/api/languages').then(r => r.json());
                languageSelect.innerHTML = data.map(lang => {
                    const name = lang.name.find(n => n.language === language)?.text ?? lang.name[0].text;
                    return `<option value="${lang.isoCode}" ${lang.isoCode === language ? 'selected' : ''}>${name}</option>`;
                }).join('');
            } catch (err) {
                console.error('Error loading languages', err);
            }
        };

        // Update UI texts based on current language
        const updateUITexts = () => {
            // Update page title (not the h1, that's the app name)
            document.title = __('upcoming-holidays');
            upcomingTitle.innerText = __('upcoming-holidays');

            // Update type select options while preserving selection
            const currentType = typeSelect.value;
            typeSelect.options[0].text = __('public');
            typeSelect.options[1].text = __('school');
            typeSelect.value = currentType; // Restore selection

            // Reload subdivisions to update "All regions" text if visible
            if (hasSubdivisions && subdivisionSelect.style.display !== 'none') {
                loadSubdivisions(true);
            }

            // Reload languages to update language names in current language
            loadLanguages();
        };

        // Load countries
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

        // Load subdivisions/regions for selected country
        const loadSubdivisions = async (preserveSelection = false) => {
            const previousSubdivision = preserveSelection ? subdivision : null;
            subdivision = null; // Reset current selection
            subdivisionSelect.style.display = 'none';
            subdivisionSelect.innerHTML = '';
            hasSubdivisions = false;

            try {
                const { data = [] } = await fetch(`/api/subdivisions?countryIsoCode=${country}&languageIsoCode=${language}`).then(r => r.json());
                hasSubdivisions = data.length > 0;

                if (hasSubdivisions) {
                    subdivisionSelect.innerHTML =
                        (type === 'public' ? `<option value="">${__('all-regions')}</option>` : '') +
                        data.map(sub => {
                            const name = sub.name.find(n => n.language === language)?.text ?? sub.name[0].text;
                            const selected = previousSubdivision && sub.code === previousSubdivision ? 'selected' : '';
                            return `<option value="${sub.code}" ${selected}>${name}</option>`;
                        }).join('');
                    subdivisionSelect.style.display = '';

                    // Restore the previous selection if it exists
                    if (previousSubdivision && data.find(sub => sub.code === previousSubdivision)) {
                        subdivision = previousSubdivision;
                    }
                }
            } catch (err) {
                console.error('Error loading subdivisions', err);
            }
        };

        // Load holidays, considering current selections
        const loadHolidays = async () => {
            try {
                // Show loading state
                mainHoliday.innerHTML = `<span class="loading">${__('loading')}</span>`;
                mainType.innerHTML = '';
                otherHolidays.innerHTML = '';
                upcomingTitle.style.display = 'none';

                const isSchool = type === 'school';
                if (isSchool && hasSubdivisions && !subdivision) {
                    mainHoliday.innerText = __('please-select-a-region-for-school-holidays');
                    mainType.innerHTML = '';
                    otherHolidays.innerHTML = '';
                    return;
                }

                let url = `/api/holidays/${type}?countryIsoCode=${country}&languageIsoCode=${language}&perPage=100`;
                if (subdivision) {
                    url += `&subdivisionCode=${subdivision}`;
                }

                const res = await fetch(url);
                const { data = [] } = await res.json();

                if (data.length) {
                    const [first, ...rest] = data;
                    mainHoliday.innerText = first.name?.[0]?.text?.toUpperCase() ?? __('unnamed');

                    // Format date range
                    const formatDateRange = (startDate, endDate) => {
                        if (!startDate) return '';
                        if (!endDate || startDate === endDate) return startDate;
                        return `${startDate} - ${endDate}`;
                    };

                    mainType.innerHTML = `
                        ${first.type ? __(first.type.toLowerCase()).toUpperCase() : ''}
                        <small>${formatDateRange(first.startDate, first.endDate)}</small>
                    `;

                    if (rest.length > 0) {
                        upcomingTitle.style.display = 'block';
                        otherHolidays.innerHTML = rest.map(({ name, startDate, endDate }) => `
                            <div class="holiday-card">
                                <div class="holiday-card-name">${name?.[0]?.text ?? __('unnamed-2')}</div>
                                <div class="holiday-card-date">${formatDateRange(startDate, endDate)}</div>
                            </div>
                        `).join('');
                    }
                } else {
                    mainHoliday.innerText = __('no-holidays-found');
                    mainType.innerHTML = '';
                    otherHolidays.innerHTML = '';
                }
            } catch (error) {
                console.error('Error fetching holidays:', error);
                mainHoliday.innerText = __('error-loading-holidays');
                mainType.innerHTML = '';
                otherHolidays.innerHTML = '';
            }
        };

        // Event listeners
        // Click on h1 to refresh page
        document.querySelector('.topbar h1').addEventListener('click', () => {
            window.location.reload();
        });

        languageSelect.addEventListener('change', async (e) => {
            language = e.target.value;
            updateUITexts(); // Update all UI texts to new language
            loadCountries();
            await loadSubdivisions(true); // Preserve subdivision selection when changing language
            loadHolidays();
        });

        countrySelect.addEventListener('change', async (e) => {
            country = e.target.value;
            await loadSubdivisions();
            loadHolidays();
        });

        typeSelect.addEventListener('change', (e) => {
            type = e.target.value;
            loadHolidays();
        });

        subdivisionSelect.addEventListener('change', (e) => {
            subdivision = e.target.value || null;
            loadHolidays();
        });

        // Initial load
        loadLanguages().then(() => {
            updateUITexts(); // Set initial UI texts
            loadCountries().then(() => {
                loadSubdivisions();
                loadHolidays();
            });
        });
    </script>
</body>
</html>
